<link href="{{ public_asset('/aerovia/style-aev.css') }}" rel="stylesheet" />
@if(isset($flights) && $flights > 0 || !isset($flights) && count($mapAirports) > 0 || !isset($flights) && count($mapHubs) > 0)
    <div class="mx-auto" style="max-width: 100%;">
      <div class="modal-content shadow-none p-0">
        <div class="modal-body border-0 p-0" style="height: 100vh;">
          <div id="{{ $mapsource }}" style="width: 100%; height: 100%;"></div>
        </div>
        <div class="modal-footer border-0 p-0 small text-end">
          <span>
            @if(count($mapCityPairs) > 0)
              @lang('DBasic::widgets.citypairs'): {{ count($mapCityPairs) }} |
            @endif
            @lang('DBasic::widgets.hubs'): {{ count($mapHubs) }} |
            @lang('DBasic::widgets.airports'): {{ count($mapAirports) }}
            @if(isset($flights))
              | {{ trans_choice('common.flight', 2) }}: {{ $flights }}
            @endif
            @if(isset($aircraft))
              | @lang('common.aircraft'): {{ $aircraft }}
            @endif
          </span>
        </div>
      </div>
    </div>

  @section('scripts')
    @parent
    {{-- Map Leaflet Script --}}
    <script src="https://elfalem.github.io/Leaflet.curve/src/leaflet.curve.js"></script>
    <script type="text/javascript">
        // Build Icons
        var RedIcon = new L.Icon({!! $mapIcons['RedIcon'] !!});
        var GreenIcon = new L.Icon({!! $mapIcons['GreenIcon'] !!});
        var BlueIcon = new L.Icon({!! $mapIcons['BlueIcon'] !!});
        var YellowIcon = new L.Icon({!! $mapIcons['YellowIcon'] !!});
        // Build Map Boundary, Hubs and Airports Layer Group
        var mBoundary = L.featureGroup();
        var mHubs = L.layerGroup();
        var mAirports = L.layerGroup();
        @foreach ($mapHubs as $hub)
          var HUB_{{ $hub['id'] }} = L.marker([{{ $hub['loc'] }}], {icon: GreenIcon , opacity: 0.8}).bindPopup({!! "'".$hub['pop']."'" !!}).addTo(mHubs).addTo(mBoundary);
        @endforeach
        @foreach ($mapAirports as $airport)
          var APT_{{ $airport['id'] }} = L.marker([{{ $airport['loc'] }}], {icon: BlueIcon , opacity: 0.8}).bindPopup({!! "'".$airport['pop']."'" !!}).addTo(mAirports)@if($mapsource === 'aerodromes' && $loop->first || $mapsource === 'aerodromes' && $loop->last).addTo(mBoundary)@elseif($mapsource != 'aerodromes').addTo(mBoundary)@endif;
        @endforeach
        // Build City Pairs / Flights Layer Group
        @if(count($mapCityPairs) > 0)
          var mFlights = L.layerGroup();
          @foreach ($mapCityPairs as $citypair)
            @if($citypair['pop'])
            //CURVA
            var latlngs = [];
            
            var latlng1 = [{{$citypair['lmdeplat']}}, {{$citypair['lmdeplon']}}],
              latlng2 = [{{$citypair['lmarrlat']}}, {{$citypair['lmarrlon']}}];
            
            var offsetX = latlng2[1] - latlng1[1],
              offsetY = latlng2[0] - latlng1[0];
            
            var r = Math.sqrt(Math.pow(offsetX, 2) + Math.pow(offsetY, 2)),
              theta = Math.atan2(offsetY, offsetX);
            
            var thetaOffset = (3.14 / 10);
            
            var r2 = (r / 2) / (Math.cos(thetaOffset)),
              theta2 = theta + thetaOffset;
            
            var midpointX = (r2 * Math.cos(theta2)) + latlng1[1],
              midpointY = (r2 * Math.sin(theta2)) + latlng1[0];
            
            var midpointLatLng = [midpointY, midpointX];
            
            latlngs.push(latlng1, midpointLatLng, latlng2);
            
            var pathOptions = {
              color: '{{$citypair['geoc']}}',
              weight: 2
            }
            
            var FLT_{{ $citypair['name'] }} = L.curve(
              [
                'M', latlng1,
                'Q', midpointLatLng,
                latlng2
              ], pathOptions).bindPopup({!! "'".$citypair['pop']."'" !!}).addTo(mFlights);
            @else
              var FLT_{{ $citypair['name'] }} = L.geodesic([{{ $citypair['geod'] }}], {weight: 2, opacity: 0.8, steps: 5, color: '{{$citypair['geoc']}}'}).addTo(mFlights);
            @endif
          @endforeach
        @endif
        // Define Base Layers For Control Box
        var DarkMatter = L.tileLayer.provider('CartoDB.DarkMatter');
        var NatGeo = L.tileLayer.provider('Esri.NatGeoWorldMap');
        var OpenSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
        var WorldTopo = L.tileLayer.provider('Esri.WorldTopoMap');
        // Define Additional Overlay Layers
        var OpenAIP = L.
          tileLayer('http://{s}.tile.maps.openaip.net/geowebcache/service/tms/1.0.0/openaip_basemap@EPSG%3A900913@png/{z}/{x}/{y}.{ext}', {
          attribution: '<a href="https://www.openaip.net/">openAIP Data</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-NC-SA</a>)',
          ext: 'png',
          minZoom: 4,
          maxZoom: 14,
          tms: true,
          detectRetina: true,
          subdomains: '12'
        });
        // Define Control Groups
        var BaseLayers = {'Dark Matter': DarkMatter, 'OpenSM Mapnik': OpenSM, 'NatGEO World': NatGeo, 'World Topo': WorldTopo};
        var Overlays = {'Hubs': mHubs, 'Airports': mAirports, @if(count($mapCityPairs) > 0) 'Flights': mFlights ,@endif 'OpenAIP Data': OpenAIP};
        // Define Map and Add Control Box
        var {{ $mapsource }} = L.map('{{ $mapsource }}', {center: [{{ $mapcenter }}], layers: [OpenSM, mHubs, mAirports, @if(count($mapCityPairs) > 0) mFlights @endif], scrollWheelZoom: false}).fitBounds(mBoundary.getBounds().pad(0.2));;
        L.control.layers(BaseLayers, Overlays).addTo({{ $mapsource }});
        // TimeOut to ReDraw The Map in Modal
        setTimeout(function(){ {{ $mapsource }}.invalidateSize().fitBounds(mBoundary.getBounds().pad(0.2))}, 300);
    </script>
  @endsection
@endif

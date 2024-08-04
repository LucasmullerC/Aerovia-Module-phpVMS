<table class="table table-sm table-borderless table-striped text-center text-nowrap align-middle mb-0">
  <thead>
    <tr>
      <th class="text-start">@sortablelink('flight_number', __('DBasic::common.flightno'))</th>
      <th class="text-start">@sortablelink('dpt_airport_id', __('DBasic::common.orig'))</th>
      <th class="text-start">@sortablelink('arr_airport_id', __('DBasic::common.dest'))</th>
      @if(!isset($ac_page))
        <th>@sortablelink('aircraft.registration', __('DBasic::common.aircraft'))</th>
      @endif
      <th>@sortablelink('flight_time', __('DBasic::common.btime'))</th>
      <th>@sortablelink('fuel_used', __('DBasic::common.fuelused'))</th>
      @ability('admin', 'admin-access')
        <th>@sortablelink('score', __('DBasic::common.score'))</th>
        <th>@sortablelink('landing_rate', __('DBasic::common.lrate'))</th>
        @if(Theme::getSetting('gen_stable_approach'))
          <th>FDM Result</th>
        @endif
      @endability
      @if(DB_Setting('dbasic.networkcheck', false))
        <th>Network</th>
      @endif
      <th class="text-end">@sortablelink('user.name', __('DBasic::common.pilot'))</th>
      <th class="text-end">@sortablelink('submitted_at', __('DBasic::common.submitted'))</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($pireps as $pirep)
      <tr>
        <td>
          <a href="{{ route('frontend.pireps.show', [$pirep->id]) }}" id="ABVIdentPireps">{{ $pirep->ident }}</a>
        </td>
        <td>
          @if($pirep->dpt_airport){{ $pirep->dpt_airport->name }}@endif
                  (<a id="ABVdepairportPirep" href="{{route('frontend.airports.show', [$pirep->dpt_airport_id])}}">{{$pirep->dpt_airport_id}}</a>)
        </td>
        <td>
          @if($pirep->arr_airport){{ $pirep->arr_airport->name }}@endif
                  (<a id="ABVarrairportPirep" href="{{route('frontend.airports.show', [$pirep->arr_airport_id])}}">{{$pirep->arr_airport_id}}</a>)
        </td>
        <td id="ABVAircraftPireps">
          @if($pirep->aircraft)
            {{ optional($pirep->aircraft)->ident }}
          @else
            -
          @endif
        </td>
        <td class="text-center" id="ABVFlightTimePireps">
          @minutestotime($pirep->flight_time)
        </td>
        <td id="ABVstatusPirepSend" class="text-center">
          @php
            $color = 'badge-info';
            if($pirep->state === PirepState::PENDING) {
                $color = 'badge-warning';
            } elseif ($pirep->state === PirepState::ACCEPTED) {
                $color = 'badge-success';
            } elseif ($pirep->state === PirepState::REJECTED) {
                $color = 'badge-danger';
            }
          @endphp
          <div class="badge {{ $color }}">{{ PirepState::label($pirep->state) }}</div>
        </td>
        <td id="ABVTimePireps">
          @if(filled($pirep->submitted_at))
            {{ $pirep->submitted_at->diffForHumans() }}
          @endif
        </td>
        <td id="ABVFuelUsed">
            {{$pirep->fuel_used}}
        </td>
        <td id="ABVScorePireps">
            {{$pirep->score}}
        </td>
        <td id="ABVLandingRatesPireps">
            {{$pirep->landing_rate}}
        </td>
        <td id="ABVNetworkPireps">
            {!! DB_NetworkPresence($pirep, 'badge') !!}
        </td>
        <td>
          @if(!$pirep->read_only)
            <a href="{{ route('frontend.pireps.edit', [$pirep->id]) }}"
               class="btn btn-outline-info btn-sm"
               style="z-index: 9999"
               title="@lang('common.edit')">
              @lang('common.edit')
            </a>
          @endif
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
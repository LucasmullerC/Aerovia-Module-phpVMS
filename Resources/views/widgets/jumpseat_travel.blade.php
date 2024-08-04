@if($is_visible)
  {{ Form::open(array('route' => $form_route, 'method' => 'post')) }}
    @if(empty($fixed_dest))
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Baloo+Bhai+2:wght@400..800&display=swap');
    </style>
    
    <style type="text/css">
        
        .m-1 {
            display: none;
        }
        
        #select2-ABVjumpseatselect-results {
            display: none!important;
        }
        
        #ABVviajar {
            font-family: 'Baloo Bhai 2';
            padding: 8px 20px!important;
            font-size: 13px;
            border-radius: 8px;
            background-color: #026cb6!important;
            font-weight: 100!important;
            border: 1px solid #026cb6!important;
        }
        
        #ABVviajar:hover {
            background-color: #fff!important;
            color: #026cb6!important;
            text-decoration: none!important;
            box-shadow: none!important;
        }
        
        #ABVverpreco {
            font-family: 'Baloo Bhai 2';
            padding: 8px 20px!important;
            font-size: 13px;
            border: 1px solid #026cb6!important;
            border-radius: 8px;
            background-color: #026cb6!important;
            font-weight: 100!important;
        }
        
        #ABVverpreco:hover {
            background-color: #fff!important;
            color: #026cb6!important;
            text-decoration: none!important;
            box-shadow: none!important;
        }
        
        #ABVformjump {
            font-family: 'Baloo Bhai 2';
            margin: 10px;
        }
        
        .p-1 {
            margin-left: 10px!important;
        }
        
        .select2-results {
            font-family: 'Baloo Bhai 2';
        }
        
        .alert-info {
            background-color: #026cb6!important;
            font-family: 'Baloo Bhai 2';
            margin: 10px!important;
            border-radius: 10px;
        }
        
    </style>
    <span id="ABVuseridJumpseat" style='display:none;'>{{ request()->query('user_id') }}</span>
      <div class="mb-2">
        <div class="p-1">
          <h5 class="m-1">

          </h5>
        </div>
        <div id="ABVformjump" class="card-body p-1">
          {{ Form::select('newloc', [], null , ['class' => 'form-control '.$hubs_only.' airport_search', 'id' => 'ABVjumpseatselect']) }}
        </div>
        <div class="p-1 text-end">
          <i class="fas fa-money-bill-wave text-{{ $icon_color }} float-start m-1" title="{{ $icon_title }}"></i>
          @if($price === 'auto')
            <button id="ABVverpreco" class="btn btn-sm bg-info p-0 px-1" type="submit" name="interim_price" value="1">@lang('DBasic::widgets.js_check')</button>
          @endif
          <button id="ABVviajar" class="btn btn-sm bg-success p-0 px-1" type="submit">@lang('DBasic::widgets.js_button')</button>
        </div>
      </div>
    @elseif($fixed_dest && $is_possible)
      <button class="btn btn-sm btn-success mx-1" type="submit" title="{{ $icon_title }}">@lang('DBasic::widgets.js_buttonf')</button>
      <input type="hidden" name="newloc" value="{{ $fixed_dest }}">
    @endif
    <input type="hidden" name="price" value="{{ $price }}">
    <input type="hidden" name="basep" value="{{ $base_price }}">
    <input type="hidden" name="croute" value="{{ url()->current() }}">
    <input type="hidden" name="userid" value="{{ request()->query('user_id') }}">
  {{ Form::close() }}

  @include('DBasic::scripts.airport_search')
@endif
@if(filled($leader_board))
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1" id="ABVLeaderboardTitle">
        {{ $header_title }}
        <i class="fas {{ $header_icon }} float-end" style="display: none"></i>
      </h5>
    </div>
    <div class="card-body p-0 table-responsive">
      <table class="table table-sm table-striped table-borderless text-start text-nowrap align-middle mb-0">
        @if($count > 1)
          <tr>
            <th id="ABVLeaderboardName">@lang('DBasic::common.name')</th>
            <th class="text-end" id="ABVLeaderboardColumnTitle">{{ $column_title }}</th>
          </tr>
        @endif
        
        @foreach($leader_board as $board)
          <tr>
            <td>
              <a href="{{ route($board['route'], $board['id']) }}" id="ABVLeaderboardBoard">
                @if($loop->first)
                  <i class="fas fa-trophy" id="ABVLeaderIcon"></i>
                  <span id="ABVLeaderPosition">{{ $loop->iteration }}</span>
                @else
                  <span id="ABVLeaderPosition">{{ $loop->iteration }}</span>
                @endif
                @if(Theme::getSetting('roster_ident'))
                  <span id="ABVLeaderIdent">{{ $board['pilot_ident'] }}</span>
                @endif
                <span id="ABVLeaderName">{{ $board['name_private'] }}</span>
              </a>
            </td>
            <td class="text-end" id="ABVLeaderboardTotals">{{ $board['totals'] }}</td>
          </tr>
        @endforeach


      </table>
    </div>
    <div class="card-footer p-0 px-1 text-end small fw-bold" id="ABVLeaderboardFooter"> 
      {{ $footer_note.' '.$footer_type }}
    </div>
  </div>
@endif

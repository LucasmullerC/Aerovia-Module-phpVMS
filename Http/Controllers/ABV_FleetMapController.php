<?php

namespace Modules\DisposableBasic\Http\Controllers;

use App\Contracts\Controller;
use App\Models\Airline;
use App\Models\Aircraft;
use App\Models\Pirep;
use App\Models\Subfleet;
use App\Models\User;
use App\Models\Enums\ActiveState;
use App\Models\Enums\PirepState;
use App\Models\Enums\UserState;
use League\ISO3166\ISO3166;
use Modules\DisposableBasic\Services\DB_StatServices;

class ABV_FleetMapController extends Controller
{
    // Airline Details
    public function index($icao)
    {
        $airline = Airline::with('journal')->where('icao', $icao)->first();

        if (!$airline) {
            flash()->error('Airline not found !');
            return redirect(route('DBasic.airlines'));
        }

        if ($airline) {
            // Get Aircraft, full fleet without restrictions
            $airline_subfleets = Subfleet::where('airline_id', $airline->id)->pluck('id')->toArray();
            $aircraft = Aircraft::with('subfleet', 'airline')->whereIn('aircraft.subfleet_id', $airline_subfleets)->sortable('registration', 'subfleet.name')->get();

            return view('DBasic::fleetmapabv.index', [
                'aircraft'  => $aircraft,
                'airline'   => $airline,
            ]);
        }
    }
}

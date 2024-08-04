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

class ABV_RouteMapController extends Controller
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
            return view('DBasic::routemapabv.index', [
                'airline'   => $airline,
            ]);
        }
    }
}

<?php

namespace Modules\DisposableBasic\Http\Controllers;

use App\Contracts\Controller;
use App\Models\Aircraft;
use Illuminate\Support\Facades\Redirect;

class ABV_AircraftMapController extends Controller
{

    public function index($ac_reg)
    {   
        $aircraft = Aircraft::with(['airline', 'airport', 'files', 'hub', 
            'subfleet.fares', 'subfleet.files', 'subfleet.hub', 'subfleet.typeratings'])
            ->where('registration', $ac_reg)
            ->first();
        
        if (!$aircraft) {
            flash()->error('Aircraft not found!');
            return Redirect::route('DBasic.fleet');
        }
        
        return view('DBasic::aircraftmapabv.index', [
            'aircraft'  => $aircraft,
        ]);
    }
}

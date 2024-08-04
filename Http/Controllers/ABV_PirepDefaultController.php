<?php

namespace Modules\DisposableBasic\Http\Controllers;

use App\Contracts\Controller;
use App\Models\Pirep;
use App\Models\Enums\PirepState;

class ABV_PirepDefaultController extends Controller
{
    // All Pireps (except inProgress) for the logged-in user
    public function index()
    {
        $eager_load = ['user', 'aircraft', 'airline', 'dpt_airport', 'arr_airport', 'simbrief'];

        $user = auth()->user();

        if ($user) {
            $pireps = Pirep::withCount('comments')
                ->with($eager_load)
                ->where('user_id', $user->id)
                ->where('pireps.state', '!=', PirepState::IN_PROGRESS)
                ->sortable(['submitted_at' => 'desc'])
                ->get();

            return view('DBasic::pirepsabv.index', [
                'DSpecial' => DB_CheckModule('DisposableSpecial'),
                'pireps'   => $pireps,
                'units'    => DB_GetUnits(),
            ]);
        } else {
            return redirect()->route('login');
        }
    }
}

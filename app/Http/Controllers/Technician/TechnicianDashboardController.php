<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserRequest;
use App\Models\FollowedUpRequest;

class TechnicianDashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $req_today_count                    = UserRequest::where([['id_requested', Auth::user()->id],['request_created_date', date('Y-m-d')]])
        ->count();
        $req_alltime_count                  = UserRequest::where('id_requested', Auth::user()->id)->count();
        
        $req_alltime_unfinished          = UserRequest::where('id_requested', Auth::user()->id)->whereIn('status',  ['Ordering', 'In-Progress'])
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        $req_alltime_finished                 = UserRequest::where('id_requested', Auth::user()->id)->get();

        return view('pages.technician.dashboard', [
            'req_today_count'                   => $req_today_count,
            'req_alltime_count'                 => $req_alltime_count,
            'req_not_finished_yet'              => $req_alltime_unfinished,
            'req_alltime_finished'              => $req_alltime_finished
        ]);
    }
}

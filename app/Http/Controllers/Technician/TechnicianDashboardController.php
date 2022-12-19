<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\UserRequest;
use Illuminate\Support\Facades\Hash;

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

        $req_alltime_finished                 = UserRequest::where('id_requested', Auth::user()->id)->whereIn('status',  ['Finished', 'Cancelled'])->get();

        return view('pages.technician.dashboard', [
            'req_today_count'                   => $req_today_count,
            'req_alltime_count'                 => $req_alltime_count,
            'req_not_finished_yet'              => $req_alltime_unfinished,
            'req_alltime_finished'              => $req_alltime_finished
        ]);
    }

    public function profile(){
        $profil = Auth::user();        
        return view('pages.technician.profile', compact('profil'));
    }

    public function profilestore(Request $request){

        // dd($request->foto);

        $this->validate($request, [
			'foto' => 'file|image|mimes:jpeg,png,jpg|max:2048',
		]);

        $user = Auth::user();        
        $user->name = $request->name;
        $user->no_hp = '62'.$request->no_hp;        
        
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto_profil = "/img/$nama";
        }

        $user->save();

        return redirect()->route('technician.dashboard');
    }
}

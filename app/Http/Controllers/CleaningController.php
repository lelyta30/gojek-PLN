<?php

namespace App\Http\Controllers;
use App\Models\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class CleaningController extends Controller
{
    public function index()
    {   
        $req_today_count                    = UserRequest::where([['id_requested', Auth::user()->id],['request_created_date', date('Y-m-d')]])
        ->count();
        $req_alltime_count                  = UserRequest::where('id_requested', Auth::user()->id)->count();
        
        $req_alltime_unfinished          = UserRequest::where('id_requested', Auth::user()->id)->whereIn('status',  ['Ordering', 'In-Progress'])
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        $req_alltime_finished                 = UserRequest::where('id_requested', Auth::user()->id)->whereIn('status',  ['Finished', 'Cancelled'])->get();

        return view('pages.cleaningservice.dashboard', [
            'req_today_count'                   => $req_today_count,
            'req_alltime_count'                 => $req_alltime_count,
            'req_not_finished_yet'              => $req_alltime_unfinished,
            'req_alltime_finished'              => $req_alltime_finished
        ]);
    }

    public function profile(){
        return view('pages.cleaningservice.profile');
    }

    public function profilestore(Request $request){

        $this->validate($request, [
			'foto_profil' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
		]);

        $user = User::findOrFail(Auth::user()->id);
        $user->nama = $request->nama;
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

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $nama = date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "/img/$nama";
        }

        return redirect()->route('cleaning.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function show($id) {
        $item = UserRequest::findOrFail($id);
        $penyervis = User::findOrFail($item->id_requested);
        return view('pages.cleaningservice.show', [
            'item'  => $item,
            'penyervis' => $penyervis
        ]);
    }

    public function accept($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'In-Progress';

        $item->update();

        return redirect()->route('cleaning.dashboard', [
            'item'  => $item 
        ]);
    }

    public function cancel($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Cancelled';

        $item->update();

        return redirect()->route('cleaning.dashboard', [
            'item'  => $item 
        ]);
    }

    public function finish($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Finished';

        $item->update();

        return redirect()->route('cleaning.dashboard', [
            'item'  => $item 
        ]);
    }

    public function reject($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Rejected';

        $item->update();

        return redirect()->route('cleaning.dashboard', [
            'item'  => $item 
        ]);
    }
}

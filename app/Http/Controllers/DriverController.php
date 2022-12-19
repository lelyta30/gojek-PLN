<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserRequest;
use App\Models\User;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        return view('pages.driver.dashboard', [
            'req_today_count'                   => $req_today_count,
            'req_alltime_count'                 => $req_alltime_count,
            'req_not_finished_yet'              => $req_alltime_unfinished,
            'req_alltime_finished'              => $req_alltime_finished
        ]);
    }

    public function profile(){
        $profil = Auth::user();        
        return view('pages.driver.profile', compact('profil'));
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

        return redirect()->route('driver.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function show($id) {
        $item = UserRequest::findOrFail($id);
        $penyervis = User::findOrFail($item->id_requested);
        return view('pages.driver.show', [
            'item'  => $item,
            'penyervis' => $penyervis
        ]);
    }

    public function accept($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'In-Progress';

        $item->update();

        return redirect()->route('driver.dashboard', [
            'item'  => $item 
        ]);
    }

    public function cancel($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Cancelled';

        $item->update();

        return redirect()->route('driver.dashboard', [
            'item'  => $item 
        ]);
    }

    public function finish($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Finished';

        $item->update();

        return redirect()->route('driver.dashboard', [
            'item'  => $item 
        ]);
    }

    public function reject($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Rejected';

        $item->update();

        return redirect()->route('driver.dashboard', [
            'item'  => $item 
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

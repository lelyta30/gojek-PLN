<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

use App\Models\FollowedUpRequest;

use App\Http\Requests\Technician\FollowedUpRequestRequest;
use App\Models\UserRequest;
use PDF;
use DataTables;

class FollowedUpRequestController extends Controller
{
    public function json(){
        $data = FollowedUpRequest::with([
            'user_request.break_type', 'user_request.user',
        ]);

        return DataTables::of($data)
        ->addColumn('action', function($data){
               $btn = '<a 
                href="f-up-request/show/'.$data->id.'" 
                class="btn btn-primary btn-sm mb-2" id="">
                <i class="fas fa-eye"></i>&nbsp;&nbsp;Detail
                </a>
                <a 
                href="f-up-request/edit/'.$data->id.'" 
                class="btn btn-primary btn-sm mb-2" id="">
                <i class="fas fa-edit"></i>&nbsp;&nbsp;Edit
                </a>';

                return $btn;
        })
        ->make(true);
    }

    public function index() {
        return view('pages.technician.followed_up_request.list');
    }

    public function show($id) {
        $item = UserRequest::findOrFail($id);
        $penyervis = User::findOrFail($item->id_requested);
        return view('pages.technician.followed_up_request.show', [
            'item'  => $item,
            'penyervis' => $penyervis
        ]);
    }

    public function accept($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'In-Progress';

        $item->update();

        return redirect()->route('technician.dashboard', [
            'item'  => $item 
        ]);
    }

    public function cancel($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Cancelled';

        $item->update();

        return redirect()->route('technician.dashboard', [
            'item'  => $item 
        ]);
    }

    public function finish($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Finished';

        $item->update();

        return redirect()->route('technician.dashboard', [
            'item'  => $item 
        ]);
    }

    public function reject($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Rejected';

        $item->update();

        return redirect()->route('technician.dashboard', [
            'item'  => $item 
        ]);
    }

    public function edit($id) {
        $item           = FollowedUpRequest::findOrFail($id);
        $technicians    = User::where('role', 'TECHNICIAN')->get();

        return view('pages.technician.followed_up_request.edit', [
            'item'          => $item,
            'technicians'    => $technicians
        ]);
    }

    public function update(FollowedUpRequestRequest $request, $id) {
        $data = $request->all();

        $item = FollowedUpRequest::findOrFail($id);

        if($item->update($data)) {
            $request->session()->flash('alert-success-update', 'Request berhasil diupdate');
        }

        return redirect()->route('technician.f-up-request');
    }
    
}

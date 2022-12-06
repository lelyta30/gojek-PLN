<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserRequest;
use App\Models\Department;
use App\Models\Computer;
use App\Models\BreakType;

use App\Models\FollowedUpRequest;
use App\Models\VerifiedRequest;

use App\Http\Requests\User\RequestRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use PDF;
use DataTables;

class RequestController extends Controller
{
    public function json(){
        $data = UserRequest::where('client_id', Auth::user()->id)->with('user')->get();

        return datatables()
        ->of($data)
        ->addIndexColumn()
        ->addColumn('id', function ($data) {
            return $data->id;
        })
        ->addColumn('nama_penyervis', function ($data) {
            return $data->id_requested;
        })
        ->addColumn('nama_client', function ($data) {
            return $data->user->name;
        })
        ->addColumn('tanggal', function ($data) {
            return $data->request_created_date;
        })
        ->addColumn('jenis_permintaan', function ($data) {
            return $data->jenis_permintaan;
        })
        ->addColumn('deskripsi', function ($data) {
            return $data->deskripsi;
        })
        ->addColumn('status', function ($data) {
            $status = $data->status;
            if($status=='Finished'){
                return '<span class="badge badge-success">'. $status .'</span>';
            }else if($status=='Cancelled'){
                return '<span class="badge badge-danger">'. $status .'</span>';
            }else if($status=='Ordering'){
                return '<span class="badge badge-secondary">'. $status .'</span>';
            }else if($status=='In-Progress'){
                return '<span class="badge badge-primary">'. $status .'</span>';
            }else if($status=='Rejected'){
                return '<span class="badge badge-warning">'. $status .'</span>';
            }
        })
        ->addColumn('action', function($data){
            $btn = '<a 
             href="request/show/'.$data->id.'" 
             class="btn btn-primary btn-sm mb-2" id="">
             <i class="fas fa-print"></i>&nbsp;&nbsp;Show
             </a>';

             return $btn;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function index() {
        return view('pages.user.request.list');
    }

    public function create() {

        return view('pages.user.request.create');
    }

    public function DropdownRole()
    {   
        $role = array();
        $role[0] = 'TECHNICIAN';
        $role[1] = 'DRIVER';
        $role[2] = 'CUSTOMER_SERVICE';

        return view('pages.user.request.create', compact('role'));
    }

    public function getRole(Request $request)
    {   
        $role = $request->role;

        $data['user'] = User::where('role', $role)->get();

        // dd($data);
        
        return response()->json(['data' => $data]);
    }

    public function store(Request $request, $id) {

        $order   = UserRequest::findOrFail($id);
        $order->client_id = $request->client_id;
        $order->request_created_date = $request->request_created_date;
        $order->id_requested = $request->requested_id;
        $order->jenis_permintaan = $request->jenis_permohonan;
        $order->description = $request->description;
        $order->rating = 0;
        $order->status = 'Ordering';
        $order->save();

        // dd($customer);
        
        // get latest request id and store it to requests table 
        // $latest_request_id = UserRequest::create($data)->id;

        // if($latest_request_id != null){
        //     // store latest request id to followed up requests table 
        //     $latest_followed_up_request_id = FollowedUpRequest::create([
        //                                     'request_id'    => $latest_request_id
        //                                     ])->id;

        //     if($latest_followed_up_request_id != null) {
        //         // store latest followed up request id to verified requests table and set it to BELUM TTD
        //         $store_it_to_verified_req = VerifiedRequest::create([
        //             'followed_up_request_id'    => $latest_followed_up_request_id 
        //         ]);

        //         if($store_it_to_verified_req) {
        //             $request->session()->flash('alert-success-add', 'Request berhasil ditambahkan');   
        //         }
        //     }
        // }

        return redirect()->route('user.request'); 
    }

    public function printPreview($id) {
        $item   = UserRequest::findOrFail($id);

        $pdf = PDF::loadView('pages.user.request.print', [
            'item'  =>  $item 
        ]);
        return $pdf->stream();
    }

    public function show($id) {
        $item = UserRequest::findOrFail($id);

        return view('pages.user.request.show', [
            'item'  => $item 
        ]);
    }

    public function cancel($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Cancelled';

        $item->update();

        return redirect()->route('user.request', [
            'item'  => $item 
        ]);
    }

    public function rating($id, Request $request) {
        $item = UserRequest::findOrFail($id);

        $item->rating = $request->rating;

        // dd($item);

        $item->update();

        return redirect()->route('user.request', [
            'item'  => $item 
        ]);
    }

    public function destroy($id) {
        $item = UserRequest::findOrFail($id);

        $item->delete();

        return redirect()->route('user.request');
    }

    public function finish($id) {
        $item = UserRequest::findOrFail($id);

        $item->status = 'Finished';

        $item->update();

        return view('pages.user.request.rating', compact('item'));
    }

    public function loadForm($diskon = 0, $total = 0, $diterima = 0, $ppn = 0)
    {
        $didiskon = $total - ($diskon / 100 * $total);
        $bayar   = $didiskon + ($ppn / 100 * $didiskon);
        $kembali = ($diterima != 0) ? $diterima - $bayar : 0;
        $data    = [
            'bayar' => $bayar,
        ];

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserRequest;

use App\Models\VerifiedRequest;

use App\Http\Requests\Manager\VerifiedRequestRequest;

use DataTables;

class VerifiedRequestController extends Controller
{
    public function json(){
        $data = UserRequest::orderBy('request_created_date', 'asc')->get();

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
        ->addColumn('rating', function ($data) {
            return $data->rating;
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
    
    public function index(Request $request) {

        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        return view('pages.manager.request.list', compact('tanggalAwal', 'tanggalAkhir'));
    }

    public function verify(VerifiedRequestRequest $request, $id) {
        $data = $request->all();

        $item = VerifiedRequest::findOrFail($id);

        if($item->update($data)) {
            $request->session()->flash('alert-success-update', 'Request berhasil diupdate');
        }
        return redirect()->route('manager.verified-request');
    }
}

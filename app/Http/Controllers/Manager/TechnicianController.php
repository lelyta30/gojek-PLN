<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Department;

use App\Http\Requests\Manager\ManAddTechRequest;

use DataTables;

class TechnicianController extends Controller
{
    public function json(){
            $data = User::orderBy('name', 'asc')->get();
    
            return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($data) {
                return $data->id;
            })
            ->addColumn('nama', function ($data) {
                return $data->name;
            })
            ->addColumn('role', function ($data) {
                return $data->role;
            })
            ->addColumn('no_hp', function ($data) {
                return $data->no_hp;
            })
            ->addColumn('rating', function ($data) {
                return $data->rating;
            })
            ->addColumn('action', function($data){
                $btn = '<a 
                 href="/m/user/destroy/'.$data->id.'" 
                 class="btn btn-danger btn-sm mb-2" id="">
                 <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                 </a>
                 <a 
                 href="/m/user/edit/'.$data->id.'" 
                 class="btn btn-danger btn-sm mb-2" id="">
                 <i class="fas fa-trash"></i>&nbsp;&nbsp;Edit
                 </a>';
    
                 return $btn;
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }


    public function index() {
        return view('pages.manager.technician.list');
    }

    public function create() {
        return view('pages.manager.technician.create');
    }

    public function store(ManAddTechRequest $request) {
        $data               = $request->except('confirm_password');
        $data['password']   = Hash::make($data['password']);
        $data['role']       = 'TECHNICIAN';
        $data['dept_code']  = 'null';
        
        if(User::create($data)) {
            $request->session()->flash('alert-success-add', 'Teknisi berhasil ditambahkan');
        }
        return redirect()->route('technician.index');
    }

    public function alluser_store(ManAddTechRequest $request) {
        $data               = $request->except('confirm_password', 'no_hp');
        $data['no_hp']      = '62'.$request->no_hp;
        $data['password']   = Hash::make($data['password']);
        $data['foto_profil'] = 'null';
        $data['rating'] = 3;
        // dd($data);
        
        if(User::create($data)) {
            $request->session()->flash('alert-success-add', 'User berhasil ditambahkan');
        }

        return redirect()->route('manager.dashboard');
    }

    public function show($id) {

    }

    public function edit($id) {
        $item           = User::findOrFail($id);

        return view('pages.manager.technician.edit', [
            'item'          => $item
        ]);
    }

    public function update(ManAddTechRequest $request, $id){
        
        $item = User::findOrFail($id);       
        $item->name = $request->name;
        $item->no_hp = '62'.$request->no_hp;        
        $item->password = bcrypt($request->password);
        $item->rating = $request->rating;

        if($item->update()) {
            $request->session()->flash('alert-success-update', 'User berhasil diupdate');
        }
        
        return redirect()->route('manager.verified-request');
    }

    public function destroy(Request $request, $id) {
        $item = User::findOrFail($id);

        if($item->delete()) {
            $request->session()->flash('alert-success-update', 'User berhasil dihapus');
        }
        
        return redirect()->route('manager.verified-request');
    }
}

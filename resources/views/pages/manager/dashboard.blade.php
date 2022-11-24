<!-- 
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->
 @extends('layouts.app')

 @section('title', 'IKET - Manager Dashboard')
 
 @section('content')
 <div class="content">
     <div class="container-fluid container-dashboard">
 
         <div class="row">
             <div class="container">
                 <h3>&nbsp;Selamat Datang, {{ Auth::user()->name }}!</h3>
             </div>
         </div>
 
         <div class="row">
 
             <div class="col-md-3">
                 <div class="card-counter primary">
                     <i class="fas fa-calendar"></i>
                     <span class="count-numbers">{{ $req_today_count }}</span>
                     <span class="count-name">Request Hari Ini</span>
                 </div>
             </div>
 
             <div class="col-md-3">
                 <div class="card-counter danger">
                     <i class="fas fa-calendar"></i>
                     <span class="count-numbers">{{ $req_not_finished_yet_today_count }}</span>
                     <span class="count-name">Req. Blm Selesai Hari Ini</span>
                 </div>
             </div>
 
             <div class="col-md-3">
                 <div class="card-counter primary">
                     <i class="fas fa-calendar-alt"></i>
                     <span class="count-numbers">{{ $req_alltime_count }}</span>
                     <span class="count-name">Request Sepanjang Waktu</span>
                 </div>
             </div>
 
             <div class="col-md-3">
                 <div class="card-counter danger">
                     <i class="fas fa-calendar-alt"></i>
                     <span class="count-numbers">{{ $req_not_finished_yet_alltime_count }}</span>
                     <span class="count-name">Rq Blm Slesai Spnjng Wkt</span>
                 </div>
             </div>
 
         </div>
 
         <div class="row">
             <div class="col-12">
                 <div class="card ">
                     <div class="card-header ">
                         <h4 class="card-title">Request Hari ini</h4>
                         <p class="card-category">diambil dari 3 request terbaru</p>
                     </div>
                     <div class="card-body ">
                         <div class="table-responsive overflow-auto">
                             <table class="table table-bordered" width="100%" cellspacing="0">
                                 <thead>
                                     <tr>
                                         <th>ID Req.</th>
                                         <th>Tgl Req.</th>
                                         <th>Pemohon</th>
                                         <th>Jenis Kerusakan</th>
                                         <th>Deskripsi</th>
                                         <th>Tgl Target</th>
                                         <th>Tgl Selesai</th>
                                         <th>Teknisi</th>
                                         <th>Status</th>
                                         <th>Catatan Teknisi</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @forelse ($req_today as $item)
                                     <tr>
                                         <td>{{ $item->followed_up_request->request_id }}</td>
                                         <td>{{ $item->followed_up_request->user_request->request_created_date }}</td>
                                         <td>{{ $item->followed_up_request->user_request->user->name }}</td>
                                         <td>{{ $item->followed_up_request->user_request->break_type->name }}</td>
                                         <td>{{ $item->followed_up_request->user_request->description }}</td>
                                         <td>{{ $item->followed_up_request->target_date }}</td>
                                         <td>{{ $item->followed_up_request->target_completion_date }}</td>
                                         <td>{{ $item->followed_up_request->technician }}</td>
                                         <td>
                                            @if ($item->followed_up_request->is_done == 'SELESAI')
                                                <span class="badge badge-success">
                                            @elseif ($item->followed_up_request->is_done == 'BELUM SELESAI')
                                                <span class="badge badge-secondary">
                                            @elseif ($item->followed_up_request->is_done == 'BELUM BATAL')
                                                <span class="badge badge-danger">
                                            @endif
                                            {{ $item->followed_up_request->is_done }}</span>
                                        </td>
                                        <td>{{ $item->followed_up_request->technician_note }}</td>
                                         <td>
                                            <form action="{{ route('manager.verified-request.verify', $item->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                @if ($item->is_verified == 'BELUM')
                                                    <input type="hidden" name="is_verified" value="SUDAH"> 
                                                    <button class="btn btn-primary btn-sm btn-checkbox">
                                                        
                                                    </button>
                                                @elseif($item->is_verified == 'SUDAH')
                                                    <input type="hidden" name="is_verified" value="SUDAH"> 
                                                    <button class="btn btn-primary btn-sm btn-checkbox">
                                                        <i class="fas fa-check"></i>  
                                                    </button>
                                                @endif
                                            </form>
                                         </td>
                                     </tr>
                                     @empty
                                     <tr>
                                         <td class="text-center" colspan="11">Tidak ada data yang dapat ditampilkan</td>
                                     </tr>
                                     @endforelse
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
 
         <div class="row">
             <div class="col-12">
                 <div class="card ">
                     <div class="card-header ">
                         <h4 class="card-title">Request Belum Selesai</h4>
                         <p class="card-category">diambil dari 3 request terbaru</p>
                     </div>
                     <div class="card-body ">
                         <div class="table-responsive overflow-auto">
                             <table class="table table-bordered" width="100%" cellspacing="0">
                                 <thead>
                                     <tr>
                                         <th>ID Req.</th>
                                         <th>Tgl Req.</th>
                                         <th>Pemohon</th>
                                         <th>Jenis Kerusakan</th>
                                         <th>Deskripsi</th>
                                         <th>Tgl Target</th>
                                         <th>Tgl Selesai</th>
                                         <th>Teknisi</th>
                                         <th>Status</th>
                                         <th>Catatan Teknisi</th>
                                         <th>Action</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @forelse ($req_not_finished_yet as $item)
                                     <tr>
                                         <td>{{ $item->followed_up_request->request_id }}</td>
                                         <td>{{ $item->followed_up_request->user_request->request_created_date }}</td>
                                         <td>{{ $item->followed_up_request->user_request->client_name }}</td>
                                         <td>{{ $item->followed_up_request->user_request->break_type->name }}</td>
                                         <td>{{ $item->followed_up_request->user_request->description }}</td>
                                         <td>{{ $item->followed_up_request->target_date }}</td>
                                         <td>{{ $item->followed_up_request->target_completion_date }}</td>
                                         <td>{{ $item->followed_up_request->technician }}</td>
                                         <td>
                                            @if ($item->followed_up_request->is_done == 'SELESAI')
                                                <span class="badge badge-success">
                                            @elseif ($item->followed_up_request->is_done == 'BELUM SELESAI')
                                                <span class="badge badge-secondary">
                                            @elseif ($item->followed_up_request->is_done == 'BELUM BATAL')
                                                <span class="badge badge-danger">
                                            @endif
                                            {{ $item->followed_up_request->is_done }}</span>
                                        </td>
                                        <td>{{ $item->followed_up_request->technician_note }}</td>
                                         <td>
                                            <form action="{{ route('manager.verified-request.verify', $item->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                @if ($item->is_verified == 'BELUM')
                                                    <input type="hidden" name="is_verified" value="SUDAH"> 
                                                    <button class="btn btn-primary btn-sm btn-checkbox">
                                                        
                                                    </button>
                                                @elseif($item->is_verified == 'SUDAH')
                                                    <input type="hidden" name="is_verified" value="BELUM"> 
                                                    <button class="btn btn-primary btn-sm btn-checkbox">
                                                        <i class="fas fa-check"></i>  
                                                    </button>
                                                @endif
                                            </form>
                                         </td>
                                     </tr>
                                     @empty
                                     <tr>
                                         <td class="text-center" colspan="11">Tidak ada data yang dapat ditampilkan</td>
                                     </tr>
                                     @endforelse
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection
 
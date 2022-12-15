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

@section('title', 'IKET - Followed Up Request Show')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Lihat Request Ditindaklanjuti</h4>
                        <p class="card-category">Request dari {{ $item->user->name }}</p>
                    </div>
                    <div class="card-body ">

                        <div class="table-responsive overflow-auto">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $item->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Request</th>
                                        <td>{{ $item->request_created_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pemohon</th>
                                        <td>{{ $item->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Permintaan</th>
                                        <td>{{ $item->jenis_permintaan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Penyervis</th>
                                        <td>{{ $penyervis->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $item->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($item->status == 'Finished')
                                            <span class="badge badge-success">SELESAI</span>
                                            @elseif ($item->status == 'Cancelled')
                                            <span class="badge badge-danger">BATAL</span>
                                            @elseif ($item->status == 'Ordering')
                                            <span class="badge badge-danger">MEMESAN</span>
                                            @elseif ($item->status == 'In-Progress')
                                            <span class="badge badge-success">DITERMA/SEDANG PROSES</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td>
                                            @if ($item->status == 'In-Progress')
                                            <a href="{{ route('technician.f-up-request.cancel', $item->id) }}"
                                                class="btn btn-danger btn-sm mb-2" id="">
                                                <i class="fas fa-edit"></i>&nbsp;&nbsp;Cancel
                                            </a>
                                            @elseif ($item->status == 'Ordering')
                                            <a href="{{ route('technician.f-up-request.accept', $item->id) }}"
                                                class="btn btn-primary btn-sm mb-2" id="">
                                                <i class="fas fa-edit"></i>&nbsp;&nbsp;Terima
                                            </a>
                                            <a href="{{ route('technician.f-up-request.reject', $item->id) }}"
                                                class="btn btn-danger btn-sm mb-2" id="">
                                                <i class="fas fa-edit"></i>&nbsp;&nbsp;Tolak
                                            </a>
                                            @elseif ($item->status == 'Cancelled')
                                            <span class="badge badge-success">DIBATALKAN</span>
                                            @elseif ($item->status == 'Finished')
                                            <span class="badge badge-success">SELESAI</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rating</th>
                                        <td>{{ $item->rating ?? 0}}</td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>
                                            <a href="http://wa.me/{{ $item->user->no_hp }}"> {{ $item->user->no_hp }}</a>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

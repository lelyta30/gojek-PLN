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

 @section('title', 'IKET - Verified Request List')
 
 @section('content')
 <div class="content">
     <div class="container-fluid">
         <div class="row">
             <div class="col-12">
                 <div class="card ">
                     <div class="card-header ">
                         <h4 class="card-title">List Request Diverifikasi</h4>
                         <p class="card-category">Request dari semua user</p>
                     </div>
                     <div class="card-body ">
 
                         <div class="table-responsive overflow-auto">
                             <table class="table table-bordered" id="verified-request-table" width="100%" cellspacing="0">
                                 <thead>
                                     <tr>
                                        <th>ID</th>
                                        <th>Tanggal Request</th>
                                        <th>Jenis Permohonan</th>
                                        <th>Nama Penyervis</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
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
 
 @push('after-style')
 {{-- Datatables  --}}
 <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet" />
 @endpush
 
 @push('after-script')
 {{-- DataTables  --}}
 <script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
 
 <script>
     $(function () {
         $('#verified-request-table').DataTable({
             processing: true,
             serverSide: true,
             ajax: '{{ route('manager.verified-request.json') }}',
             columns: [
                {data: 'id'},
                {data: 'tanggal'},
                {data: 'jenis_permintaan'},
                {data: 'nama_penyervis'},
                {data: 'description', name: 'description'},
                {data: 'status'},
             ],
             order: [0, 'desc'],
             stateSave: true
         });
     });
 
 </script>
 @endpush
 
 @include('includes.notification')
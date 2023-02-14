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
                 <div class="card">
                     <div class="card-header">
                         <h4 class="card-title">List Request Diverifikasi</h4>
                         <p class="card-category">Request dari semua user</p>
                         <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                         <a href="{{ route('manager.request.export_excel', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-success btn-xs btn-flat"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                     </div>
                     <div class="card-body">
                         <div class="table-responsive overflow-auto">
                             <table class="table table-bordered" id="verified-request-table" width="100%" cellspacing="0">
                                 <thead>
                                     <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Tanggal Request</th>
                                        <th>Jenis Permohonan</th>
                                        <th>Client</th>
                                        <th>Penyervis</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Rating</th>
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
 @includeIf('pages.manager.request.form')
 
 @push('after-style')
 {{-- Datatables  --}}
 <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet" />
 @endpush
 
 @push('after-script')
 {{-- DataTables  --}}
 <script src="{{ asset('assets/js/datatables.min.js') }}" type="text/javascript"></script>
 <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
 <script>
     $(function () {
        $('#verified-request-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('manager.request.data', [$tanggalAwal, $tanggalAkhir]) }}"
            },
                columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'id'},
                {data: 'tanggal_request'},
                {data: 'jenis_permohonan'},
                {data: 'nama_client'},
                {data: 'nama_penyervis'},
                {data: 'deskripsi'},
                {data: 'status'},
                {data: 'rating'},
                ],
        });
        $('#tanggal_awal').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });  
        $('#tanggal_akhir').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });  

    });
    function updatePeriode() {
        $('#modal-form').modal('show');
    }
     
 
 </script>
 @endpush
 
 @include('includes.notification')
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

@section('title', 'IKET - Buat Request')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Buat Request</h4>
                        <p class="card-category">Silakan isi form di bawah ini.</p>
                    </div>
                    <div class="card-body ">
                        <form id="createForm" method="POST" action="{{ route('user.request.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="request_created_date" class="form-control-label">Tanggal Request</label>
                                <input type="text" class="form-control" name="request_created_date"
                                    id="request_created_date" placeholder=""
                                    value="{{ \Carbon\Carbon::today()->toDateString() }}" readonly>
                            </div>

                            <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">

                            <div class="form-group">
                                <label for="client_name" class="form-control-label">Nama Pemohon</label>
                                <input type="text" class="form-control @error('client') is-invalid @enderror"
                                    name="client" id="client" placeholder="Nama Pemohon"
                                    value="{{ Auth::user()->name }}" readonly>
                                @error('client_name')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jenis_permohonan" class="form-control-label">Jenis Permohonan</label>
                                <br>
                                <select class="custom-select" class="form-control @error('jenis_permohonan') is-invalid @enderror"
                                name="jenis_permohonan" id="jenis_permohonan" placeholder="Jenis Permohonan"
                                value="">
                                    <option value="0">-- Select Request --</option>
                                    @foreach($role as $roles)
                                        <option value="{{ $roles }}">{{ $roles}}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="form-group">
                                <label for="jenis_permohonan" class="form-control-label">Jenis Permohonan</label>
                                <br>
                                <select class="custom-select" class="form-control @error('jenis_permohonan') is-invalid @enderror"
                                name="jenis_permohonan" id="jenis_permohonan" placeholder="Jenis Permohonan"
                                value="">
                                    <option value="TECHNICIAN">Teknisi</option>
                                    <option value="DRIVER">Driver</option>
                                    <option value="CUSTOMER_SERVICE">Customer Service</option>
                                </select>
                                @error('jenis_permohonan')
                                @include('includes.error-field')
                                @enderror
                            </div> --}}
                            
                            <div class="form-group">
                                <label for="requested_id" class="form-control-label">Nama Penyervis</label>
                                <select class="form-control @error('requested_id') is-invalid @enderror"
                                name="requested_id" id="requested_id">
                                </select>
                                    {{-- <span class="input-group-btn">
                                        <button onclick="tampilTeknisi()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                    </span> --}}
                                @error('requested_id')
                                @include('includes.error-field')
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="description" class="form-control-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    name="description" id="description" placeholder="Deskripsi"
                                    rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            @include('includes.save-cancel-btn')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#jenis_permintaan').on('change', function () {
            var name = this.value;
            $("#requested_id").html('');
            $.ajax({
                url: '{{ route('user.request.dropdown.getRole', 'name') }}',
                type: "POST",
                data: {
                    role: name,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#requested_id').html('<option value="">-- Select State --</option>');
                    $.each(result.user, function (key, value) {
                        $("#requested_id").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('#jenis_permintaan').html('<option value="">-- Select City --</option>');
                }
            });
        });
    });
</script>
{{-- <script>
     function tampilTeknisi() {
        $('#modal-teknisi').modal('show');
    }

    function hideTeknisi() {
        $('#modal-teknisi').modal('hide');
    }

    function pilihTeknisi(id, nama) {
        $('#id_produk').val(id);
        $('#nama').val(nama);
        hideTeknisi();
        tambahTeknisi();
    }

    function tambahTeknisi() {

    }

    function loadForm(diskon = 0, diterima = 0, ppn = 0) {
        $('#jenis_permohonan').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}/${ppn}`)
            .done(response => {
                $('#totalrp').val('Rp. ' + response.totalrp);
                $('#bayarrp').val('Rp. ' + response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Bayar: Rp. ' + response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp.' + response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali: Rp. ' + response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
    }    
</script> --}}
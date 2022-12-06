@extends('layouts.app')

@section('title', 'IKET - User Dashboard')

@section('content')
<div class="content">
    <div class="container-fluid container-dashboard">
        
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi telah selesai.
                </div>
            </div>
        </div>
        <div class="box-body">
                Silahkan beri rating
                </div>
        <div class="box-footer">
            <form action="{{ route('user.request.rating', $item->id) }}" method="GET">
                <div class="form-row">
                    <label for="rating">Rating</label>
                    <input type="number" class="form-control" id="rating" placeholder="Masukkan angka 1(buruk) hingga 5(baik)">
                </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                </div>
    </div>
        </div>
    </div>
</div>

    </div>
</div>
@endsection
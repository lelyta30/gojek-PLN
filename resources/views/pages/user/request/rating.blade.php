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
            <form action="{{ route('user.request.rating', $item->id) }}" method="post">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="form-row">
                    <label for="rating">Rating</label>
                    <select class="form-control" id="rating" name="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
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
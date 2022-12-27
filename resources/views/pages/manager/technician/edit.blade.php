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

@section('title', 'IKET - Edit Teknisi')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Edit Teknisi</h4>
                        <p class="card-category">Silakan isi form di bawah ini.</p>
                    </div>
                    <div class="card-body ">
                        <form id="createForm" method="POST"
                            action="{{ route('manager.user.update', $item->id) }}">
                            @method('POST')
                            @csrf

                            <input type="hidden" name="is_edit" id="is_edit" value="true"/>

                            <div class="form-group">
                                <label for="username" class="form-control-label">Username</label>
                                <input type="text" class="form-control" name="username"
                                    id="username" placeholder=""
                                    value="{{ $item->username }}" readonly>
                                @error('username')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Nama"
                                    value="{{ $item->name }}">
                                @error('name')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-control-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" id="password" placeholder="password"
                                    value="">
                                @error('password')
                                @include('includes.error-field')
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="role" class="form-control-label">Role</label>
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="TECHNICIAN" {{ $item->role ? 'selected': "" }}>TECHNICIAN</option>
                                    <option value="DRIVER" {{ $item->role ? 'selected': "" }} >DRIVER</option>
                                    <option value="SECURITY"{{ $item->role ? 'selected': "" }} >SECURITY</option>
                                    <option value="CLEANING"{{ $item->role ? 'selected': "" }}>CLEANING SERVICE</option>
                                    <option value="USER"{{ $item->role ? 'selected': "" }}>USER</option>
                                </select>
                                @error('role')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="no_hp" class="col-lg-2 control-label">Nomor Ponsel</label>
                                <label for="no_hp2" class="control-label">+62</label>
                                <div class="col-lg-6">
                                    <input type="no_hp" name="no_hp" id="no_hp" class="form-control" value="{{ $item->no_hp}}">
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="rating" class="form-control-label">Rating</label>
                                <select class="form-control @error('rating') is-invalid @enderror" name="rating" id="rating">
                                    <option value="1" {{ $item->rating ? 'selected': "" }}>1</option>
                                    <option value="2" {{ $item->rating ? 'selected': "" }} >2</option>
                                    <option value="3"{{ $item->rating ? 'selected': "" }} >3</option>
                                    <option value="4"{{ $item->rating ? 'selected': "" }}>4</option>
                                    <option value="5"{{ $item->rating ? 'selected': "" }}>5</option>
                                </select>
                                @error('rating')
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


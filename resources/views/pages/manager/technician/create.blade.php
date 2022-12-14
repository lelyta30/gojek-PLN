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

@section('title', 'IKET - Buat Teknisi')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card ">
                    <div class="card-header ">
                        <h4 class="card-title">Buat Data Teknisi</h4>
                        <p class="card-category">Silakan isi form di bawah ini.</p>
                    </div>
                    <div class="card-body ">
                        <form method="GET" action="{{ route('alluser.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="username" class="form-control-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" placeholder="Username"
                                    value="{{ old('username') }}" autofocus>
                                @error('username')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-control-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" id="password" placeholder="Password" 
                                    value="">
                                @error('password')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="form-control-label">Confirm Password</label>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" 
                                    name="confirm_password" id="confirm_password" placeholder="Confirm Password" 
                                    value="">
                                @error('confirm_password')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    id="name" placeholder="Nama Departemen" value="{{ old('name') }}">
                                @error('name')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role" class="form-control-label">Role</label>
                                {{-- <input type="role" class="form-control @error('role') is-invalid @enderror" 
                                    name="role" id="role" placeholder="Role" 
                                    value=""> --}}
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="TECHNICIAN">TECHNICIAN</option>
                                    <option value="DRIVER">DRIVER</option>
                                    <option value="SECURITY">SECURITY</option>
                                    <option value="CLEANING">CLEANING SERVICE</option>
                                    <option value="USER">USER</option>
                                </select>
                                @error('role')
                                @include('includes.error-field')
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="no_hp" class="form-control-label">Phone Number</label>
                                <br>
                                {{-- <div class="col"></div> --}}
                                <label for="62" class="col-form-control">+62</label>
                                <input type="no_hp" class="col-form-control @error('no_hp') is-invalid @enderror" 
                                    name="no_hp" id="no_hp" placeholder="Phone Number" 
                                    value="">
                                    @error('no_hp')
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

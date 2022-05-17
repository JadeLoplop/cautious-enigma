@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Create user</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="float-end">
                                <button type="submit" class="btn btn-primary rounded">Update</button>
                                <button type="button" class="btn btn-success rounded">Reset Password</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary rounded">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label for="prefixname" class="form-label mt-4">Prefix</label>
                            <select name="prefixname" id="prefixname" class="form-control @error('prefixname') is-invalid @enderror">
                                <option value="">-- Select Prefix --</option>
                                @foreach ($prefixname as $prefix)
                                    @if ($prefix == $user->prefixname)
                                        <option value="{{ $prefix }}" selected>{{ $prefix }}</option>
                                        @continue
                                    @endif
                                    <option value="{{ $prefix }}">{{ $prefix }}</option>
                                @endforeach
                            </select>
                            @error('prefixname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-12 row">
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="firstname" class="form-label mt-4">First Name</label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname"  placeholder="Juan" value="{{ $user->firstname }}">
                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="middlename" class="form-label mt-4">Middle Name</label>
                                <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename"  placeholder="Dela" value="{{  $user->middlename }}">
                                @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="lastname" class="form-label mt-4">Last Name</label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname"  placeholder="Cruz" value="{{ $user->lastname }}">
                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="suffixname" class="form-label mt-4">Suffix</label>
                                <input type="text" class="form-control @error('suffixname') is-invalid @enderror" id="suffixname" name="suffixname"  placeholder="Jr." value="{{ $user->suffixname }}">
                                @error('suffixname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row h-100">
                    <div class="col-md-6 col-sm-12 p-3">
                        <input type="file" name="photo" id="photo" class="dropify"
                        data-allowed-file-extensions="jpeg jpg png"
                        data-default-file="{{ $user->avatar }}" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email" class="form-label mt-4">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="juan23" value="{{ $user->username }}">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email" class="form-label mt-4">Email address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="juandelacruz@email.com" value="{{ $user->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    {{-- <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label mt-4">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="******">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('page-scritps')
    <script>
        $(document).ready(function(){
            $('.dropify').dropify();
        })
    </script>
@endsection

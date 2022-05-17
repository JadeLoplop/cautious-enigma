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
                            <h4>User Details</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="float-end">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-success rounded">Edit</a>
                                <button data-id="{{ $user->id }}"
                                    class="btn btn-danger destroy_user">Remove User</button>


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
                            <select name="prefixname" id="prefixname" class="form-control @error('prefixname') is-invalid @enderror" disabled>
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
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname"  placeholder="Juan" value="{{ $user->firstname }}" disabled>
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
                                <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename"  placeholder="Dela" value="{{  $user->middlename }}" disabled>
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
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname"  placeholder="Cruz" value="{{ $user->lastname }}" disabled>
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
                                <input type="text" class="form-control @error('suffixname') is-invalid @enderror" id="suffixname" name="suffixname"  placeholder="Jr." value="{{ $user->suffixname }}" disabled>
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
                        data-default-file="{{ $user->avatar }}" disabled/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label for="email" class="form-label mt-4">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="juan23" value="{{ $user->username }}" disabled>
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="juandelacruz@email.com" value="{{ $user->email }}" disabled>
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

    <form id="destroyUser_{{$user->id}}"
        action="{{ route('users.destroy', $user) }}"
        method="POST">
        @csrf
        @method('DELETE')
    </form>


</div>
@endsection

@section('page-scritps')
    <script>

    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.dropify').dropify();
        })
        $(document).on('click', '.destroy_user', function (e) {
            e.preventDefault();
            var id = $(this).data('id');

            confirmDestroy(id);
        });
        function confirmDestroy(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('destroyUser_' + id).submit()
                    }
                })
            }
    </script>
@endsection

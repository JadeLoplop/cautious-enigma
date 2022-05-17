@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="card-title">

                <div class="row">
                    <div class="col-lg-6">
                        <h4>Archived User List</h4>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary rounded">Back User List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    @if ($user->type != 'user')
                        @continue
                    @endif
                        <tr>
                            <td>
                                <img src="{{ asset($user->avatar)}}" alt="Avatar"
                                                        width="50" height="50"></td>
                            </td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- edit --}}
                                <div class="d-flex justify-content-center">
                                    <button data-id="{{ $user->id }}"
                                        class="btn btn-success btn-sm restore_user"><i class="bi bi-check"></i></button>

                                    <form id="restoreUser_{{$user->id}}"
                                        action="{{ route('users.restore', $user) }}"
                                        method="POST">
                                        @csrf
                                        @method('PATCH')
                                    </form>

                                    {{-- destroy --}}
                                    <button data-id="{{ $user->id }}"
                                        class="btn btn-danger btn-sm delete_user"><i class="bi bi-trash"></i></button>

                                    <form id="deleteUser_{{$user->id}}"
                                        action="{{ route('users.delete', $user) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                                {{-- archive --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@section('page-scritps')
<script type="text/javascript">
    $(document).on('click', '.delete_user', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        confirmDelete(id);
    });
    function confirmDelete(id) {
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
                    document.getElementById('deleteUser_' + id).submit()
                }
            })
        }

    $(document).on('click', '.restore_user', function (e) {
    e.preventDefault();
    var id = $(this).data('id');

    confirmRestore(id);
    });
    function confirmRestore(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to restore this user.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('restoreUser_' + id).submit()
                }
            })
        }
</script>
@endsection

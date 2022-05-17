@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="card-title">

                <div class="row">
                    <div class="col-lg-6">
                        <h4>User List</h4>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-end">
                            <a href="{{ route('users.create') }}" class="btn btn-primary rounded">Add User</a>
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
                                <a href="{{ route('users.edit', $user) }}"
                                    class="btn btn-success btn-sm"><i class="bi bi-pencil-square"></i>
                                </a>
                                {{-- show --}}
                                <a href="{{ route('users.show', $user) }}"
                                    class="btn btn-info btn-sm"><i class="bi bi-eye"></i>
                                </a>
                                {{-- destroy --}}
                                <button data-id="{{ $user->id }}"
                                    class="btn btn-danger btn-sm destroy_user"><i class="bi bi-archive"></i></button>

                                <form id="destroyUser_{{$user->id}}"
                                    action="{{ route('users.destroy', $user) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
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
    $(document).on('click', '.destroy_user', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

        confirmDestroy(id);
    });
    function confirmDestroy(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "User will be archived!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, archive it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('destroyUser_' + id).submit()
                }
            })
        }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Users')

@section('content')

    <div class="container">
        <div class="row mb-4">
            <h1 class="text-secondary">
                <i class="fa-solid fa-user mr-2"></i> Users
            </h1>
        </div>
        <div class="row justify-content-center mb-4">
            <div class="text-end">
                <!-- Button to trigger Add User modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal" type="button">
                    <i class="fa fa-user-plus"></i> Add User
                </button>
            </div>
        </div>

        <div class="data-table-container row bg-body">
            <table class="table table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td class="d-flex justify-content-center">
                                @if ($user->id != 1)
                                    <button class="btn btn-success mx-2" data-bs-toggle="modal"
                                    data-bs-target="#updateModal" 
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}" 
                                    data-role="{{ $user->role }}" 
                                    data-email="{{ $user->email }}"
                                    type="button">
                                        Update
                                    </button>
                                    <button class="btn btn-danger submit mx-1" data-id="{{ $user->id }}"
                                        data-action="{{ route('delete_user') }}" data-bs-target="#deleteModal"
                                        data-bs-toggle="modal">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                @else
                                    <span class="pt-3 pb-2"></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addUserModal" aria-labelledby="addUserModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel"> <i class="fa fa-user-plus"></i> Create User Account</h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="submit" method="post" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <div class="flex-grow-1">
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" type="text" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label" for="role">Role</label>
                            <div class="flex-grow-1">
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="" disabled selected>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="verifier">Verifier
                                    </option>
                                    <option value="publisher">Publisher
                                    </option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label" for="email">Email Address</label>
                            <div class="flex-grow-1">
                                <input class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" type="email" autocomplete="off" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label" for="password">Password</label>
                            <div class="flex-grow-1">
                                <input class="form-control @error('password') is-invalid @enderror" id="password"
                                    name="password" type="password" autocomplete="off" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="form-label" for="password-confirm">Confirm Password</label>
                            <div class="flex-grow-1">
                                <input class="form-control" id="password-confirm" name="password_confirmation"
                                    type="password" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <input name="date" type="hidden" value="{{ date('Y-m-d') }}">
                    <input id="id" name="id" type="hidden" value="">
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    </form>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>

<!-- Update User Modal -->
<div class="modal fade" id="updateModal" aria-labelledby="updateModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel"> <i class="fa fa-user-edit"></i> Update User Account</h5>
                <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateUserForm" method="post" action="{{ route('update_user') }}">
                    @csrf
                    <input type="hidden" id="updateId" name="id"> <!-- Hidden field for user ID -->

                    <div class="form-group">
                        <label class="form-label" for="updateName">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="updateName" name="name" type="text" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <label class="form-label" for="updateRole">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="updateRole" name="role" required>
                            <option value="admin">Admin</option>
                            <option value="verifier">Verifier</option>
                            <option value="publisher">Publisher</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group mt-4">
                        <label class="form-label" for="updateEmail">Email Address</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="updateEmail" name="email" type="email" autocomplete="off" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save Changes</button>
                </form>
                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Script to handle updating user data in the modal -->
@section('script')
    <script>
     $(document).ready(function() {
            // Bind event to open the modal and populate with data
            $('#updateModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);  // Button that triggered the modal
                let id = button.data('id');
                let name = button.data('name');
                let role = button.data('role');
                let email = button.data('email');

                // Update the modal fields with the user data
                let modal = $(this);
                modal.find('#updateId').val(id);
                modal.find('#updateName').val(name);
                modal.find('#updateRole').val(role);
                modal.find('#updateEmail').val(email);
            });
        });
    </script>
@endsection


@endsection
@section('script')
    <script>
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
            }, 1000); // Adjust the delay as needed
        };
    </script>
@endsection

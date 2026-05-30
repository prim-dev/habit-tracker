<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Users Management
    </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container-fluid">

    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3">

            <h3 class="mb-4">
                Habit Tracker
            </h3>

            <ul class="nav flex-column">

                <li class="nav-item mb-2">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link text-white">

                        <i class="bi bi-grid"></i>
                        Dashboard

                    </a>

                </li>

                <li class="nav-item mb-2">

                    <a href="{{ route('users') }}"
                       class="nav-link bg-primary text-white rounded">

                        <i class="bi bi-people"></i>
                        Users

                    </a>

                </li>

                <li class="nav-item mb-2">

                    <a href="{{ route('habits') }}"
                       class="nav-link text-white">

                        <i class="bi bi-list-check"></i>
                        Habits

                    </a>

                </li>

                <li class="nav-item mb-2">

                    <a href="{{ route('profile') }}"
                       class="nav-link text-white active">

                        <i class="bi bi-person-circle"></i>
                        Profile

                    </a>

                </li>

            </ul>

        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>
                    Users Management
                </h2>

                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addUserModal">

                    <i class="bi bi-plus-circle"></i>
                    Add User

                </button>

            </div>

            <!-- Users Table -->
            <div class="card shadow border-0">

                <div class="card-body">

                    <table class="table table-hover">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created Date</th>
                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($users as $user)

                            <tr>

                                <td>
                                    {{ $user->id }}
                                </td>

                                <td>
                                    {{ $user->name }}
                                </td>

                                <td>
                                    {{ $user->email }}
                                </td>

                                <td>
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>

                                <td>

                                    <!-- Edit -->
                                    <button class="btn btn-sm btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserModal{{ $user->id }}">

                                        Edit

                                    </button>

                                    <!-- Delete -->
                                    <form action="{{ route('users.delete', $user->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">

                                            Delete

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            <!-- Edit Modal -->
                            <div class="modal fade"
                                 id="editUserModal{{ $user->id }}"
                                 tabindex="-1">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <div class="modal-header">

                                            <h5 class="modal-title">
                                                Edit User
                                            </h5>

                                            <button type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"></button>

                                        </div>

                                        <form action="{{ route('users.update', $user->id) }}"
                                              method="POST">

                                            @csrf

                                            <div class="modal-body">

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Name
                                                    </label>

                                                    <input type="text"
                                                           name="name"
                                                           class="form-control"
                                                           value="{{ $user->name }}"
                                                           required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Email
                                                    </label>

                                                    <input type="email"
                                                           name="email"
                                                           class="form-control"
                                                           value="{{ $user->email }}"
                                                           required>

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        New Password
                                                    </label>

                                                    <input type="password"
                                                           name="password"
                                                           class="form-control">

                                                </div>

                                                <div class="mb-3">

                                                    <label class="form-label">
                                                        Confirm Password
                                                    </label>

                                                    <input type="password"
                                                           name="password_confirmation"
                                                           class="form-control">

                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                    Close

                                                </button>

                                                <button type="submit"
                                                        class="btn btn-primary">

                                                    Update

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Add User Modal -->
<div class="modal fade"
     id="addUserModal"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Add User
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <form action="/users"
                  method="POST">

                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Name
                        </label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        Close

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        Save User

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if(session('success'))

<div class="toast-container position-fixed top-0 end-0 p-3">

    <div class="toast show align-items-center text-bg-success border-0">

        <div class="d-flex">

            <div class="toast-body">

                {{ session('success') }}

            </div>

            <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"></button>

        </div>

    </div>

</div>

@endif
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-dark text-white p-3"
         style="width: 250px; min-height: 100vh;">

        <h4 class="mb-4">
            Habit Tracker
        </h4>

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
                   class="nav-link text-white">

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

            <li class="nav-item mt-3">

                <form action="{{ route('logout') }}"
                      method="POST">

                    @csrf

                    <button type="submit"
                            class="btn btn-danger w-100">

                        Logout

                    </button>

                </form>

            </li>

        </ul>

    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">

        <h2 class="mb-4">
            User Profile
        </h2>

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <div class="card p-4">

            <!-- PROFILE IMAGE -->
            <div class="text-center mb-3">

                @if($user->avatar)

                    <img src="{{ asset('storage/' . $user->avatar) }}"
                         alt="Profile Picture"
                         class="rounded-circle border"
                         width="120"
                         height="120"
                         style="object-fit: cover;">

                @else

                    <img src="https://via.placeholder.com/120"
                         alt="Default Avatar"
                         class="rounded-circle border"
                         width="120"
                         height="120">

                @endif

            </div>

            <p>
                <strong>Name:</strong>
                {{ $user->name }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $user->email }}
            </p>

            <p>
                <strong>Address:</strong>
                {{ $user->address ?? 'N/A' }}
            </p>

            <p>
                <strong>Gender:</strong>
                {{ $user->gender ?? 'N/A' }}
            </p>

            <hr>

            <!-- UPDATE FORM -->
            <form action="{{ route('profile.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label>Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Email</label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Address</label>

                    <input type="text"
                           name="address"
                           value="{{ old('address', $user->address) }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Gender</label>

                    <input type="text"
                           name="gender"
                           value="{{ old('gender', $user->gender) }}"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label>Profile Picture</label>

                    <input type="file"
                           name="avatar"
                           class="form-control">

                </div>

                <button type="submit"
                        class="btn btn-primary">

                    Update Profile

                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
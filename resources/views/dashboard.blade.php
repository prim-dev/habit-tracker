<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

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
                       class="nav-link bg-primary text-white rounded">

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

                        <i class="bi bi-check2-square"></i>
                        Habits

                    </a>

                </li>

            </ul>

        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4">

            <!-- Top Navbar -->
            <div class="d-flex justify-content-between align-items-center mb-4">

                <h2>
                    Dashboard
                </h2>

                <div class="d-flex align-items-center">

                    <span class="me-3">

                        Welcome,
                        {{ auth()->user()->name ?? 'Guest' }}

                    </span>

                    <form action="/logout"
                          method="POST"
                          class="d-inline">

                        @csrf

                        <button type="submit"
                                class="btn btn-danger btn-sm">

                            Logout

                        </button>

                    </form>

                </div>

            </div>

            <!-- Dashboard Cards -->
            <div class="row mb-4">

                <div class="col-md-4 mb-3">

                    <div class="card shadow border-0">

                        <div class="card-body">

                            <h5 class="text-muted">
                                Total Users
                            </h5>

                            <h1 class="fw-bold">
                                {{ $totalUsers }}
                            </h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="card shadow border-0">

                        <div class="card-body">

                            <h5 class="text-muted">
                                Total Habits
                            </h5>

                            <h1 class="fw-bold">
                                {{ $totalHabits }}
                            </h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-4 mb-3">

                    <div class="card shadow border-0">

                        <div class="card-body">

                            <h5 class="text-muted">
                                Total Completions
                            </h5>

                            <h1 class="fw-bold">
                                {{ $totalCompletions }}
                            </h1>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Chart -->
            <div class="card shadow border-0">

                <div class="card-body">

                    <h4 class="mb-4">
                        Habit Tracker Reports
                    </h4>

                    <canvas id="habitChart" height="100"></canvas>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const canvas = document.getElementById('habitChart');

    if (canvas) {

        new Chart(canvas, {

            type: 'bar',

            data: {

                labels: [
                    'Users',
                    'Habits',
                    'Completions'
                ],

                datasets: [{

                    label: 'System Reports',

                    data: [
                        Number("{{ $totalUsers ?? 0 }}"),
                        Number("{{ $totalHabits ?? 0 }}"),
                        Number("{{ $totalCompletions ?? 0 }}")
                    ],

                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#dc3545'
                    ],

                    borderWidth: 1

                }]

            },

            options: {

                responsive: true,

                scales: {

                    y: {

                        beginAtZero: true

                    }

                }

            }

        });

    }

</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</script>

</body>
</html>
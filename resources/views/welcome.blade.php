<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habit Trackerssss</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: #fff7ed;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .navbar{
            background: #f97316;
            padding: 15px 30px;
        }

        .navbar h2{
            color: white;
            margin: 0;
            font-weight: bold;
        }

        .container-box{
            max-width: 1100px;
            margin: auto;
            padding: 30px 20px;
        }

        .dashboard-cards{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card{
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .stat-card h3{
            font-size: 32px;
            color: #f97316;
            margin-bottom: 10px;
        }

        .main-card{
            background: white;
            padding: 25px;
            border-radius: 18px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }

        .form-control{
            border-radius: 10px;
            padding: 12px;
        }

        .btn-orange{
            background: #f97316;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-orange:hover{
            background: #ea580c;
        }

        .habit-card{
            transition: 0.3s;
        }

        .habit-card:hover{
            transform: translateY(-3px);
        }

        .habit-title{
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .habit-description{
            color: #666;
            margin-bottom: 15px;
        }

        .progress{
            height: 10px;
            border-radius: 20px;
            margin-bottom: 15px;
        }

        .progress-bar{
            background: #f97316;
        }

        .complete-text{
            font-weight: bold;
            margin-bottom: 15px;
        }

        @media(max-width:768px){
            .container-box{
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>
 <!-- Navbar -->
    <div class="navbar d-flex justify-content-between align-items-center">

        <h2>🔥 Habit Tracker</h2>

        <a href="{{ route('dashboard') }}"
        class="btn btn-light fw-bold">

            Dashboard

        </a>

    </div>

    <div class="container-box">

          @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

        <!-- Dashboard Stats -->
        <div class="dashboard-cards">

            <div class="stat-card">
                <h3>{{ $habits->count() }}</h3>
                <p>Total Habits</p>
            </div>

            <div class="stat-card">
                <h3>
                    {{ $habits->sum(function($habit){ return $habit->logs->count(); }) }}
                </h3>
                <p>Total Completions</p>
            </div>

            <div class="stat-card">
                <h3>{{ $habits->max(function($habit){ return $habit->logs->count(); }) ?? 0 }}</h3>
                <p>Best Habit Streak</p>
            </div>

        </div>

        <!-- Add Habit -->
        <div class="main-card">

            <h3 class="mb-4">Add New Habit</h3>

            <form method="POST" action="/habits">
                @csrf

                <div class="mb-3">
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        placeholder="Habit Name"
                        required
                    >
                </div>

                <div class="mb-3">
                    <textarea
                        name="description"
                        class="form-control"
                        rows="3"
                        placeholder="Description"
                    ></textarea>
                </div>

                <button type="submit" class="btn-orange">
                    Add Habit
                </button>

            </form>

        </div>

       <!-- Habits -->
@foreach($habits as $habit)

@php
    $progress = min($habit->logs->count() * 10, 100);
@endphp

<div class="main-card habit-card">

    <!-- Top -->
    <div class="d-flex justify-content-between align-items-start mb-3">

        <div>
            <div class="habit-title">
                {{ $habit->title }}
            </div>

            <div class="habit-description">
                {{ $habit->description }}
            </div>
        </div>

        @if($habit->category)
            <span class="badge bg-warning text-dark">
                {{ $habit->category }}
            </span>
        @endif

    </div>

    <!-- Statistics -->
    <div class="row mb-3">

        <div class="col-md-4 mb-2">
            <div class="p-3 bg-light rounded">
                <strong>✅ Total</strong>
                <br>
                {{ $habit->logs->count() }} completions
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="p-3 bg-light rounded">
                <strong>🔥🔥🔥 Current Streak</strong>
                <br>
                {{ $habit->streak }} days
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="p-3 bg-light rounded">
                <strong>🏆 Best Streak</strong>
                <br>
                {{ $habit->longest_streak }} days
            </div>
        </div>

    </div>

    <!-- Progress -->
    <div class="mb-3">

        <div class="d-flex justify-content-between mb-2">
            <span>Progress</span>
            <span>{{ $progress }}%</span>
        </div>

        <div class="progress">

            <div
                class="progress-bar progress-fill"
                data-progress="{{ $progress }}">
            </div>

        </div>

    </div>

    <!-- Buttons -->
    <div class="d-flex gap-2">

        <!-- Complete -->
        <form method="POST"
              action="{{ route('habits.complete', $habit->id) }}">

            @csrf

            <button type="submit" class="btn-orange">
                Complete Today
            </button>

        </form>

        <!-- Delete -->
        <form method="POST"
              action="{{ route('habits.destroy', $habit->id) }}">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-danger">

                Delete

            </button>

        </form>

    </div>

</div>

@endforeach

@if($habits->count() == 0)

<div class="main-card text-center">

    <h3>No habits yet</h3>

    <p class="text-muted">
        Start building better habits today.
    </p>

</div>

@endif


    </div>
    <script>

    document.querySelectorAll('.progress-fill').forEach(bar => {

        let progress = bar.getAttribute('data-progress');

        bar.style.width = progress + '%';

    });

</script>
</body>
</html>
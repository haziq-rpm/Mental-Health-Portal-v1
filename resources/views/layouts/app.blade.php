<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Mental Health Portal')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>

        body{
            background:#f5f7fb;
        }

        .hero{
            padding:90px 0;
        }

        .feature-card{
            transition:.3s;
            border:none;
            border-radius:15px;
        }

        .feature-card:hover{
            transform:translateY(-8px);
            box-shadow:0 12px 25px rgba(0,0,0,.12);
        }

        footer{
            background:#0d6efd;
            color:white;
            padding:20px;
            margin-top:80px;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-heart-pulse-fill"></i>
            Mental Health Portal
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="nav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

                <li class="nav-item ms-2">

                    <a href="/login" class="btn btn-light">

                        Login

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

@yield('content')

<footer class="text-center">

    © 2026 Mental Health Counseling Portal

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
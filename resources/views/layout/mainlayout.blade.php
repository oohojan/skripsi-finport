<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FinPort | @yield('title') </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>

    <div class="main d-flex flex-column justify-content-between">
        <nav class="navbar  navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">FinPort</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
              </button>
            </div>
          </nav>

          <div class="body-content h-100">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block" id="navbarTogglerDemo02">
                    @if (Auth::user()->id_role == 1)
                        {{-- ini buat owner --}}
                        <a href="{{ route('dashboard_owner') }}" class="@if(request()->route()->getName() == 'dashboard_owner') active @endif">Dashboard ></a>
                        <a href="{{ route('profile') }}" class="@if(request()->route()->getName() == 'profile') active @endif">Profile ></a>
                        <a href="{{ route('bisnis_anda') }}" class="@if(request()->route()->getName() == 'bisnis_anda') active @endif">Bisnis Anda ></a>
                        <a href="{{ route('pemasok') }}" class="@if(request()->route()->getName() == 'pemasok') active @endif">Pemasok ></a>
                        <a href="{{ route('lap_keuangan') }}" class="@if(request()->route()->getName() == 'lap_keuangan') active @endif">Laporan Keuangan ></a>
                        <a href="{{ route('transaksi') }}" class="@if(request()->route()->getName() == 'transaksi') active @endif">Transaksi ></a>
                        <a href="{{ route('pelanggan') }}" class="@if(request()->route()->getName() == 'pelanggan') active @endif">Pelanggan ></a>
                        <a href="{{ route('logout') }}">Logout ></a>
                    @else
                        {{-- ini buat employee --}}
                        <a href="{{ route('dashboard_emp') }}" class="@if(request()->route()->getName() == 'dashboard_emp') active @endif">Dashboard ></a>
                        <a href="{{ route('profile') }}" class="@if(request()->route()->getName() == 'profile') active @endif">Profile ></a>
                        <a href="{{ route('transaksi') }}" class="@if(request()->route()->getName() == 'transaksi') active @endif">Transaksi ></a>
                        <a href="{{ route('pelanggan') }}" class="@if(request()->route()->getName() == 'pelanggan') active @endif">Pelanggan ></a>
                        <a href="{{ route('logout') }}">Logout ></a>
                    @endif
                </div>

                <div class="content p-5 col-lg-10">
                        @yield('content')
                </div>
            </div>
          </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

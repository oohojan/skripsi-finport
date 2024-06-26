<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finport Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style>
    .main {
        height: 100vh;
        box-sizing: border-box;
    }

    .form-login {
        margin-top: 50px;
        width: 500px;
        border: solid 1px;
        padding: 20px;
    }
    form div {
        margin-bottom: 20px;
    }

    .error {
        padding-top: 20px;
    }
</style>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div>
            <img src="{{ asset('images/logo.png') }}" alt="FinPort" height="70">
        </div>
        <div class="form-login">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div>
                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                    <input type="text" name="email" id="email" class="form-control" required>
                </div>
                <div>
                    <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary form-control">Login</button>
                </div>
                <div class="text-center">
                    <a href="register">Register For New User</a>
                </div>
            </form>
        </div>
        <div class="error">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

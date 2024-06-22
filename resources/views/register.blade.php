<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finport Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<style>
    .main{
        height: 100vh;
    }
    .form-register{
        width: 500px;
        border: solid 1px;
        padding: 20px;
    }
    .button{
        margin-top: 20px;
    }

    form div{
        margin-bottom: 20px;
    }
</style>

<body>

    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ( $errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-register">
            <form action="" method="post">
                @csrf
                <div>
                    <label for="Nama" class="form-label">Nama <span style="color: red;">*</label>
                    <input type="text" name="Nama" id="Nama" class="form-control" required >
                </div>
                <div>
                    <label for="email" class="form-label">Email <span style="color: red;">*</label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="nama@gmail.com" required>
                </div>
                <div>
                    <label for="password" class="form-label">Password <span style="color: red;">*</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="minimal 8 karakter, gabungan Huruf besar dan Huruf Kecil" required>
                </div>
                <div>
                    <label for="No_Telepon" class="form-label">No Telepon</label>
                    <input type="text" name="No_Telepon" id="No_Telepon" class="form-control" placeholder="minimal 12 karakter">
                </div>
                <div>
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" class="form-control"></textarea>
                </div>
                {{-- <div>
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                            <option value="">Pilih</option>
                            @foreach ($role as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                    </select>
                </div> --}}
                <div class="button">
                    <div>
                        <button type="submit" class="btn btn-primary form-control">Register</button>
                    </div>
                    <div class="text-center">
                        Already Have Account?,<a href="login">Please Login Here!</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

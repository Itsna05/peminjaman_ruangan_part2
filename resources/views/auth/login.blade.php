<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS Login --}}
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="login-wrapper">
    <div class="card login-card shadow">
        <div class="card-body text-center">

            {{-- Logo --}}
            <img src="{{ asset('img/logo_login.png') }}"
                 alt="Logo DPU"
                 class="login-logo mb-4">

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- FORM LOGIN --}}
            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Masukkan Username"
                           value="{{ old('username') }}"
                           required>
                </div>

                <div class="mb-4">
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Masukkan Password"
                           required>
                </div>

                <button type="submit"
                        class="btn btn-warning w-100 fw-semibold">
                    MASUK
                </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>

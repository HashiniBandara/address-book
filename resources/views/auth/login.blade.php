<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-form {
            width: 75%;
            /* Set the width to 75% */
            max-width: 1000px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 text-white p-5" style="background-color:#2D334A">
                <!-- Left side with image or gif -->
                <h2 class="text-center text-uppercase">Welcome toCustomer Address Book!</h2>
                <img src="../images/login.png" width="100%" alt="">
                <!-- You can add an image or gif here -->
            </div>
            <div class="col-md-7 login-container">
                <!-- Right side with login form -->
                <div class="login-form card">
                    <div class="card-body">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        {{-- <h2 class="text-center">Login Here!</h2> --}}

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" class="form-control" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" class="form-control" type="password" name="password" required
                                    autocomplete="current-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            {{-- <div class="mb-3 form-check">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">Remember me</label>
                            </div> --}}

                            <div class="d-grid gap-2">
                                @if (Route::has('password.request'))
                                    {{-- <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a> --}}
                                @endif

                                <button type="submit" class="btn text-white"
                                    style="background-color:#2D334A">{{ __('Log in') }}</button>

                                {{-- <a class="btn text-white" style="background-color:#2D334A"
                                    href="{{ route('register') }}">
                                    {{ __("Don't have an account yet?") }} <strong class="text-primary btn-link"
                                        style="">Sing Up</strong>
                                </a> --}}
                                {{-- <a class="btn text-white" style="background-color:#2D334A" href="{{ route('index') }}">
                                    {{ __('') }} <strong class="text-primary btn-link" style="">Back To
                                        Web</strong>
                                </a> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
</script>

</html>

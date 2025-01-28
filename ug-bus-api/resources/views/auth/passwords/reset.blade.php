<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset Password | Rasaank Labz Balad</title>
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            body {
                background-color: #e4e4e4;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
            }

            .card {
                background-color: #ffffff;
                border: none;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
                color: #000000;
                max-width: 500px;
                border-radius: 20px;
            }

            .btn-primary {
                background-color: #007bff;
                color: #ffffff;
                border: none;
            }

            .btn-primary:hover {
                background-color: #0056b3;
            }

            .invalid-feedback {
                color: #dc3545;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>{{ __('Reset Password') }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input name="token" type="hidden" value="{{ $token }}">

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end"
                                    for="email">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" type="email" value="{{ $email ?? old('email') }}" required
                                        autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end"
                                    for="password">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password"
                                        name="password" type="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end"
                                    for="password-confirm">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input class="form-control" id="password-confirm" name="password_confirmation"
                                        type="password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>

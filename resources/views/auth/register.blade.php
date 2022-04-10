@extends('layouts.guest')

@section('title',config('app.name') . ' | Registration')

@section('content')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>HrP</b>Integrator</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">{{ __('Register') }}</p>
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
                               placeholder="Enter your full name.."
                               required autocomplete="name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input name="organization_name" id="organization_name" type="text"
                               class="form-control @error('organization_name') is-invalid @enderror" value="{{ old('organization_name') }}"
                               placeholder="Enter your organisation  name.."
                               required autocomplete="organization_name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('organization_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="email" name="email" type="email"
                               class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                               placeholder="Enter your email.."
                               required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="phone" name="phone" type="text"
                               class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                               placeholder="Enter phone number.."
                               required autocomplete="phone" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" name="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}"
                               placeholder="Enter your password.."
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}"
                               placeholder="Enter your password again.."
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-0">
                    <a href="{{ route('login') }}" class="text-center">{{ __('Already registered? Please Login') }}</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
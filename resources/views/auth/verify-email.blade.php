@extends('layouts.guest')

@section('title',config('app.name') . ' | Verify Email')

@push('css')
    <style>
        .verify-email-box {
            width: 390px;
        }
    </style>
@endpush

@section('content')
    <div class="verify-email-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>HrP</b>Integrator</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">{{ __('Verify Email') }}</p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Success!</h5>
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <p>
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </p>

                <div class="row">
                    <div class="col-8">
                        <form action="{{ route('verification.send') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-secondary btn-block">{{ __('Resend Verification Email') }}</button>
                        </form>
                    </div>

                    <div class="col-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection



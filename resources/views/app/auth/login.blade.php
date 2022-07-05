@extends('app/auth/components/main')
@section('title', 'Login')

@section('content')
    <div class="col-xl-10 col-lg-12 col-md-9 my-5">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5 mb-4">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login</h1>
                            </div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                @if (Session::has('error'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email"
                                        id="email" placeholder="Masukkan email..">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" name="password"
                                        id="password" placeholder="Masukkan Password..">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="remember_me"
                                            name="remember">
                                        <label class="custom-control-label" for="remember_me">Remember
                                            Me</label>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

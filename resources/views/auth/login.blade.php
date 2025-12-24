@extends('layouts.app')

@section('content')
<section class="hero-section-version1 zindex1 position-relative py-space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="whitebg p-xxl-10 p-xl-8 p-lg-6 p-5 radius20 shadow">
                    <div class="section-title text-center mb-xxl-8 mb-6">
                        <span class="fs18 fw-500 theme-clr d-block mb-2">Welcome Back</span>
                        <h3 class="heading black-clr">Login to Cast-Ink</h3>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="d-grid gap-4">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="black-clr fw-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Enter your email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger fs14 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="black-clr fw-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Enter your password" required>
                            @error('password')
                                <span class="text-danger fs14 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="pra-clr fs14">Remember Me</label>
                            </div>
                            <a href="#" class="theme-clr fs14 fw-500">Forgot Password?</a>
                        </div>

                        <button type="submit" class="touch-btn theme-bg white-clr text-uppercase py-3 px-5 radius10 border-0 mt-2">
                            Login Now
                        </button>

                        <div class="text-center mt-4">
                            <span class="pra-clr">Don't have an account? </span>
                            <a href="{{ route('register') }}" class="theme-clr fw-700">Register Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

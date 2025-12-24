@extends('layouts.app')

@section('content')
<section class="hero-section-version1 zindex1 position-relative py-space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="whitebg p-xxl-10 p-xl-8 p-lg-6 p-5 radius20 shadow">
                    <div class="section-title text-center mb-xxl-8 mb-6">
                        <span class="fs18 fw-500 theme-clr d-block mb-2">Join Us</span>
                        <h3 class="heading black-clr">Create Your Account</h3>
                    </div>

                    <form action="{{ route('register') }}" method="POST" class="d-grid gap-4">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="black-clr fw-700 mb-2">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Enter your name" required value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger fs14 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="black-clr fw-700 mb-2">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Enter your email" required value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger fs14 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="black-clr fw-700 mb-2">Password</label>
                            <input type="password" name="password" id="password" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Create a password" required>
                            @error('password')
                                <span class="text-danger fs14 mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="black-clr fw-700 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control py-3 px-4 radius10 border-0 bg4-clr" placeholder="Confirm your password" required>
                        </div>

                        <button type="submit" class="touch-btn theme-bg white-clr text-uppercase py-3 px-5 radius10 border-0 mt-2">
                            Register Now
                        </button>

                        <div class="text-center mt-4">
                            <span class="pra-clr">Already have an account? </span>
                            <a href="{{ route('login') }}" class="theme-clr fw-700">Login Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

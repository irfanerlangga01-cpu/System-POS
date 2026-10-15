@extends('layout.app')

@section('content')
<div class="login-page">
    <div class="login-card">
        <div class="text-center mb-4">
            <img src="{{ asset('img/logo 1.png') }}" alt="ROHMAN" style="width: 160px; height: 160px; border-radius: 40px; margin-bottom: 16px;">
            <h4 class="fw-bold text-dark">ROHMAN</h4>
            <p class="text-muted small">Percetakan & Fotokopi</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-medium d-block mb-1">Email</label>
                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @endif" 
                       placeholder="Masukkan email" required autofocus>
                @error('email')
                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-medium d-block mb-1">Password</label>
                <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @endif" 
                       placeholder="Masukkan password" required>
                @error('password')
                    <div class="invalid-feedback mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
@section('title', 'Iniciar Sesión')
<section class="login-section" style="position: relative; min-height: 100vh; overflow: hidden;">
    <!-- Video de fondo con overlay mejorado -->
    <video autoplay muted loop id="bgVideo" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0;">
        <source src="/video3.mp4" type="video/mp4">
        Tu navegador no soporta el video.
    </video>
    
    <!-- Agregado overlay con gradiente sofisticado -->
    <div class="video-overlay"></div>
    
    <div class="container" style="position: relative; z-index: 2;">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <!-- Agregado icono y animación de entrada -->
                    <div class="logo-container">
                        <div class="logo-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V19C3 20.1 3.9 21 5 21H11V19H5V3H13V9H21ZM14 10V12H16V10H14ZM14 13V15H16V13H14ZM14 16V18H16V16H14ZM17 10V12H19V10H17ZM17 13V15H19V13H17ZM17 16V18H19V16H17Z" fill="currentColor"/>
                            </svg>
                        </div>
                    </div>
                    <h2>Bienvenido de Vuelta</h2>
                    <p>Accede a tu cuenta para administrar tu finca de cacao</p>
                    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
                </div>

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Correo Electrónico
                        </label>
                        <div class="input-wrapper">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="tu@email.com">
                        </div>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="16" r="1" fill="currentColor"/>
                                <path d="M7 11V7C7 5.67392 7.52678 4.40215 8.46447 3.46447C9.40215 2.52678 10.6739 2 12 2C13.3261 2 14.5979 2.52678 15.5355 3.46447C16.4732 4.40215 17 5.67392 17 7V11" stroke="currentColor" stroke-width="2"/>
                            </svg>
                            Contraseña
                        </label>
                        <div class="input-wrapper">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password"
                                placeholder="••••••••">
                            <!-- Agregado botón para mostrar/ocultar contraseña -->
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <svg class="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" stroke="currentColor" stroke-width="2"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="checkbox-label">Recordarme</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-login-submit">
                            <span class="btn-text">Ingresar</span>
                            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="login-info">
                <div class="info-content">
                    <h3>Beneficios de CacaoAdmin</h3>
                    <ul class="benefits-list">
                        <li>
                            <div class="check-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Control completo de la producción de cacao</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Gestión financiera simplificada</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Seguimiento de trabajadores y tareas</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Reportes detallados y estadísticas</span>
                        </li>
                        <li>
                            <div class="check-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <polyline points="20,6 9,17 4,12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Soporte técnico especializado</span>
                        </li>
                    </ul>
                    
                    <div class="testimonial">
                        <div class="quote-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3 21C3 17.4 3 14.8 3 12.2C3 6.4 7.6 2 12.2 2C18 2 21 6.4 21 12.2C21 18 18 21 12.2 21C9.4 21 6.6 21 3 21Z" fill="currentColor" opacity="0.1"/>
                                <path d="M14.017 18L14.017 10.609C14.017 4.905 17.748 1.039 23 0L23.995 2.151C21.563 3.068 20 5.789 20 8H24V18H14.017ZM0 18V10.609C0 4.905 3.748 1.038 9 0L9.996 2.151C7.563 3.068 6 5.789 6 8H9.983L9.983 18L0 18Z" fill="currentColor"/>
                            </svg>
                        </div>
                        <p>"CacaoAdmin transformó la manera en que administro mi finca. Ahora puedo ver claramente mis ganancias y planificar mejor"</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">JM</div>
                            <span>José Martínez, Productor de Cacao</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Agregado JavaScript para funcionalidad mejorada -->
<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.querySelector('.eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke="currentColor" stroke-width="2"/>
            <line x1="1" y1="1" x2="23" y2="23" stroke="currentColor" stroke-width="2"/>
        `;
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z" stroke="currentColor" stroke-width="2"/>
            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const loginCard = document.querySelector('.login-card');
    const loginInfo = document.querySelector('.login-info');
    
    setTimeout(() => {
        loginCard.classList.add('animate-in');
        loginInfo.classList.add('animate-in');
    }, 100);
});
</script>
@endsection

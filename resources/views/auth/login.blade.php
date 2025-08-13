@extends('layouts.app')

@section('content')
@section('title', 'Iniciar Sesión')
<section class="login-section">
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <h2>Iniciar Sesión</h2>
                    <p>Accede a tu cuenta para administrar tu finca de cacao</p>
                    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

                </div>

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Recordarme</label>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-login-submit">
                            Ingresar
                        </button>
                    </div>

                    <div class="form-group forgot-password">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                </form>


            </div>

            <div class="login-info">
                <h3>Beneficios de CacaoAdmin</h3>
                <ul>
                    <li><span class="check-icon">✓</span> Control completo de la producción de cacao</li>
                    <li><span class="check-icon">✓</span> Gestión financiera simplificada</li>
                    <li><span class="check-icon">✓</span> Seguimiento de trabajadores y tareas</li>
                    <li><span class="check-icon">✓</span> Reportes detallados y estadísticas</li>
                    <li><span class="check-icon">✓</span> Soporte técnico especializado</li>
                </ul>
                <div class="testimonial">
                    <p>"CacaoAdmin transformó la manera en que administro mi finca. Ahora puedo ver claramente mis ganancias y planificar mejor"</p>
                    <span>- José Martínez, Productor de Cacao</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

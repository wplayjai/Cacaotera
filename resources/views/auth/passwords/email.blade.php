@extends('layouts.app')

@section('content')
<style>
:root {
  --dark-brown: #3A271B;
  --medium-brown: #6B4226;
  --light-brown: #AA7C52;
  --cream: #F5E9D9;
  --soft-brown: #D4B599;
}

.cacao-container {
  background-color: var(--cream);
  padding: 2rem 0;
  min-height: 100vh;
  display: flex;
  align-items: center;
}

.cacao-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 10px 20px rgba(58, 39, 27, 0.1);
  overflow: hidden;
}

.cacao-card-header {
  background: linear-gradient(135deg, var(--dark-brown), var(--medium-brown));
  color: white;
  padding: 1.5rem;
  font-size: 1.5rem;
  text-align: center;
  border-bottom: none;
}

.cacao-card-body {
  background-color: white;
  padding: 2rem;
}

.form-label {
  color: var(--dark-brown);
  font-weight: 600;
}

.form-control {
  border: 2px solid var(--soft-brown);
  border-radius: 8px;
  padding: 10px 15px;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--medium-brown);
  box-shadow: 0 0 0 0.25rem rgba(170, 124, 82, 0.25);
}

.btn-cacao {
  background: linear-gradient(to right, var(--medium-brown), var(--dark-brown));
  border: none;
  color: white;
  padding: 12px 30px;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
  width: 100%;
}

.btn-cacao:hover {
  background: linear-gradient(to right, var(--dark-brown), var(--medium-brown));
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(107, 66, 38, 0.3);
}

.cacao-logo {
  max-width: 80px;
  margin-bottom: 1rem;
}

.cacao-title {
  font-weight: bold;
  color: var(--dark-brown);
  margin-bottom: 1.5rem;
  text-align: center;
}

.input-with-icon {
  position: relative;
}

.input-icon {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--light-brown);
  cursor: pointer;
}

.cacao-alert {
  background-color: #E6F4E6;
  border-left: 4px solid #3C8A3C;
  color: #2C662C;
  padding: 1rem;
  margin-bottom: 1.5rem;
  border-radius: 8px;
}

.cacao-info {
  margin-bottom: 1.5rem;
  text-align: center;
  color: var(--medium-brown);
  font-size: 0.95rem;
  line-height: 1.5;
}
</style>

<div class="cacao-container">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="text-center">
          <img src="/img/cacao.png" alt="Logo Cacao" class="cacao-logo">
          <h2 class="cacao-title">Gestión Contable Finca Cacao</h2>
        </div>
        
        <div class="cacao-card">
          <div class="cacao-card-header">
            Recuperar Contraseña
          </div>

          <div class="cacao-card-body">
            @if (session('status'))
              <div class="cacao-alert" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <div class="cacao-info">
              Ingrese su correo electrónico y le enviaremos un enlace para restablecer su contraseña.
            </div>

            <form method="POST" action="{{ route('password.email') }}">
              @csrf

              <div class="mb-4">
                <label for="email" class="form-label">Correo Electrónico</label>
                <div class="input-with-icon">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ejemplo@correo.com">
                  <i class="input-icon">✉️</i>
                </div>
                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="mt-5">
                <button type="submit" class="btn btn-cacao">
                  Enviar Enlace de Recuperación
                </button>
              </div>
            </form>
          </div>
        </div>
        
        <div class="text-center mt-4">
          <a href="{{ route('login') }}" style="color: var(--medium-brown); text-decoration: none; font-weight: 600;">
            Volver al inicio de sesión
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.masterr')

@section('content')
<div class="container-fluid mt-4" style="background-color: #f8f6f0; min-height: 100vh; padding: 2rem;">
    <!-- Header simplificado con diseño limpio similar a la imagen -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%); color: white; border-radius: 15px;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-4" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border: 3px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-user" style="font-size: 2rem; color: white;"></i>
                            </div>
                            <div>
                                <h2 class="mb-1" style="font-weight: 600;">{{ Auth::user()->name }}</h2>
                                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">Gestor de AgroFinca</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success px-3 py-2 mb-2" style="font-size: 0.9rem;">Activo</span><br>
                            <span class="badge bg-warning text-dark px-3 py-2" style="font-size: 0.9rem;">{{ Auth::user()->role ?? 'Administrador' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de información organizadas como en la imagen -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3" style="color: #17a2b8; font-weight: 600;">
                        <i class="fas fa-envelope me-2"></i>Contacto
                    </h5>
                    <div class="mb-3">
                        <strong>Email</strong><br>
                        <span class="text-muted">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Teléfono</strong><br>
                        <span class="text-muted">+34 123 456 789</span>
                    </div>
                    <div>
                        <strong>Ubicación</strong><br>
                        <span class="text-muted">Finca El Roble</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3" style="color: #fd7e14; font-weight: 600;">
                        <i class="fas fa-user me-2"></i>Información Personal
                    </h5>
                    <div class="mb-3">
                        <strong>Nombre Completo</strong><br>
                        <span class="text-muted">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Cédula</strong><br>
                        <span class="text-muted">12.345.678-9</span>
                    </div>
                    <div>
                        <strong>Fecha de Nacimiento</strong><br>
                        <span class="text-muted">15/03/1985</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3" style="color: #28a745; font-weight: 600;">
                        <i class="fas fa-briefcase me-2"></i>Información Laboral
                    </h5>
                    <div class="mb-3">
                        <strong>Cargo</strong><br>
                        <span class="text-muted">Administrador General</span>
                    </div>
                    <div class="mb-3">
                        <strong>Fecha de Ingreso</strong><br>
                        <span class="text-muted">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div>
                        <strong>ID Empleado</strong><br>
                        <span class="text-muted">#ADM-001</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección "Acerca del Administrador" como en la imagen -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3" style="color: #6c757d; font-weight: 600;">Acerca del Administrador</h5>
                    <p class="text-muted mb-0" style="line-height: 1.6;">
                        Administrador general de AgroFinca con más de 15 años de experiencia en gestión agrícola y administración 
                        de fincas. Especializado en optimización de procesos productivos, gestión de inventarios y supervisión de 
                        equipos de trabajo. Comprometido con la sostenibilidad y la innovación en el sector agrícola.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de acción simplificados como en la imagen -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <button type="button" class="btn btn-lg me-3" style="background-color: #8B4513; color: white; border-radius: 25px; padding: 12px 30px;" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                Editar Perfil
            </button>
            <button type="button" class="btn btn-outline-secondary btn-lg" style="border-radius: 25px; padding: 12px 30px;" data-bs-toggle="modal" data-bs-target="#cambiarPasswordModal">
                Cambiar Contraseña
            </button>
        </div>
    </div>
</div>

<!-- Modal para editar perfil -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #17a2b8; color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title">Actualizar Datos Básicos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @if(session('update_success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('update_success') }}
                    </div>
                @endif
                @if(session('update_error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('update_error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('perfil.actualizarDatos') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required style="border-radius: 10px;">
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required style="border-radius: 10px;">
                    </div>
                    
                    <button type="submit" class="btn w-100" style="background-color: #17a2b8; color: white; border-radius: 10px;">
                        <i class="fas fa-save me-2"></i>Actualizar Datos
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="cambiarPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px;">
            <div class="modal-header" style="background-color: #8B4513; color: white; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title">Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('perfil.cambiarPassword') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="password_actual" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="password_actual" name="password_actual" required style="border-radius: 10px;">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_nueva" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_nueva" name="password_nueva" required style="border-radius: 10px;">
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_nueva_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_nueva_confirmation" name="password_nueva_confirmation" required style="border-radius: 10px;">
                    </div>
                    
                    <button type="submit" class="btn w-100" style="background-color: #8B4513; color: white; border-radius: 10px;">
                        <i class="fas fa-save me-2"></i>Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

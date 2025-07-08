{{-- resources/views/produccion/create.blade.php --}}
@extends('layouts.masterr')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-plus"></i> Registrar Nueva Producción</h4>
                    <a href="{{ route('produccion.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                
                <div class="card-body">
                    {{-- Mensajes de error --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Mostrar todos los errores de validación --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Por favor corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form action="{{ route('produccion.store') }}" method="POST" id="produccionForm">
    @csrf

    {{-- Información del Cultivo --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-seedling"></i> Información del Cultivo</h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Lote --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lote_id">Lote *</label>
                    <select name="lote_id" id="lote_id" class="form-control @error('lote_id') is-invalid @enderror" required>
                        <option value="">Seleccionar Lote</option>
                        @foreach($lotes as $lote)
                            <option value="{{ $lote->id }}" 
                                    {{ old('lote_id') == $lote->id ? 'selected' : '' }}
                                    data-area="{{ $lote->area_hectareas }}"
                                    data-ubicacion="{{ $lote->ubicacion }}">
                                {{ $lote->nombre }} - {{ $lote->area_hectareas }} ha
                            </option>
                        @endforeach
                    </select>
                    @error('lote_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tipo de Cacao --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo_cacao">Tipo de Cacao *</label>
                    <select name="tipo_cacao" id="tipo_cacao" class="form-control @error('tipo_cacao') is-invalid @enderror" required>
                        <option value="">Seleccionar Tipo</option>
                        <option value="criollo" {{ old('tipo_cacao') == 'criollo' ? 'selected' : '' }}>Criollo</option>
                        <option value="trinitario" {{ old('tipo_cacao') == 'trinitario' ? 'selected' : '' }}>Trinitario</option>
                        <option value="forastero" {{ old('tipo_cacao') == 'forastero' ? 'selected' : '' }}>Forastero</option>
                    </select>
                    @error('tipo_cacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Trabajadores asignados --}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="trabajadores">Trabajadores Asignados *</label>
                    <select name="trabajadores[]" id="trabajadores" class="form-control @error('trabajadores') is-invalid @enderror" multiple required>
                        @foreach($trabajadores as $trabajador)
                            <option value="{{ $trabajador->id }}" 
                                    {{ in_array($trabajador->id, old('trabajadores', [])) ? 'selected' : '' }}>
                                {{ $trabajador->user->name }} {{ $trabajador->user->apellido ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('trabajadores')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Info lote dinámica --}}
        <div id="infoLote" class="alert alert-info" style="display: none;">
            <strong>Información del Lote:</strong>
            <div id="loteDetails"></div>
        </div>
    </div>
</div>

{{-- Programación de Producción --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Programación de Producción</h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Fecha Inicio --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_inicio">Fecha Inicio *</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           class="form-control @error('fecha_inicio') is-invalid @enderror" 
                           value="{{ old('fecha_inicio') }}" required>
                    @error('fecha_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Fecha Fin Esperada --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_fin_esperada">Fecha Fin Esperada *</label>
                    <input type="date" name="fecha_fin_esperada" id="fecha_fin_esperada" 
                           class="form-control @error('fecha_fin_esperada') is-invalid @enderror" 
                           value="{{ old('fecha_fin_esperada') }}" required>
                    @error('fecha_fin_esperada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Fecha Cosecha --}}
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha_programada_cosecha">Fecha Programada Cosecha</label>
                    <input type="date" name="fecha_programada_cosecha" id="fecha_programada_cosecha" 
                           class="form-control @error('fecha_programada_cosecha') is-invalid @enderror" 
                           value="{{ old('fecha_programada_cosecha') }}">
                    @error('fecha_programada_cosecha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Duración estimada --}}
        <div class="alert alert-secondary" id="duracionInfo" style="display: none;">
            <strong>Duración estimada:</strong> <span id="duracionTexto"></span>
        </div>
    </div>
</div>

{{-- Datos de Producción --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Datos de Producción</h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Área Asignada --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="area_asignada">Área Asignada (hectáreas) *</label>
                    <input type="number" step="0.01" name="area_asignada" id="area_asignada" 
                           class="form-control @error('area_asignada') is-invalid @enderror" 
                           value="{{ old('area_asignada') }}" required>
                    @error('area_asignada')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Área máxima disponible en el lote: <span id="areaMaxima">0</span> ha
                    </small>
                </div>
            </div>

            {{-- Rendimiento Esperado --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estimacion_produccion">Rendimiento Esperado (toneladas) *</label>
                    <input type="number" step="0.01" name="estimacion_produccion" id="estimacion_produccion" 
                           class="form-control @error('estimacion_produccion') is-invalid @enderror" 
                           value="{{ old('estimacion_produccion') }}" required>
                    @error('estimacion_produccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        Rendimiento por hectárea: <span id="rendimientoHa">0</span> ton/ha
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Estado --}}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="estado">Estado *</label>
            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror" required>
                <option value="planificado" {{ old('estado', 'planificado') == 'planificado' ? 'selected' : '' }}>Planificado</option>
                <option value="siembra" {{ old('estado') == 'siembra' ? 'selected' : '' }}>Siembra</option>
                <option value="crecimiento" {{ old('estado') == 'crecimiento' ? 'selected' : '' }}>Crecimiento</option>
                <option value="maduracion" {{ old('estado') == 'maduracion' ? 'selected' : '' }}>Maduración</option>
                <option value="cosecha" {{ old('estado') == 'cosecha' ? 'selected' : '' }}>Cosecha</option>
                <option value="secado" {{ old('estado') == 'secado' ? 'selected' : '' }}>Secado</option>
                <option value="completado" {{ old('estado') == 'completado' ? 'selected' : '' }}>Completado</option>
            </select>
            @error('estado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

{{-- Información Adicional --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información Adicional</h5>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- Costo --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="costo_total">Costo Estimado (COP)</label>
                    <input type="number" step="0.01" name="costo_total" id="costo_total" 
                           class="form-control @error('costo_total') is-invalid @enderror" 
                           value="{{ old('costo_total') }}">
                    @error('costo_total')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Tipo de Siembra --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo_siembra">Tipo de Siembra</label>
                    <select name="tipo_siembra" id="tipo_siembra" class="form-control @error('tipo_siembra') is-invalid @enderror">
                        <option value="">Seleccionar tipo</option>
                        <option value="directa" {{ old('tipo_siembra') == 'directa' ? 'selected' : '' }}>Directa</option>
                        <option value="transplante" {{ old('tipo_siembra') == 'transplante' ? 'selected' : '' }}>Transplante</option>
                        <option value="injerto" {{ old('tipo_siembra') == 'injerto' ? 'selected' : '' }}>Injerto</option>
                    </select>
                    @error('tipo_siembra')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

                                
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones" 
                                              class="form-control @error('observaciones') is-invalid @enderror" 
                                              rows="3" placeholder="Ingrese cualquier observación relevante...">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Registrar Producción
                    </button>
                    <a href="{{ route('produccion.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function() {
    // Actualizar información del lote cuando se selecciona
    $('#lote_id').change(function() {
        const selectedOption = $(this).find('option:selected');
        const area = selectedOption.data('area');
        const ubicacion = selectedOption.data('ubicacion');
        
        if (area && $(this).val() !== '') {
            $('#infoLote').show();
            $('#loteDetails').html(`
                <strong>Área:</strong> ${area} hectáreas<br>
                <strong>Ubicación:</strong> ${ubicacion}
            `);
            $('#areaMaxima').text(area);
            
            if (!$('#area_asignada').val()) {
                $('#area_asignada').val(area);
            }
        } else {
            $('#infoLote').hide();
            $('#areaMaxima').text('0');
        }
    });

    // Calcular duración entre fechas
    $('#fecha_inicio, #fecha_fin_esperada').change(function() {
        const fechaInicio = $('#fecha_inicio').val();
        const fechaFin = $('#fecha_fin_esperada').val();
        
        if (fechaInicio && fechaFin) {
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);
            const diferencia = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
            
            if (diferencia > 0) {
                $('#duracionInfo').show();
                $('#duracionTexto').text(`${diferencia} días (${Math.round(diferencia / 30)} meses aproximadamente)`);
            } else {
                $('#duracionInfo').hide();
            }
        } else {
            $('#duracionInfo').hide();
        }
    });

    // Calcular rendimiento por hectárea
    $('#area_asignada, #estimacion_produccion').on('input', function() {
        const area = parseFloat($('#area_asignada').val()) || 0;
        const rendimiento = parseFloat($('#estimacion_produccion').val()) || 0;
        
        if (area > 0 && rendimiento > 0) {
            const rendimientoHa = (rendimiento / area).toFixed(2);
            $('#rendimientoHa').text(rendimientoHa);
        } else {
            $('#rendimientoHa').text('0');
        }
    });

    // Validar área máxima
    $('#area_asignada').on('input', function() {
        const areaIngresada = parseFloat($(this).val()) || 0;
        const areaMaxima = parseFloat($('#areaMaxima').text()) || 0;
        
        if (areaIngresada > areaMaxima && areaMaxima > 0) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">El área no puede exceder el área del lote</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Validación de fechas
    $('#fecha_fin_esperada').change(function() {
        const fechaInicio = new Date($('#fecha_inicio').val());
        const fechaFin = new Date($(this).val());
        
        if (fechaInicio && fechaFin && fechaFin <= fechaInicio) {
            $(this).addClass('is-invalid');
            if (!$(this).siblings('.invalid-feedback').length) {
                $(this).after('<div class="invalid-feedback">La fecha fin debe ser posterior a la fecha inicio</div>');
            }
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // Validación del formulario antes de enviar
    $('#produccionForm').submit(function(e) {
        e.preventDefault();
        
        let isValid = true;
        let missingFields = [];
        
        if (!$('#lote_id').val()) {
            isValid = false;
            missingFields.push('Lote');
        }
        if (!$('#tipo_cacao').val()) {
            isValid = false;
            missingFields.push('Tipo de Cacao');
        }
        if (!$('#trabajadores').val()) {
            isValid = false;
            missingFields.push('Trabajadores');
        }
        if (!$('#fecha_inicio').val()) {
            isValid = false;
            missingFields.push('Fecha de Inicio');
        }
        if (!$('#fecha_fin_esperada').val()) {
            isValid = false;
            missingFields.push('Fecha Fin Esperada');
        }
        if (!$('#area_asignada').val()) {
            isValid = false;
            missingFields.push('Área Asignada');
        }
        if (!$('#estimacion_produccion').val()) {
            isValid = false;
            missingFields.push('Rendimiento Esperado');
        }
        
        if (!isValid) {
            Swal.fire({
                title: 'Campos Requeridos',
                text: 'Por favor completa los siguientes campos: ' + missingFields.join(', '),
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return;
        }
        
        Swal.fire({
            title: '¿Registrar Producción?',
            text: 'Se creará una nueva producción con los datos ingresados',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
@endpush
@endsection
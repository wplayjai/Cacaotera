@extends('layouts.masterr')

@section('content')
<div class="container mt-5">
  <h3 class="text-warning mb-4">Salida de Inventario</h3>
  <form action="{{ route('inventario.salida.store') }}" method="POST" id="salidaInventarioForm">
    @csrf

     <div class="form-group">
  <label for="insumo_id">Insumo</label>
  <select class="form-control" id="insumo_id" name="insumo_id" required>
    <option value="">Seleccione un insumo</option>
    @foreach($inventarios as $insumo)
      <option value="{{ $insumo->id }}">{{ $insumo->nombre }} ({{ $insumo->tipo }})</option>
    @endforeach
  </select>
</div>

    <div class="form-group">
      <label for="lote_nombre">Nombre</label>
      <select class="form-control" id="lote_nombre" name="lote_nombre" required>
        <option value="">Seleccione un lote</option>
       @if(isset($lotes) && count($lotes) > 0)
  @foreach($lotes as $lote)
    <option value="{{ $lote->nombre }}" data-tipo="{{ $lote->tipo_cacao }}">{{ $lote->nombre }}</option>
  @endforeach
@else
  <option value="">No hay lotes disponibles</option>
@endif

      </select>
    </div>

    <div class="form-group">
      <label for="tipo_cacao">Tipo de Cacao</label>
      <input type="text" class="form-control" id="tipo_cacao" name="tipo_cacao" readonly>
    </div>

    <div class="form-group">
      <label for="tipo_salida">Tipo</label>
      <select class="form-control" id="tipo_salida" name="tipo" required>
        <option value="">Seleccione un tipo</option>
        <option value="Fertilizantes">Fertilizantes</option>
        <option value="Pesticidas">Pesticidas</option>
      </select>
    </div>

    <div class="form-group">
      <label for="cantidad_salida">Cantidad (por unidad)</label>
      <input type="number" class="form-control" id="cantidad_salida" name="cantidad" min="1" required>
    </div>

    <div class="form-group">
      <label for="unidad_medida_salida">Unidad de Medida</label>
      <select class="form-control" id="unidad_medida_salida" name="unidad_medida" required>
        <option value="">Seleccione</option>
        <option value="kg">kg</option>
        <option value="ml">ml</option>
      </select>
    </div>

    <div class="form-group">
      <label for="precio_unitario_salida">Precio Unitario</label>
      <input type="number" class="form-control" id="precio_unitario_salida" name="precio_unitario" min="0" step="0.01" required>
    </div>

    <div class="form-group">
      <label for="estado_salida">Estado</label>
      <select class="form-control" id="estado_salida" name="estado" required>
        <option value="Óptimo">✅ Óptimo</option>
        <option value="Por vencer">⚠️ Por vencer</option>
        <option value="Restringido">🔒 Restringido</option>
      </select>
    </div>

    <div class="form-group">
      <label for="fecha_registro_salida">Fecha de Registro</label>
      <input type="date" class="form-control" id="fecha_registro_salida" name="fecha_registro" required>
    </div>

    <div class="text-right">
      <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
      <button type="submit" class="btn btn-warning">Registrar Salida</button>
    </div>
  </form>
</div>

<script>
  // Autocompletar tipo de cacao
  document.getElementById('lote_nombre').addEventListener('change', function () {
    const tipo = this.options[this.selectedIndex].getAttribute('data-tipo');
    document.getElementById('tipo_cacao').value = tipo || '';
  });
</script>
@endsection

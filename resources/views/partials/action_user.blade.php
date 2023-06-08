{{--  <a class="btn btn-xs btn-flat btn-danger delete_dt" data-toggle="tooltip" data-placement="bottom" data-title="Eliminar" 
    data-route="{{ route('configurations.user.destroy', $id) }}">
    <span class="icon-trash-empty"></span>
</a>  --}}
<a class="btn btn-xs btn-flat btn-success delete_dt" data-toggle="tooltip" data-placement="bottom" data-title="Reiniciar clave" 
    onclick="resetPassUser({{ $id }});">
    <span class="icon-arrows-cw"></span>
</a>
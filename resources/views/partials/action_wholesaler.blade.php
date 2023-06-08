<a class="btn btn-xs btn-flat btn-primary edit_dt" data-toggle="tooltip" data-placement="bottom" data-title="Editar" 
    data-route="{{ route('catalogs.wholesaler.show', $id) }}" data-update="{{ route('catalogs.wholesaler.update', $id) }}">
    <span class="icon-pencil-4"></span>
</a>
<a class="btn btn-xs btn-flat btn-danger delete_dt" data-toggle="tooltip" data-placement="bottom" data-title="Eliminar" 
    data-route="{{ route('catalogs.wholesaler.destroy', $id) }}">
    <span class="icon-trash-empty"></span>
</a>
<a class="btn btn-xs btn-flat btn-primary edit_dt" data-toggle="tooltip" data-placement="bottom" data-title="Editar" 
    data-route="{{ route('configurations.store-shop.show', $id) }}" data-update="{{ route('configurations.store-shop.update', $id) }}">
    <span class="icon-pencil-4"></span>
</a>
<a class="btn btn-xs btn-flat btn-danger delete_dt" data-toggle="tooltip" data-placement="bottom" data-title="Eliminar" 
    data-route="{{ route('configurations.store-shop.destroy', $id) }}">
    <span class="icon-trash-empty"></span>
</a>
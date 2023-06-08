<div class="dropdown">
    <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="fa fa-cogs"></i>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="javascript: void(0);" class="edit_dt" 
                data-route="{{ route('catalogs.product.show', $id) }}" 
                data-update="{{ route('catalogs.product.update', $id) }}">Editar
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="delete_dt"
                data-route="{{ route('catalogs.product.destroy', $id) }}">Desactivar
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="label_dt" onclick="labelProd({{ $id }});">Etiquetar
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="label_dt" onclick="segmentProd({{ $id }});">Segmentar
            </a>
        </li>
        <li>
            <a href="javascript: void(0);" class="label_dt" onclick="sectionProd({{ $id }});">Sección Web
            </a>
        </li>
    </ul>
  </div>
@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
@endsection

@section('title')Lista de Productos @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Productos Ok Computer</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Catálogo</li>
    <li class="active">Productos</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de productos</h6>
            </div>
            <div class="box-body">
                <input type="hidden" name="type_change" value="{{ $tica }}">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableProduct">
                        <thead>
                            <tr>
                                <th width="20">&nbsp;</th>
                                <th width="60">SKU</th>
                                <th width="60">Part Number</th>
                                <th>Nombre Comercial</th>
                                <th>Categoría</th>
                                <th>Sub Categoría</th>
                                <th>Marca</th>
                                <th>Unid.</th>
                                <th width="60">Stock Total</th>
                                <th width="60">Stock Reserv</th>
                                <th width="50">Mon.</th>
                                <th width="70">Costo</th>
                                <th width="50">Imagen</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-data" role="dialog">
    <div class="modal-dialog modal-ml" role="document">
        <div class="modal-content">
            <form id="formulario" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="element">
                <input type="hidden" name="product_id" value="0">
                <input type="hidden" name="effect" value="1">
                <input type="hidden" name="correlative" value="1">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <h6>Nombre</h6>
                                        <input type="text" class="form-control input-sm" name="name" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <h6>Modelo</h6>
                                        <input type="text" class="form-control input-sm" name="model" placeholder="Ingrese el modelo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Categoría</h6>
                                        <select class="form-control input-sm" name="category_id" required onchange="loadSubcat(this.value);">
                                            <option value="" selected disabled>Elija una opcion..</option>
                                            @foreach ($cate as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Sub Categoría</h6>
                                        <select class="form-control input-sm" name="subcategory_id" required>
                                            <option value="" selected disabled>Elija una opcion..</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Marca</h6>
                                        <select class="form-control input-sm" name="mark_id" required>
                                            <option value="" selected disabled>Elija una opcion..</option>
                                            @foreach ($mark as $mar)
                                                <option value="{{ $mar->id }}">{{ $mar->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Unidad Medida</h6>
                                        <select class="form-control input-sm" name="unit_id" required>
                                            <option value="" selected disabled>Elija una opcion..</option>
                                            @foreach ($unit as $uni)
                                                <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6>Part Number</h6>
                                                <input type="text" class="form-control input-sm" name="part_number" placeholder="Ingrese el part number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>SKU</h6>
                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" name="sku" placeholder="Ingrese el sku" readonly required>
                                                <div class="input-group-btn">
                                                    <ul class="dropdown-menu">
                                                        <li><a href="javascript: void(0);" onclick="generateCode();">Generar</a></li>
                                                        <li><a href="javascript: void(0);" onclick="inputCode();">Ingresar</a></li>
                                                    </ul>
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="fa fa-caret-down"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h6>Mayorista</h6>
                                        <select class="form-control input-sm" name="wholesaler_id" required>
                                            <option value="" selected disabled>Elija una opcion..</option>
                                            @foreach ($mayo as $who)
                                                <option value="{{ $who->id }}">{{ $who->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Link <small>(Referencia)</small></h6>
                                        <input type="text" class="form-control input-sm" name="link" placeholder="Ingrese el link">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Link <small>(Indexado)</small></h6>
                                        <input type="text" class="form-control input-sm" name="link_index" placeholder="Ingrese el link para indexar">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <h6>Detalles extras</h6>
                                        <textarea class="form-control input-sm" name="detail" rows="2" style="resize: none"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Características</h6>
                                        <select class="form-control input-sm" name="feature_id" onchange="loadValues(this.value);">
                                            <option value="" selected disabled>Elija una opcion..</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Valores</h6>
                                        <select class="form-control input-sm" name="value_id">
                                            <option value="" selected disabled>Elija una opcion..</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <h6>Especif. Extra</h6>
                                        <input type="text" class="form-control input-sm" name="content">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary btn-flat btn-xs btn-block mt-btn" onclick="addList();">
                                        <i class="icon-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Especificaciones del productos</th>
                                                <th width="25"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="result">
                                            <tr class="tr-init">
                                                <td colspan="2">No se agregaron especificaciones</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-success" id="btnAction"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-excel" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form action="{{ route('import-product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Carga Masiva de Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Archivo Excel</h6>
                                <input type="file" class="form-control" name="excel_file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-success">Cargar archivo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-label" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Etiquetar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <form id="form-tag" method="POST">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="product_id_tag" value="">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Etiqueta</h6>
                                <select name="tag_id" class="form-control input-sm" required>
                                    @foreach ($label as $itemLabel)
                                        <option value="{{ $itemLabel->id }}">{{ $itemLabel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-success">Agregar etiqueta</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-response">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>Lista de etiquetas agregadas</th>
                                    </tr>
                                </thead>
                                <tbody id="result-tag"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-segment" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Segmentar Producto</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <form id="form-segment" method="POST">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="product_id_seg" value="">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Segmento</h6>
                                <select name="segment_id" class="form-control input-sm" required>
                                    @foreach ($segm as $itemSeg)
                                        <option value="{{ $itemSeg->id }}">{{ $itemSeg->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-success">Agregar segmento</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-response">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>Lista de segmentos agregados</th>
                                    </tr>
                                </thead>
                                <tbody id="result-segment"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-section" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Sección Web por Producto</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <form id="form-section" method="POST">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="product_id_sect" value="">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Sección</h6>
                                <select name="section_web_id" class="form-control input-sm" required>
                                    @foreach ($sect as $itemSec)
                                        <option value="{{ $itemSec->id }}">{{ $itemSec->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-success">Agregar sección</button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-response">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>Lista de secciones agregadas</th>
                                    </tr>
                                </thead>
                                <tbody id="result-section"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-filter" role="dialog">
    <div class="modal-dialog modal-smx" role="document">
        <div class="modal-content">
            <form id="form-filter" method="POST">
                <input type="hidden" name="_method" value="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Filtros de búsqueda</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-response">
                                <table class="table table-bordered table-filter mb-0">
                                    <tbody>
                                        <tr>
                                            <td width="180">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_category"> Categoría</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectCategory" class="selectpicker form-control form-control-sm" 
                                                    data-live-search="true" data-width="100%" title="No hay selección">
                                                    @foreach ($cate as $catFilter)
                                                        <option value="{{ $catFilter->id }}">{{ $catFilter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_mark"> Marca</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectMark[]" class="selectpicker form-control form-control-sm" 
                                                    data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="5">
                                                    @foreach ($mark as $markFilter)
                                                        <option value="{{ $markFilter->id }}">{{ $markFilter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_wholesaler"> Mayorista</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectWholesaler[]" class="selectpicker form-control form-control-sm" 
                                                    data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="5">
                                                    @foreach ($mayo as $mayFilter)
                                                        <option value="{{ $mayFilter->id }}">{{ $mayFilter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_caract1"> Procesador</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectCaract1" class="selectpicker form-control form-control-sm" disabled
                                                    data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="10">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_caract2"> Sistema Operativo</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectCaract2" class="selectpicker form-control form-control-sm" disabled
                                                    data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="10">
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="check_caract3"> Almacenamiento</label>
                                                </div>
                                            </td>
                                            <td>
                                                <select name="selectCaract3" class="selectpicker form-control form-control-sm" disabled
                                                    data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="10">
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm btn-block btn-flat">Procesar filtros</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/lte/bower_components/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/JSZip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/lte/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/lte/plugins/bootstrap-select/js/i18n/defaults-es_ES.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        @if (Session::has('key'))
            var tpm = '<?=Session::get("key")?>';
            var msg = '<?=Session::get("message")?>';
            notify(tpm, msg);
        @endif
        
        let cont_espec = 0;
        var value_tc = "{{ $tica }}";
        
        $(document).ready(function () {
            $('.sidebar-mini').addClass('sidebar-collapse');
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            dataList();

            $("#form-segment").on("submit", function() {
                var data = $(this).serializeArray();
                var prod = $("[name=product_id_seg]").val();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.segment-store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == 'ok') {
                            notify(response.alert, response.message);
                            $("#form-segment")[0].reset();
                            loadVariant(prod, 'SEGMENTO');
                        } else {
                            notify(response.alert, response.message);
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                return false;
            });

            $("#form-tag").on("submit", function() {
                var data = $(this).serializeArray();
                var prod = $("[name=product_id_tag]").val();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.tag-store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == 'ok') {
                            notify(response.alert, response.message);
                            $("#form-tag")[0].reset();
                            loadVariant(prod, 'ETIQUETA');
                        } else {
                            notify(response.alert, response.message);
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                return false;
            });

            $("#form-section").on("submit", function() {
                var data = $(this).serializeArray();
                var prod = $("[name=product_id_sect]").val();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.section-store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == 'ok') {
                            notify(response.alert, response.message);
                            $("#form-section")[0].reset();
                            loadVariant(prod, 'SECCION');
                        } else {
                            notify(response.alert, response.message);
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                return false;
            });

            $("#form-filter").on("submit", function() {
                var data = $(this).serializeArray();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.filter-products') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        if (response == "ok") {
                            dataList();
                            $("#modal-filter").modal("hide");
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                return false;
            });
        });

        function dataList() {
            $("#tableProduct").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                order: [[4, "asc"]],
                ajax: {
                    url: "{{ route('catalogs.product.index') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "action", searchable: false, orderable: false},
                    {data: "sku"},
                    {data: "part_number"},
                    {data: "title"},
                    {data: "category"},
                    {data: "subcategory"},
                    {data: "mark"},
                    {data: "unit"},
                    {
                        render: function (data, type, row) {
                            return `<input type="number" onkeypress="updatePress(this, this.value, 'stock', event, `+ row['id'] +`);" value="`+ parseFloat(row['stock']).toFixed(2) +`" style="width: 80px; text-align: right;" />`;
                        },
                        searchable: false, orderable: false
                    },
                    {
                        render: function (data, type, row) {
                            return `<a href="javascript: void(0);" style="display:block; text-align: right;">0.00</a>`;
                        },
                        searchable: false, orderable: false
                    },
                    {
                        render: function (data, type, row) {
                            return `<select class="currency" style="width: 80px;">
                                <option value="2">Dolares</option>
                                <option value="1">Soles</option>
                                </select>`;
                        },
                        searchable: false, orderable: false
                    },
                    {
                        render: function (data, type, row) {
                            return `<input type="number" onkeypress="updatePress(this, this.value, 'cost', event, `+ row['id'] +`);" value="`+ parseFloat(row['cost']).toFixed(2) +`" style="width: 100px; text-align: right;" />`;
                        },
                        searchable: false, orderable: false
                    },
                    {data: "imagen"},
                ],
                buttons: [
                    {
                        text: 'Tipo de Cambio: <span>'+ value_tc +'</span>',
                        action: function () {
                            alert('actualizado a la fecha');
                        },
                        className: 'btn btn-sm btn-flat',
                    },
                    {
                        text: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo registro',
                        action: function () {
                            var store = "{{ route('catalogs.product.store') }}";
                            $("#formulario")[0].reset();
                            $("#result").empty();
                            $("#result").append('<tr class="tr-init"><td colspan="2">No se agregaron especificaciones</td></tr>');
                            $("#formulario").attr("action", store);
                            $("[name=_method]").val("POST");
                            $("#modal-data .modal-title").text("Agregar nuevo producto");
                            $("#btnAction").text("Grabar nuevo producto");
                            $("#modal-data").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-primary',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                    {
                        text: '<span class="fa fa-file-excel-o" aria-hidden="true"></span> Cargar excel',
                        action: function () {
                            $("#modal-excel").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-success',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                    {
                        text: '<span class="fa fa-file-excel-o" aria-hidden="true"></span> Descargar excel',
                        action: function () {
                            exportExcel();
                        },
                        className: 'btn btn-sm btn-flat btn-info',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                    {
                        text: '<span class="fa fa-filter" aria-hidden="true"></span> Filtros de busqueda',
                        action: function () {
                            openFilter();
                        },
                        className: 'btn btn-sm btn-flat',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                ],
            });
        }

        function showData(value) {
            cont_espec = 0;
            $("#result").empty();

            $.ajax({
                type: "GET",
                url : route('catalogs.product.show', {product: value}),
                data: {_token: csrf_token},
                dataType: "JSON",
                success: function (response) {
                    var row;
                    var specif = response.specifications;
                    loadSubcat(response.category_id, response.subcategory_id);

                    $("[name=effect]").val(2)
                    $("[name=product_id]").val(response.id);
                    $("[name=name]").val(response.name);
                    $("[name=model]").val(response.model);
                    $("[name=sku]").val(response.sku);
                    $("[name=part_number]").val(response.part_number);
                    $("[name=category_id]").val(response.category_id);
                    $("[name=subcategory_id]").val(response.subcategory_id);
                    $("[name=unit_id]").val(response.unit_id);
                    $("[name=mark_id]").val(response.mark_id);
                    $("[name=link]").val(response.link);
                    $("[name=link_index]").val(response.link_index);
                    $("[name=detail]").val(response.detail);
                    $("[name=wholesaler_id]").val(response.wholesaler_id);

                    specif.forEach(function (element, index) {
                        cont_espec += 1;
                        var fv_f = specif[index].feature_value.feature;
                        var fv_v = specif[index].feature_value.value;
                        var content = '';

                        if (specif[index].feature_content != null) {
                            content = specif[index].feature_content;
                        }

                        row += `
                        <tr id="espec-`+ cont_espec +`">
                            <td>
                                <input type="hidden" name="specification_id[]" value="`+ specif[index].id +`" />
                                <input type="hidden" name="feature_value[]" value="`+ specif[index].feature_value_id +`" />
                                <input type="hidden" name="feature_content[]" value="`+ specif[index].feature_content +`" />
                                <span>`+ fv_f.name +` `+ fv_v.name +` `+ content +`</span>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-xs btn-flat btn-danger" onclick="deleteEspec(`+ cont_espec +`, `+ specif[index].id +`);"><i class="icon-cancel"></i></button>
                            </td>
                        </tr>`;
                    });

                    $("#result").append(row);
                    $("#modal-data .modal-title").text("Editar el producto [Part Number: "+ response.part_number +"]");
                    $("#btnAction").text("Grabar edición");
                    $("#modal-data").modal("show");
                    $("#formulario").attr("action", route('catalogs.product.update', {product: value}));
                    $("#formulario [name=_method]").val("PUT");
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function deleteData(value){
            if (!confirm("¿Desea desactivar el registro?")) {
                return false;
            }
            $.ajax({
                type: "POST",
                url : route('catalogs.product.destroy', {product: value}),
                data: { _token: csrf_token, _method: "DELETE"},
                dataType: "JSON",
                success: function (response) {
                    notify(response.alert, response.message);
                    $("#tableProduct").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function loadSubcat(id, element = 0){
            loadElement(id, element, 'subcategoria');
            loadElement(id, 0, 'feature');
        }

        function loadElement(id, select=0, type) {
            if (type == 'subcategoria') {
                $("[name=subcategory_id]").empty();
            } else {
                $("[name=feature_id]").empty();
            }
            var row = '<option value="">Elija una opción..</option>';
            var selected;
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-element') }}",
                data: {_token: csrf_token, id: id, type: type},
                dataType: "JSON",
                success: function (response) {
                    if (response.response > 0) {
                        var datax = response.data;
                        datax.forEach(function (element, index) {
                            if (select === element.id) {
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            row += `<option value="`+ element.id +`" `+ selected +`>`+ element.name +`</option>`;
                        });
                        if (type == 'subcategoria') {
                            $("[name=subcategory_id]").html(row);
                        } else {
                            $("[name=feature_id]").html(row);
                        }
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function loadValues(id, select=0) {
            $("[name=value_id]").empty();
            var row = "";
            var selected;
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-value') }}",
                data: { _token: csrf_token, id: id},
                dataType: "JSON",
                success: function (response) {
                    if (response.response > 0) {
                        var datax = response.data;
                        datax.forEach(function (element, index) {
                            if (select === element.id) {
                                selected = "selected";
                            } else {
                                selected = "";
                            }
                            row += `<option value="`+ element.id +`" `+ selected +`>`+ element.value.name +`</option>`;
                        });
                        $("[name=value_id]").html(row);
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function addList() {
            cont_espec += 1;
            var txtFeat = $("[name=feature_id] option:selected").text();
            var txtValu = $("[name=value_id] option:selected").text();
            var idFeVal = $("[name=value_id]").val();
            var content = $("[name=content]").val();

            var trs = $("#result .tr-init").length;
            var espec = txtFeat + ' ' + txtValu + ' ' + content;
            var especText = espec + " ";
            
            var row = `
            <tr id="espec-`+ cont_espec +`">
                <td>
                    <input type="hidden" name="specification_id[]" value="0" />
                    <input type="hidden" name="feature_value[]" value="`+ idFeVal +`" />
                    <input type="hidden" name="feature_content[]" value="`+ content +`" />
                    <span>`+ espec +`</span>
                </td>
                <td align="center">
                    <button type="button" class="btn btn-xs btn-flat btn-danger" onclick="deleteEspec(`+ cont_espec +`);"><i class="icon-cancel"></i></button>
                </td>
            </tr>`;

            if (trs > 0) {
                $("#result").empty();
            }
            $("#result").append(row);
            $("[name=content]").val('');
        }

        function deleteEspec(tr, id = 0) {
            var effect = $("[name=effect]").val();
            var product = $("[name=product_id]").val();

            if (effect == 1) {
                $("#espec-" + tr).remove();
                var total_tr = $("#result").children().length;
                if (total_tr == 0) {
                    $("#result").append(`<tr class="tr-init"><td colspan="2">No se agregaron especificaciones</td></tr>`);
                }
            } else {
                if (!confirm("¿Desea eliminar el item?")) {
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.delete-specification') }}",
                    data: { _token: csrf_token, id: id},
                    dataType: "JSON",
                    success: function (response) {
                        notify(response.alert, response.message);
                        $("#espec-" + tr).remove();
                        var total_tr = $("#result").children().length;
                        if (total_tr == 0) {
                            $("#result").append(`<tr class="tr-init"><td colspan="2">No se agregaron especificaciones</td></tr>`);
                        }
                    }
                }).fail( function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
            }
        }

        function updatePress(element, value, type, event, product) {
            if (event.keyCode == 13) {
                var currency = 0;
                if (type == 'cost') {
                    var tr = element.parentNode.parentNode;
                    currency = tr.children[10].children[0].value;
                }

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.update-product-value') }}",
                    data: {
                        _token: csrf_token,
                        id: product,
                        type: type,
                        currency: currency,
                        value: value
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == "ok") {
                            notify("success", response.message);
                        } else {
                            notify("error", response.message);
                        }
                    }
                }).fail( function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
            }
        }

        function generateCode() {
            $("[name=correlative]").val(1);
            $("[name=sku]").attr('readonly', true);

            var subc = $("[name=subcategory_id]").val();
            var mark = $("[name=mark_id]").val();

            if (subc > 0) {
                if (mark > 0) {
                    $.ajax({
                        type: "POST",
                        url : "{{ route('ajax.generate-sku') }}",
                        data: {
                            _token: csrf_token,
                            subca: subc,
                            marca: mark
                        },
                        dataType: "JSON",
                        success: function (response) {
                            $("[name=sku]").val(response);
                        }
                    }).fail( function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    });
                } else {
                    notify("info", "Debe seleccionar la marca");
                    $("[name=mark_id]").focus();
                }
            } else {
                notify("info", "Debe seleccionar la sub categoría");
                $("[name=subcategory_id]").focus();
            }
        }

        function inputCode() {
            $("[name=sku]").val("");
            $("[name=sku]").removeAttr('readonly');
        }

        function exportExcel() {
            window.location.href = "{{ route('channels.export-excel') }}";
        }

        function segmentProd(id) {
            loadVariant(id, 'SEGMENTO');
            $("[name=product_id_seg]").val(id);
            $("#modal-segment").modal("show");
        }

        function labelProd(id) {
            loadVariant(id, 'ETIQUETA');
            $("[name=product_id_tag]").val(id);
            $("#modal-label").modal("show");
        }

        function sectionProd(id) {
            loadVariant(id, 'SECCION');
            $("[name=product_id_sect]").val(id);
            $("#modal-section").modal("show");
        }

        function loadVariant(id, type) {
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-product-variant') }}",
                data: {
                    _token: csrf_token,
                    id: id,
                    type: type
                },
                dataType: "JSON",
                success: function (response) {
                    var datax = response.data;
                    var row = '';
                    if (type == 'ETIQUETA') {
                        datax.forEach(function (element, index) {
                            row += `<tr><td>`+ element.tag.name +`</td></tr>`;
                        });
                        $("#result-tag").html(row);
                    } else if (type == 'SEGMENTO') {
                        datax.forEach(function (element, index) {
                            row += `<tr><td>`+ element.segment.name +`</td></tr>`;
                        });
                        $("#result-segment").html(row);
                    } else if (type == 'SECCION') {
                        datax.forEach(function (element, index) {
                            row += `<tr><td>`+ element.section_web.name +`</td></tr>`;
                        });
                        $("#result-section").html(row);
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function openFilter() {
            $("#modal-filter").modal("show");
        }
    </script>
@endsection
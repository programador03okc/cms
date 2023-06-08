@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
    <style>
        .eventClick {
            background-color: #fde3fa !important;
        }
    </style>
@endsection

@section('title') Productos de Intcomex @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Productos Intcomex</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-home"></i> CMS OK COMPUTER</a></li>
    <li>Integraciones</li>
    <li class="active">Productos Intcomex</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover" id="tableProductos" style="font-size: x-small">
                        <thead>
                            <tr>
                                <th style="width: 2%"></th>
                                <th style="width: 5%">Tipo</th>
                                <th style="width: 8%">Categoría</th>
                                <th style="width: 13%">Sub Categoría</th>
                                <th style="width: 8%">Fabricante</th>
                                <th style="width: 9%">SKU</th>
                                <th style="width: 9%">Nro. parte</th>
                                <th>Descripción</th>
                                <th style="width: 7%">Moneda</th>
                                <th style="width: 7%">Precio</th>
                                <th style="width: 7%">Stock</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-history" role="dialog">
    <div class="modal-dialog" role="document" style="width: 80%;">
        <div class="modal-content">
            <form id="formulario" method="POST">
                <input type="hidden" name="_method" value="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lista de Productos para Páginas Web</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sku</th>
                                        <th>Categoría</th>
                                        <th>Descripción</th>
                                        <th>Mon</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">Grabar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-filter" role="dialog">
    <div class="modal-dialog" role="document" style="width: 20%;">
        <div class="modal-content">
            <form id="form-filter" method="POST">
                <input type="hidden" name="_method" value="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Filtros</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Categoría</h6>
                                <select name="selectEmpresa[]" class="selectpicker" data-live-search="true" data-width="100%" data-actions-box="true" multiple data-size="10">
                                    @foreach ($filter as $fil)
                                        @if ($fil->Category_Description != null)
                                            <option value="{{ $fil->Category_Description }}">{{ $fil->Category_Description }}</option>
                                        @else
                                            <option value="Sin Categoria">Sin Categoría</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-sm btn-block btn-flat">Procesar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-actions" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Descargas de Intcomex</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <form id="form-process-data" method="POST">
                        <input type="hidden" name="_method" value="POST">
                        @csrf
                        <div class="col-md-12">
                            <div class="table-response">
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Descripción</th>
                                            <th>Ultima Actualización</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_catalog">
                                            </td>
                                            <td>Descargar Catálogo de productos</td>
                                            <td id="lbl-cat"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_price">
                                            </td>
                                            <td>Descargar Precios</td>
                                            <td id="lbl-pri"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_stock">
                                            </td>
                                            <td>Descargar Stock</td>
                                            <td id="lbl-sto"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="check_stock" disabled>
                                            </td>
                                            <td>Descargar Especificaciones</td>
                                            <td id="lbl-espec"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-sm btn-block btn-success">Procesar Descargas</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-process" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Procesar seleccionados</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed table-result">
                                <thead>
                                    <tr>
                                        <th>Lista de productos seleccionados</th>
                                    </tr>
                                </thead>
                                <tbody id="result-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" onclick="selectProduct();">Procesar Integración</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-history-upload" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Historial de Integración</h4>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-red">Productos encontrados en el Catálogo OKC</h6>
                        <ul id="result-exist"></ul>
                    </div>
                    <div class="col-md-12">
                        <h6 class="text-light-blue">Productos encontrados en la Lista de Pendientes</h6>
                        <ul id="result-pendient"></ul>
                    </div>
                    <div class="col-md-12">
                        <h6 class="text-green">Productos agregados a la Lista de Pendientes</h6>
                        <ul id="result-new"></ul>
                    </div>
                </div>
            </div>
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
        var array_id = [];
        var array_np = [];

        $(document).ready(function() {
            $('.sidebar-mini').addClass('sidebar-collapse');
            seleccionarMenu(window.location);

            // SEARCHEABLE DE PRECIO MONEDA STOCK PONER EN FALSE
            $("#tableProductos").DataTable({
                pageLength: 20,
                dom: "Bfrtip",
                processing: true,
                serverSide: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                order: [[5, "desc"]],
                ajax: {
                    url: route('intcomex.data-lista'),
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"},
                    
                    
                },
                columns: [
                    {data: "Check"},
                    {data: "Type"},
                    {data: "Category_Description"},
                    {data: "Subcategory_Description"},
                    {data: "Brand_Description"},
                    {data: "Sku"},
                    {data: "Mpn"},
                    {data: "Description"},
                    {data: "currency", searchable: false},
                    {data: "price", searchable: false},
                    {data: "stock", searchable: false}
                ],
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Descarga de catálogos',
                        action: function() {
                            listCatalog();
                            $("#modal-actions").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-primary',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                    {
                        text: '<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Procesar seleccionados',
                        action: function() {
                            var rowList = '';
                            if (array_np.length > 0) {
                                array_np.forEach(function(element, index) {
                                    rowList += `<tr><td>`+ element +`</td></tr>`;
                                });
                            } else {
                                rowList += `<tr><td>No se ha seleccionado productos</td></tr>`;
                            }
                            $("#result-list").html(rowList);
                            $("#modal-process").modal("show");
                            //selectProduct();
                        },
                        className: 'btn btn-sm btn-flat btn-success',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                    {
                        text: '<span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtros de busqueda',
                        action: function () {
                            $("#modal-filter").modal("show");
                        },
                        className: 'btn btn-sm btn-flat',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    }
                ],
                columnDefs: [{'aTargets': [4, 8, 9, 10], 'sClass': 'text-center'}]
            });

            $("#tableProductos tbody").on("click", "input", function(e) {
                var id = $(this).data("id");
                var val = $(this).data("value");
                var tr = "#tr" + id;
                var elemento = $(this).closest("tr");

                if ($(this).closest("tr").hasClass('eventClick')){
                    $(this).closest("tr").removeClass('eventClick');
                } else {
                    $(this).closest("tr").addClass('eventClick');
                }

                
                if ($(this).prop("checked")) {
                    changeStatus(id, val, 1);
                } else {
                    changeStatus(id, val, 2);
                }
                
            });

            $("#form-process-data").on("submit", function() {
                var data = $(this).serializeArray();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : route('ajax.data-intcomex-list'),
                    data: data,
                    dataType: "JSON",
                    beforeSend: function(){
                        $(document.body).append('<span class="loading"><div></div></span>');
                    },
                    success: function (response) {
                        $('.loading').remove();
                        if (response.response == 'ok') {
                            listCatalog();
                            $("#tableProductos").DataTable().ajax.reload(null, false);
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

        function listCatalog() {
            $("input[type=checkbox]").prop('checked', false);
            $.ajax({
                type: 'POST',
                url: "{{ route('intcomex.load-date-download') }}",
                data: {_token: "{{ csrf_token() }}"},
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response) {
                    $('.loading').remove();

                    $("#lbl-cat").html(response.catalogo);
                    $("#lbl-pri").html(response.precio);
                    $("#lbl-sto").html(response.stock);
                }
            });
        }

        function changeStatus(id, value, type) {
            if (type == 1) {
                if (!array_id.includes(id)) {
                    array_id.push(id);
                }
                if (!array_np.includes(value)) {
                    array_np.push(value);
                }
            }
        }

        function selectProduct() {
            var row1 = '', row2 = '', row3 = '';
            $("#modal-process").modal("hide");
            $("#result-exist").empty();
            $("#result-pendient").empty();
            $("#result-new").empty();
            $.ajax({
                type: 'POST',
                url: route('intcomex.consult-part_number'),
                data: {
                    _token: csrf_token, 
                    id: array_id,
                    value: array_np
                },
                dataType: 'JSON',
                beforeSend: function(){
                    $(document.body).append('<span class="loading"><div></div></span>');
                },
                success: function(response) {
                    $('.loading').remove();
                    var exist = response.exist;
                    var pendi = response.pendients;
                    var new_p = response.news;

                    if (exist.length > 0) {
                        exist.forEach(function(element, index) {
                            row1 += `<li>`+ element +`</li>`;
                        });
                    }
                    if (pendi.length > 0) {
                        pendi.forEach(function(element, index) {
                            row2 += `<li>`+ element +`</li>`;
                        });
                    }
                    if (new_p.length > 0) {
                        new_p.forEach(function(element, index) {
                            row3 += `<li>`+ element +`</li>`;
                        });
                    }

                    $("#result-exist").html(row1);
                    $("#result-pendient").html(row2);
                    $("#result-new").html(row3);

                    $("#tableProductos").DataTable().ajax.reload(null, false);
                    array_id = [];
                    array_np = [];
                    $("#modal-history-upload").modal('show');
                }
            });
        }
    </script>
@endsection
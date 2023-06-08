@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <style>
        .eventClick {
            background-color: aqua;
        }
    </style>
@endsection

@section('title') Productos Pendientes de registro @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Productos pendientes de agregar al Catálogo</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i> Inicio</a></li>
    <li>Intcomex</li>
    <li class="active">Productos Pendientes de registro</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box box-solid">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered" id="tableProductos" style="font-size: x-small">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 5%">Tipo</th>
                                <th style="width: 10%">Categoría</th>
                                <th style="width: 10%">Sub Categoría</th>
                                <th style="width: 10%">Fabricante</th>
                                <th style="width: 10%">SKU</th>
                                <th style="width: 10%">Nro. parte</th>
                                <th>Descripción</th>
                                {{--  <th style="width: 7%">Moneda</th>
                                <th style="width: 7%">Precio</th>
                                <th style="width: 7%">Stock</th>  --}}
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-save-list" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formulario">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Guardar de productos seleccionados de INTCOMEX</h4>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Categoría</th>
                                            <td>
                                                <select name="cat_int" class="form-control form-control-sm"></select>
                                            </td>
                                            <td>
                                                <select name="cat_okc" class="form-control form-control-sm" onchange="loadSubcat(this.value);">
                                                    <option value="" selected disabled>Elija una opcion..</option>
                                                    @foreach ($categ as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sub categoría</th>
                                            <td>
                                                <select name="sub_int" class="form-control form-control-sm"></select>
                                            </td>
                                            <td>
                                                <select name="sub_okc" class="form-control form-control-sm"></select>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="result-stock-list"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-sm btn-danger" onclick="saveCombination();">Agregar combinación de categorías</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Categoría INT</th>
                                            <th>Categoría OKC</th>
                                            <th>Sub Categoría INT</th>
                                            <th>Sub Categoría OKC</th>
                                        </tr>
                                    </thead>
                                    <tbody id="result-combination">
                                        {{--  <tr>
                                            <td colspan="4">No se registraron combinaciones</td>
                                        </tr>  --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Grabar registro</button>
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
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        var array_id = [];
        var array_cat = [];
        var array_sub = [];

        $(document).ready(function() {
            $('.sidebar-mini').addClass('sidebar-collapse');
            seleccionarMenu(window.location);

            $("#tableProductos").DataTable({
                pageLength: 20,
                dom: "Bfrtip",
                processing: true,
                serverSide: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                ajax: {
                    url: "{{ route('intcomex.data-lista-pending') }}",
                    type: "POST",
                    data: {_token: "{{ csrf_token() }}"},
                    complete: function() {
                        $("#tableProductos tbody").on("click", "input", function(e) {
                            var id = $(this).data("id");
                            var cat = $(this).data("cat");
                            var sub = $(this).data("sub");

                            if ($(this).prop("checked")) {
                                changeStatus(id, cat, sub, 1);
                            } else {
                                changeStatus(id, cat, sub, 2);
                            }
                        });
                    }
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
                    //{data: "CurrencyId"},
                    //{data: "UnitPrice"},
                    //{data: "InStock"}
                ],
                buttons: [
                    {
                        text: 'Guardar productos seleccionados',
                        action: function () {
                            openModalSave();
                        },
                        className: 'btn btn-sm btn-flat btn-success',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                ],
                //columnDefs: [{'aTargets': [7, 8, 9], 'sClass': 'text-center'}]
            });
        });

        function changeStatus(id, cat, sub, type) {
            if (type == 1) {
                if (!array_id.includes(id)) {
                    array_id.push(id);
                }

                if (!array_cat.includes(cat)) {
                    array_cat.push(cat);
                }

                if (!array_sub.includes(sub)) {
                    array_sub.push(sub);
                }
            }
        }

        function loadSubcat(id, select=0) {
            $("[name=sub_okc]").empty();
            var row = '<option value="">Elija una opción..</option>';
            var selected;
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-element') }}",
                data: {_token: csrf_token, id: id, type: 'subcategoria'},
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
                        
                        $("[name=sub_okc]").html(row);
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function openModalSave() {
            $("#modal-save-list").modal("show");
            var opt1 = '', opt2 = '';

            if (array_id.length > 0) {
                array_cat.forEach(function (element_1, index_1) {
                    console.log(element_1);
                    opt1 += `<option value="`+ index_1 +`">`+ element_1 +`</option>`;
                });

                array_sub.forEach(function (element_2, index_2) {
                    console.log(element_2);
                    opt2 += `<option value="`+ index_2 +`">`+ element_2 +`</option>`;
                });

                $("[name=cat_int]").html(opt1);
                $("[name=sub_int]").html(opt2);
                $("#modal-save-list").modal("show");
            }
        }

        function saveCombination() {
            var row = '';
            var cat_int = $("[name=cat_int]").val();
            var cat_okc = $("[name=cat_okc]").val();
            var sub_int = $("[name=sub_int]").val();
            var sub_okc = $("[name=sub_okc]").val();

            var txt_cat_int = $("[name=cat_int] option:selected").text();
            var txt_cat_okc = $("[name=cat_okc] option:selected").text();
            var txt_sub_int = $("[name=sub_int] option:selected").text();
            var txt_sub_okc = $("[name=sub_okc] option:selected").text();

            row += `
            <tr>
                <td>
                    `+ txt_cat_int +`
                    <input type="hidden" name="categ[]" value="`+ cat_int +`" />
                </td>
                <td>
                    `+ txt_cat_okc +`
                    <input type="hidden" name="categ[]" value="`+ cat_okc +`" />
                </td>
                <td>
                    `+ txt_sub_int +`
                    <input type="hidden" name="categ[]" value="`+ sub_int +`" />
                </td>
                <td>
                    `+ txt_sub_okc +`
                    <input type="hidden" name="categ[]" value="`+ sub_okc +`" />
                </td>
            </tr>`;

            $("#result-combination").append(row);
        }
    </script>
@endsection
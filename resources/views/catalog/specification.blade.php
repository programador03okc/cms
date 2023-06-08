@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
@endsection

@section('title')Especificaciones @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Especificaciones</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Catálogo</li>
    <li class="active">Especificaciones</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de resultados</h6>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableSpec">
                        <thead>
                            <tr>
                                <th>Características</th>
                                <th>Valores</th>
                                <th width="50">&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-data" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form id="formulario" method="POST">
                <input type="hidden" name="_method" value="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Datos del Formulario</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Categoría</h6>
                                <select class="form-control input-sm" name="category_id" required onchange="loadFeature(this.value);">
                                    <option value="" disabled selected>Elija una opción..</option>
                                    @foreach ($categ as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Característica</h6>
                                <select class="form-control input-sm" name="feature_id" required>
                                    <option value="" disabled selected>Elija una opción..</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Valores</h6>
                                <select class="form-control input-sm" name="value_id" required>
                                    <option value="" disabled selected>Elija una opción..</option>
                                    @foreach ($value as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="btnAction"></button>
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
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        @if (Session::has('key'))
            var tpm = '<?=Session::get("key")?>';
            var msg = '<?=Session::get("message")?>';
            notify(tpm, msg);
        @endif

        $(document).ready(function () {
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            $("#tableSpec").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                ajax: {
                    url: "{{ route('lists.list-feature-value') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "feature"},
                    {data: "value"},
                    {data: "action"}
                ],
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo registro',
                        action: function () {
                            var store = "{{ route('catalogs.feature-value.store') }}";
                            $("#formulario")[0].reset();
                            $("#formulario").attr("action", store);
                            $("[name=_method]").val("POST");
                            $("#modal-data .modal-title").text("Agregar nueva especificación");
                            $("#btnAction").text("Grabar nueva especificación");
                            $("#modal-data").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-primary',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                ],
            });

            $("#tableSpec tbody").on("click", "a.edit_dt", function () {
                showData($(this).data("route"), $(this).data("update"));
            });

            $("#tableSpec tbody").on("click", "a.delete_dt", function () {
                deleteData($(this).data("route"));
            });
        }); 

        function showData(route, update) {
            $.ajax({
                type: "GET",
                url : route,
                data: {_token: csrf_token},
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    $("[name=category_id]").val(response.feature.category_id);
                    loadFeature(response.feature.category_id, response.feature_id);
                    $("[name=value_id]").val(response.value_id);
                    $("#modal-data").modal("show");
                    $("#formulario").attr("action", update);
                    $("#modal-data .modal-title").text("Editar especificación");
                    $("#btnAction").text("Grabar edición");
                    $("[name=_method]").val("PUT");
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function deleteData(route){
            if (!confirm("¿Desea eliminar el registro?")) {
                return false;
            }
            $.ajax({
                type: "POST",
                url : route,
                data: {
                    _token: csrf_token,
                    _method: "DELETE"
                },
                dataType: "JSON",
                success: function (response) {
                    notify(response.alert, response.message);
                    $("#tableSpec").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function loadFeature(id, select=0) {
            $("[name=feature_id]").empty();
            var row = '<option value="">Elija una opción..</option>';
            var selected;
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-element') }}",
                data: {_token: csrf_token, id: id, type: 'feature'},
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
                        $("[name=feature_id]").html(row);
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    </script>
@endsection
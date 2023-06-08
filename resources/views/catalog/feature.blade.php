@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
@endsection

@section('title')Características @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Características</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Catálogo</li>
    <li class="active">Características</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de resultados</h6>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableFeature">
                        <thead>
                            <tr>
                                <th width="100">Categoría</th>
                                <th>Nombre</th>
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
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Categoría</h6>
                                <select class="form-control input-sm" name="category_id" required>
                                    <option value="" selected disabled>Elija una opcion..</option>
                                    @foreach ($categ as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Nombre</h6>
                                <input type="text" class="form-control input-sm" name="name" placeholder="Ingrese el nombre" required>
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
            $("#tableFeature").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                order: [[0, 'asc']],
                ajax: {
                    url: "{{ route('lists.list-feature') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "category"},
                    {data: "name"},
                    {data: "action"}
                ],
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo registro',
                        action: function () {
                            var store = "{{ route('catalogs.feature.store') }}";
                            $("#formulario")[0].reset();
                            $("#formulario").attr("action", store);
                            $("#modal-data .modal-title").text("Agregar nueva característica");
                            $("#btnAction").text("Grabar nueva característica");
                            $("[name=_method]").val("POST");
                            $("#modal-data").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-primary',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                ],
            });

            $("#tableFeature tbody").on("click", "a.edit_dt", function () {
                showData($(this).data("route"), $(this).data("update"));
            });

            $("#tableFeature tbody").on("click", "a.delete_dt", function () {
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
                    $("[name=category_id]").val(response.category_id);
                    $("[name=name]").val(response.name);
                    $("#modal-data .modal-title").text("Editar característica");
                    $("#btnAction").text("Grabar edición");
                    $("#modal-data").modal("show");
                    $("#formulario").attr("action", update);
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
                    $("#tableFeature").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    </script>
@endsection
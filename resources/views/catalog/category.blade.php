@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
@endsection

@section('title')Categorías @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Categorías</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Catálogo</li>
    <li class="active">Categorías</li>
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
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableCategory">
                        <thead>
                            <tr>
                                <th width="60">Imagen</th>
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
                    <h4 class="modal-title">Datos del Formulario</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Nombre</h6>
                                <input type="text" class="form-control input-sm" name="name" placeholder="Ingrese el nombre" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="kv-avatar">
                                <div class="form-group">
                                    <h6>Logo (imagen)</h6>
                                    <input type="file" class="form-control input-sm" name="image">
                                </div>
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
    <script src="{{ asset('assets/lte/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/lte/plugins/bootstrap-fileinput/js/locales/es.js') }}"></script>
    <script src="{{ asset('assets/lte/plugins/bootstrap-fileinput/themes/fas/theme.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        @if (Session::has('key'))
            var tpm = '<?=Session::get("key")?>';
            var msg = '<?=Session::get("message")?>';
            notify(tpm, msg);
        @endif

        var path_local = "{{ asset('web/categorias') }}";

        $(document).ready(function () {
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $(":file").fileinput({
                language: 'es',
                overwriteInitial: true,
                maxFileSize: 2500,
                showClose: false,
                showCaption: false,
                browseLabel: '',
                removeLabel: '',
                browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
                removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                fileActionSettings: {
                    showZoom: false
                },
                initialPreviewAsData: true,
                layoutTemplates: {main2: '{preview} ' + ' {remove} {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"],
                theme: 'fa'
            });

            $("#tableCategory").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                order: [[1, 'asc']],
                ajax: {
                    url: "{{ route('lists.list-category') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {
                        render: function(data, type, row){
                            if (row['image'] != null) {
                                return `<a href="#"><img src="`+ path_local + `/`+ row['image'] +`" style="height:70px;"></a>`;
                            } else {
                                return '-';
                            }
                        }
                    },
                    {data: "name"},
                    {data: "action"}
                ],
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo registro',
                        action: function () {
                            var store = "{{ route('catalogs.category.store') }}";
                            $("#formulario")[0].reset();
                            $("#formulario").attr("action", store);
                            $("[name=_method]").val("POST");
                            $("#modal-data .modal-title").text("Agregar nueva categoría");
                            $("#btnAction").text("Grabar nueva categoría");
                            $("#modal-data").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-primary',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    },
                ],
            });

            $("#tableCategory tbody").on("click", "a.edit_dt", function () {
                showData($(this).data("route"), $(this).data("update"));
            });

            $("#tableCategory tbody").on("click", "a.delete_dt", function () {
                deleteData($(this).data("route"));
            });
        }); 

        function showData(route, update) {
            $.ajax({
                type: "GET",
                url : route,
                data: {_token: "{{ csrf_token() }}"},
                dataType: "JSON",
                success: function (response) {
                    $("[name=name]").val(response.name);
                    $("#modal-data .modal-title").text("Editar categoría ["+ response.name +"]");
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
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                dataType: "JSON",
                success: function (response) {
                    notify(response.alert, response.message);
                    $("#tableCategory").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    </script>
@endsection
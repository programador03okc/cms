@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
@endsection

@section('title')Usuarios @endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
        <li class="active">Usuarios</li>
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
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableUsuario">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo electrónico</th>
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
                                <h6>Nombre Corto</h6>
                                <input type="text" class="form-control input-sm" name="name" placeholder="Ingrese el nombre del usuario" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Correo</h6>
                                <input type="email" class="form-control input-sm" name="email" placeholder="Ingrese el correo" required>
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

        $(document).ready(function () {
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});

            $("#tableUsuario").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                ajax: {
                    url: "{{ route('lists.list-user') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "name"},
                    {data: "email"},
                    {data: "action"}
                ],
                buttons: [
                    {
                        text: '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo registro',
                        action: function () {
                            var store = "{{ route('configurations.user.store') }}";
                            $("#formulario")[0].reset();
                            $("#formulario").attr("action", store);
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

            /*$("#tableUsuario tbody").on("click", "a.delete_dt", function () {
                deleteData($(this).data("route"));
            });*/
        });

        function resetPassUser(id){
            if (!confirm("¿Desea resetear la contraseña?")) {
                return false;
            }
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.new-password') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                dataType: "JSON",
                success: function (response) {
                    notify(response.alert, response.message);
                    $("#tableUsuario").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        /*function deleteData(route){
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
                    $("#tableUsuario").DataTable().ajax.reload();
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }*/
    </script>
@endsection
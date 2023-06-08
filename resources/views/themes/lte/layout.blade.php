<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>.:: CMS OKC ::.</title>
        <link rel="icon" type="image/ico" href="{{asset('images/logo.ico')}}">
        <link rel="stylesheet" href="{{ asset('assets/lte/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/plugins/jQueryUI/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/fontello/fontello.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/lobibox/dist/css/lobibox.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/basic.css') }}">
        @yield("links")
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            @include("themes/lte/header")
            @include("themes/lte/aside")
            <div class="content-wrapper">
                <section class="content-header">
                    @yield("breadcrumb")
                </section>
                <section class="content">
                    @yield("content")
                </section>
                <div class="modal fade" id="modal-password" role="dialog">
                    <div class="modal-dialog modal-xxs" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Cambiar Clave</h4>
                            </div>
                            <div class="modal-body">
                                <form id="form-password" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h6>Nueva contraseña</h6>
                                                <input type="password" class="form-control input-sm" name="password" placeholder="Escriba su nueva clave" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button type="submit" class="btn btn-sm btn-success btn-block">Grabar nueva clave</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/lte/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <script src="{{ asset('assets/lte/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('assets/lte/bower_components/lobibox/dist/js/lobibox.min.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/event.js') }}"></script>
        @routes
        <script>
            var csrf_token = '{{ csrf_token() }}';
            var idioma = {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate":
                {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria":
                {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            };

            seleccionarMenu(window.location);

            function resetPass() {
                $("#form-password")[0].reset();
                $("#form-password").attr("action", "{{ route('ajax.change-password') }}");
                $("[name=_method]").val("POST");
                $("#modal-password").modal("show");
            }
        </script>
        @yield("scripts")
    </body>
</html>
@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/select2/css/select2.min.css') }}">
@endsection

@section('title')Artes @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Artes</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Diseño</li>
    <li class="active">Artes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Filtros</h6>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h6>Tipo de Imagen</h6>
                            <select class="form-control input-sm" name="art_type_id" onchange="loadTypeArt(this.value);" required>
                                <option value="" selected disabled>Elija una opcion..</option>
                                @foreach ($art_type as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 option-disabled" id="option-1">
                        <div class="form-group">
                            <h6>Tipo de Banner</h6>
                            <select class="form-control input-sm" name="section_id" onchange="loadArtSection(this.value);" required>
                                <option value="" selected disabled>Elija una opcion..</option>
                                @foreach ($section as $sect)
                                    <option value="{{ $sect->id }}">{{ $sect->name }} ( {{ $sect->description}} )</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 option-disabled" id="option-2">
                        <div class="form-group">
                            <h6>Lista de productos</h6>
                            <select class="form-control input-sm select2" name="product_id" onchange="loadArtProduct(this.value);" required>
                                <option value="" selected disabled>Elija una opcion..</option>
                                @foreach ($product as $prod)
                                    <option value="{{ $prod->id }}">{{ $prod->part_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer clearfix no-border">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-info btn-sm btn-block" onclick="window.location.reload();"><i class="fa fa-refresh"></i> Nuevo</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary btn-sm btn-block" onclick="processArts();"><i class="fa fa-plus"></i> Agregar Artes</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-9">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de resultados</h6>
            </div>
            <div class="box-body">
                <div class="row" id="result-content">
                    <div class="col-md-12">No se encontraron resultados.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-images" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="formulario" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="img_product_id" value="0">
                <input type="hidden" name="img_section_id" value="0">
                <input type="hidden" name="img_art_type_id" value="0">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Agregar nuevos diseños</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kv-avatar">
                                <div class="form-group">
                                    <h6>Imágenes</h6>
                                    <input type="file" class="form-control input-sm" name="images[]" multiple accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Grabar nuevo diseño</button>
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
    <script src="{{ asset('assets/lte/bower_components/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        var urlImages = "{{ asset('web/artes') }}";
        var urlBanner = "{{ asset('web/banners') }}";
        @if (Session::has('key'))
            var tpm = '<?=Session::get("key")?>';
            var msg = '<?=Session::get("message")?>';
            notify(tpm, msg);
        @endif

        $(document).ready(function () {
            $('.sidebar-mini').addClass('sidebar-collapse');
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            $(".select2").select2();

            $(".option-disabled").addClass("dnone");

            $(":file").fileinput({
                language: 'es',
                overwriteInitial: true,
                maxFileSize: 15600,
                maxFilesNum: 1,
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
                layoutTemplates: {main2: '{preview} ' + ' {browse}'},
                allowedFileExtensions: ["jpg", "png", "gif"],
                theme: 'fa',
                slugCallback: function (filename) {
                    return filename.replace('(', '_').replace(']', '_');
                }
            });

            $("#formulario").on("submit", function() {
                var formData = new FormData($('#formulario')[0]);
                $.ajax({
                    type: "POST",
                    url : $(this).attr("action"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "JSON",
                    success: function (response) {
                        notify(response.alert, response.message);
                        if (response.response == 'ok') {
                            show(response.type_input, response.product_input, response.section_input);
                            $('#formulario')[0].reset();
                            $("#modal-images").modal("hide");
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                return false;
            });

            $('a[download]').each(function() {
                var $a = $(this),
                    fileUrl = $a.attr('href');
              
                $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
              });
        });

        function loadTypeArt(value)
        {
            $(".option-disabled").addClass("dnone");
            $("#result-content").html(`<div class="col-md-12">No se encontraron resultados.</div>`);
            if (value == 3) {
                var sect = $("[name=section_id]").val();
                if (sect > 0) {
                    show(value, 0, sect);
                }
                $("#option-1").removeClass("dnone");
            } else {
                var prod = $("[name=product_id]").val();
                if (prod > 0) {
                    show(value, prod, 0);
                }
                $("#option-2").removeClass("dnone");
            }
        }

        function processArts(id) {
            var prod = 0;
            var sect = 0;
            var tart = $("[name=art_type_id]").val();
            

            if (tart == 3) {
                sect = $("[name=section_id]").val();
                var upload = '{{ route("ajax.load-images-banner") }}';
            } else {
                prod = $("[name=product_id]").val();
                var upload = '{{ route("ajax.load-images-product") }}';
            }

            $("#modal-images").modal("show");
            $('#modal-images').on('shown.bs.modal', function(){
                $('[name=img_product_id]').val(prod);
                $('[name=img_section_id]').val(sect);
                $('[name=img_art_type_id]').val(tart);
            });
            $("#formulario").attr("action", upload);
        }

        function loadArtProduct(value) {
            var tart = $("[name=art_type_id]").val();
            show(tart, value, 0);
        }
        
        function loadArtSection(value)
        {
            var tart = $("[name=art_type_id]").val();
            show(tart, 0, value);
        }

        function show(type, product, sect)
        {
            var row = '';
            var url_base = '';
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-arts') }}",
                data: {
                    _token: csrf_token,
                    type: type,
                    product: product,
                    section: sect
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.response > 0) {
                        var datax = response.data;
                        var cont = 1;
                        var nameImage = '', colum = '', style = '', typei = '';

                        if (type == 3) {
                            url_base = urlBanner;
                        } else {
                            url_base = urlImages;
                        }

                        datax.forEach(function (element, index) {
                            if (type == 3) {
                                nameImage = element.name;
                                colum = 'col-md-6';
                                style = 'h-banner';
                                typei = 'banner';
                            } else {
                                nameImage = element.product.sku;
                                colum = 'col-md-4';
                                typei = 'gallery';
                            }
                            row += `
                            <div class="`+ colum +`">
                                <div class="box box-widget" style="border: 1px solid #f4f4f4; box-shadow: 0 1px 2px rgba(0,0,0,0.1)">
                                    <div class="box-header with-border">
                                        <div style="float: left">`+ nameImage +`</div>
                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" onclick="deleteImage(`+ element.id +`, '`+ typei +`', `+ type +`, `+ product +`, `+ sect +`);"
                                                data-toggle="tooltip" data-placement="bottom" data-title="Eliminar">
                                                <i class="fa fa-trash" style="color: red;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <a href="`+ url_base + `/` +  element.name +`" download="`+ nameImage +`.png">
                                        <img class="img-responsive pad `+ style +`" src="`+ url_base + `/` +  element.name +`" alt="Photo">
                                        </a>
                                    </div>
                                </div>
                            </div>`;
                            cont++;
                        });
                        $("#result-content").html(row);
                    } else {
                        $("#result-content").html('<div class="col-md-12">No se encontraron imágenes</div>');
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function deleteImage(id, type, fil_type, fil_prod, fil_sect)
        {
            if (!confirm("¿Desea eliminar el registro?")) {
                return false;
            }
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.delete-arts') }}",
                data: {
                    _token: csrf_token,
                    id : id,
                    type: type
                },
                dataType: "JSON",
                success: function (response) {
                    notify(response.alert, response.message);
                    if (response.response == 'ok') {
                        show(fil_type, fil_prod, fil_sect);
                    }
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
            return false;
        }
    </script>
@endsection
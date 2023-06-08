@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
@endsection

@section('title') Productos @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Productos Temporales - Web OKC </h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Canales Web</li>
    <li class="active">Productos Temporales</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de productos Temporales</h6>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableProduct">
                        <thead>
                            <tr>
                                <th width="40">Código</th>
                                <th width="90">Part Number</th>
                                <th width="150">Categoría</th>
                                <th width="150">SubCategoría</th>
                                <th>Nombre del producto</th>
                                <th width="40">Stock</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-stock" role="dialog">
    <div class="modal-dialog modal-xxxs" role="document">
        <div class="modal-content">
            <form id="formulario" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="product_id" value="">
                <input type="hidden" name="business_type_id" value="1">
                <input type="hidden" name="store_shop_id" value="1">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Reservar Stock</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Stock General</h6>
                                <input type="number" class="form-control input-sm text-center" name="stock_original" value="0.00" step="any" min="0" readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Reservar Stock</h6>
                                <input type="number" class="form-control input-sm text-center" name="stock_reserv" value="0.00" step="any" min="0" onkeyup="calculateStock(this.value);" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="btn-stock" disabled="true">Grabar registro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-excel" role="dialog">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <form action="{{ route('import-temporal') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Carga Masiva de Productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Mes</h6>
                                <select name="month" id="month" class="form-control">
                                    <option value="" selected disabled>Elija una opción..</option>
                                    <option value="ENERO">ENERO</option>
                                    <option value="FEBRERO">FEBRERO</option>
                                    <option value="MARZO">MARZO</option>
                                    <option value="ABRIL">ABRIL</option>
                                    <option value="MAYO">MAYO</option>
                                    <option value="JUNIO">JUNIO</option>
                                    <option value="JULIO">JULIO</option>
                                    <option value="AGOSTO">AGOSTO</option>
                                    <option value="SETIEMBRE">SETIEMBRE</option>
                                    <option value="OCTUBRE">OCTUBRE</option>
                                    <option value="NOVIEMBRE">NOVIEMBRE</option>
                                    <option value="DICIEMBRE">DICIEMBRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Tipo</h6>
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected disabled>Elija una opción..</option>
                                    <option value="NUEVO">NUEVO</option>
                                    <option value="ACTUALIZACION">ACTUALIZACION</option>
                                </select>
                            </div>
                        </div>
                    </div>
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
        let name_array = "";

        $(document).ready(function () {
            $('.sidebar-mini').addClass('sidebar-collapse');
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
            
            $("#tableProduct").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                ajax: {
                    url: "{{ route('lists.list-temporal') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "code"},
                    {data: "part_number"},
                    {data: "category"},
                    {data: "subcategory"},
                    {data: "name"},
                    {data: "stock"}
                ],
                buttons: [
                    {
                        text: '<span class="fa fa-file-excel-o" aria-hidden="true"></span> Cargar Excel',
                        action: function () {
                            $("#modal-excel").modal("show");
                        },
                        className: 'btn btn-sm btn-flat btn-success',
                        init: function (api, node, config) {
                            $(node).removeClass('btn-default')
                        }
                    }
                ],
            });
        });
    </script>
@endsection
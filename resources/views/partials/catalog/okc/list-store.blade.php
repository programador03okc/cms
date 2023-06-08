@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
@endsection

@section('title') Productos @endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
        <li class="active">Lista de Productos {{ $type_store }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de productos {{ $type_store }}</h6>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm">
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableProduct">
                        <thead>
                            <tr>
                                <th></th>
                                <th width="90">SKU</th>
                                <th>Part Number</th>
                                <th>Nombre Comercial</th>
                                <th>Categoría</th>
                                <th>Sub Cat.</th>
                                <th>Marca</th>
                                <th>Unidad</th>
                                <th width="40">Stock</th>
                                <th width="40">Costo</th>
                                <th width="40">Magen</th>
                                <th width="40">Precio</th>
                            </tr>
                        </thead>
                    </table>
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
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>

    <script>
        $(document).ready(function () {
            $('.sidebar-mini').addClass('sidebar-collapse');

            $("#tableProduct").DataTable({
                dom: 'frtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                ajax: {
                    url: "{{ route('channels.list-product-okc') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                columns: [
                    {data: "subtitle"},
                    {data: "sku"},
                    {data: "part_number"},
                    {data: "title"},
                    {data: "category"},
                    {data: "subcategory"},
                    {data: "mark"},
                    {data: "unit"},
                    {data: "stock"},
                    {
                        render: function (data, type, row){
                            return parseFloat(row['cost_product']).toFixed(2);
                        }
                    },
                    {data: "margin_product"},
                    {
                        render: function (data, type, row){
                            var cost = row['cost_product'];
                            var marg = row['margin_product'];
                            var total = (cost * 1.18 / (1 - (marg / 100)));
                            var redon = Math.ceil(total / 10) * 10;
                            var final = parseFloat(redon).toFixed(2);
                            return final;
                        }
                    },
                ],
                columnDefs: [
                    {
                        "targets": [0],
                        "visible": false,
                        "searchable": true
                    }
                ]
            });
        });
    </script>
@endsection
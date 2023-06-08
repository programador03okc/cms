@extends('themes/lte/layout')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lte/bower_components/select2/css/select2.min.css') }}">
@endsection

@section('title') Productos @endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Productos para la Tienda OKC </h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li>Canales Web</li>
    <li class="active">Productos {{ $type_store }}</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Lista de productos Tienda {{ $type_store }}</h6>
            </div>
            <div class="box-body">
                <input type="hidden" name="type_change" value="{{ $tica }}">
                <div class="table-responsive">
                    <table class="table table-condensed table-bordered table-hover table-striped" id="tableProduct">
                        <thead>
                            <tr>
                                <th width="24">&nbsp;</th>
                                <th width="20">&nbsp;</th>
                                <th width="90">SKU</th>
                                <th>Part Number</th>
                                <th>Nombre Comercial</th>
                                <th>Marca</th>
                                <th>Unidad</th>
                                <th width="40">Stock Gral.</th>
                                <th width="40">Stock Reserv.</th>
                                <th width="70">Costo</th>
                                <th width="70">Magen</th>
                                <th width="70">Precio</th>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Stock Web</h6>
                                <select name="stock_web" class="form-control input-sm" required>
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>A pedido</h6>
                                <select name="pedido_web" class="form-control input-sm" required>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
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

<div class="modal fade" id="modal-combos" role="dialog">
    <div class="modal-dialog modal-xxs" role="document">
        <div class="modal-content">
            <form id="form-combo" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="product_master_id" value="POST">
                @csrf
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Crear combo de productos</h4>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h6>Productos</h6>
                                <select name="product_combo_id" class="form-control input-sm select-product" required>
                                    @foreach ($product as $itemProd)
                                        <option value="{{ $itemProd->id }}">{{ $itemProd->part_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Precio real</h6>
                                <input type="number" class="form-control input-sm text-center" name="price_prod" value="0.00" step="any" min="0" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>Precio del combo</h6>
                                <input type="number" class="form-control input-sm text-center" name="price" value="0.00" step="any" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody id="result-combo"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Agregar combo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-combos-list" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de combos</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>Código Combo</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="result-combo-list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-stock-list" role="dialog">
    <div class="modal-dialog modal-xs" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Lista de Stock</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tienda</th>
                                        <th width="90">Stock</th>
                                        <th width="90">Stock Web</th>
                                        <th width="90">A Pedido</th>
                                    </tr>
                                </thead>
                                <tbody id="result-stock-list"></tbody>
                            </table>
                        </div>
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
    <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Buttons/js/buttons.html5.min.js') }}"></script>
    {{--  <script src="{{ asset('assets/lte/bower_components/datatables/extensions/Select/js/dataTables.select.min.js') }}"></script>  --}}
    <script src="{{ asset('assets/lte/bower_components/select2/js/select2.min.js') }}"></script>
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
            var value_tc = $("[name=type_change]").val();

            $(".select-product").select2()
            .on("change", function (e) {
                var option = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.load-price-product') }}",
                    data: {
                        _token: csrf_token,
                        value: option
                    },
                    dataType: "JSON",
                    success: function (response) {
                        var price = parseFloat(response);
                        $("[name=price_prod]").val(price.toFixed(2));
                    }
                });
                return false;
            });;
            
            console.time();
            $("#tableProduct").DataTable({
                dom: 'Bfrtip',
                pageLength: 20,
                processing: true,
                serverSide: true,
                language: idioma,
                order: [[3, "asc"]],
                ajax: {
                    url: "{{ route('lists.list-product-store') }}",
                    type: "GET",
                    data: {_token: csrf_token}
                },
                initComplete: function() {
                    console.timeEnd();
                },
                columns: [
                    {data: "action"},
                    {data: "combo"},
                    {data: "sku"},
                    {data: "part_number"},
                    {data: "title"},
                    {data: "mark"},
                    {data: "unit"},
                    {
                        render: function (data, type, row){
                            return `<a href="javascript:void(0);" style="display:block; text-align: right;" onclick="stockStore(`+ row['id'] +`, `+ row['stock_product'] +`);">`+ row['stock_product'] +`</a>`;
                        }
                    },
                    {
                        render: function (data, type, row){
                            return `<a href="javascript:void(0);" style="display:block; text-align: right;" onclick="stockTotal(`+ row['id'] +`, `+ row['stock_reserv'] +`);">`+ row['stock_reserv'] +`</a>`;
                        }
                    },
                    {
                        render: function (data, type, row){
                            return `<input type="number" style="width: 100px; text-align: center; text-align: right;" value="`+ parseFloat(row['cost_product']).toFixed(2) +`" step="any" readonly />`;
                        }
                    },
                    {
                        render: function (data, type, row){
                            return `<input type="number" onkeyup="calculatePrice(this, this.value, event, `+ row['id'] +`);" value="`+ parseFloat(row['margin_product']).toFixed(2) +`" step="any" style="width: 80px; text-align: center;" />`;
                        }
                    },
                    {
                        render: function (data, type, row){
                            var cost = row['cost_product'];
                            var marg = row['margin_product'];
                            var total = (cost * 1.18 / (1 - (marg / 100)));
                            var redon = Math.ceil(total / 10) * 10;
                            var final = parseFloat(redon).toFixed(2);
                            return `<input type="number" style="width: 100px; text-align: center; text-align: right;" value="`+ final +`" step="any" readonly />`;
                        }
                    }
                ],
                buttons: [
                    {
                        text: 'Tipo de Cambio: <span>'+ value_tc +'</span>',
                        action: function () {
                            alert('actualizado a la fecha');
                        },
                        className: 'btn btn-sm btn-flat',
                    }
                ],
            });

            $("#form-combo").on("submit", function() {
                var data = $(this).serializeArray();
                data.push({
                    _token:     "{{ csrf_token() }}",
                });

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.combo-store') }}",
                    data: data,
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == 'ok') {
                            notify(response.alert, response.message);
                            loadCombos(response.id, 1);
                            $('#tableProduct').DataTable().ajax.reload();
                            $("#form-combo")[0].reset();
                        } else {
                            notify(response.alert, response.message);
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

        function calculatePrice(element, value, event, product) {
            if (event.keyCode == 13) {
                var costo = 0;
                var tr = element.parentNode.parentNode;

                costo = tr.children[6].children[0].value;
                var total = (costo * 1.18 / (1 - (value / 100)));
                var redon = Math.ceil(total / 10) * 10;
                var final = parseFloat(redon).toFixed(2);
                console.log(final);
                tr.children[8].children[0].value = final;

                $.ajax({
                    type: "POST",
                    url : "{{ route('ajax.update-product-price') }}",
                    data: {
                        _token: csrf_token,
                        id: product,
                        price: final,
                        cost: costo,
                        margin: value,
                        business_type: 1,
                        store_shop: 1
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if (response.response == "ok") {
                            notify("success", response.message);
                        } else {
                            notify("error", response.message);
                        }
                    }
                }).fail( function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
            }
        }

        function calculateStock(value) {
            var stock = $("[name=stock_original]").val();
            var rsrva = parseFloat(stock) - value;
            if (rsrva >= 0) {
                notify("success", "Stock válido para reservar");
                $("#btn-stock").removeAttr('disabled');
            } else {
                notify("error", "Stock no válido para reservar");
                $("#btn-stock").attr('disabled', true);
            }
        }

        function stockStore(id, original) {
            $("#formulario")[0].reset();
            $("[name=product_id]").val(id);
            $("[name=stock_original]").val(original.toFixed(2));
            var store = "{{ route('channels.stock-store') }}";
            $("#formulario").attr("action", store);
            $("#modal-stock").modal("show");
        }

        function stockTotal(id) {
            var row = '';
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-product-stock') }}",
                data: {
                    _token: csrf_token,
                    id: id
                },
                dataType: "JSON",
                success: function (response) {
                    var datax = response.data;

                    if (datax.length > 0) {
                        datax.forEach(function (element, index) {
                            row += `<tr>
                                <td>`+ element.store_shop.name +`</td>
                                <td class="text-right">`+ element.stock +`</td>
                                <td class="text-right">`+ element.stock_web +`</td>
                                <td class="text-center">`+ element.stock_order +`</td>
                            </tr>`;
                        });
                    } else {
                        row += `<tr><td colspan="2">No se agregaron productos</td></tr>`;
                    }
                    $("#result-stock-list").html(row);
                    $("#modal-stock-list").modal("show");
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
            return false;
        }

        function publish(id) {
            if (!confirm("¿Desea publicar el producto?")) {
                return false;
            } else {
                return false;
            }
        }

        function productCombo(id) {
            $("[name=product_master_id]").val(id);
            loadCombos(id, 1);
            $("#modal-combos").modal("show");
        }

        function loadCombos(id, type) {
            $.ajax({
                type: "POST",
                url : "{{ route('ajax.load-product-combo') }}",
                data: {
                    _token: csrf_token,
                    id: id
                },
                dataType: "JSON",
                success: function (response) {
                    var datax = response.data;
                    var row = '';

                    if (datax.length > 0) {
                        datax.forEach(function (element, index) {
                            if (type == 1) {
                                row += `<tr>
                                    <td>`+ element.product_combo.title +`</td>
                                    <td>`+ element.price +`</td>
                                </tr>`;
                            } else {
                                row += `<tr>
                                    <td>`+ element.code +`</td>
                                    <td>`+ element.product_combo.title +`</td>
                                    <td>`+ element.price +`</td>
                                </tr>`;
                            }
                        });
                    } else {
                        row += `<tr><td colspan="2">No se agregaron productos</td></tr>`;
                    }

                    if (type == 1) {
                        $("#result-combo").html(row);
                    } else {
                        $("#result-combo-list").html(row);
                    }
                }
            }).fail( function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function viewCombos(id) {
            loadCombos(id, 2);
            $("#modal-combos-list").modal("show");
        }
    </script>
@endsection
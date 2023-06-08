@extends('themes/lte/layout')

@section('title') Productos @endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
        <li class="active">Seccionar Productos Web</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header">
                <h6 class="box-title">Seccionar Productos para la Web</h6>
            </div>
            <div class="box-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Secciones</h6>
                            <select name="section_web_id" class="form-control input-sm" onchange="loadProduct(this.value);">
                                <option value="" selected disabled>Elija una opción</option>
                                @foreach ($section as $itemSec)
                                    <option value="{{ $itemSec->id }}">{{ $itemSec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h6>Productos</h6>
                            <select name="product_id" class="form-control input-sm">
                                @foreach ($product as $itemProd)
                                    <option value="{{ $itemProd->id }}">{{ $itemProd->sku }} - {{ $itemProd->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-sm btn-block btn-primary" style="margin-top: 31px;" onclick="procesar();">Procesar</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                    <tr>
                                        <th width="200">Sección</th>
                                        <th>Producto</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody"><tr><td colspan="2">No hay productos registrados</td></tr></tbody>
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
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        function procesar() {
            var section = $("[name=section_web_id]").val();
            var product = $("[name=product_id]").val();
            
            $.ajax({
                type: "POST",
                url : "{{ route('channels.add-section-product') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    section: section,
                    product: product,
                },
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }

        function loadProduct(value) {
            var row = '';
            $.ajax({
                type: "POST",
                url : "{{ route('channels.load-section-product') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    section: value,
                },
                dataType: "JSON",
                success: function (response) {
                    if (response.response == 'ok') {
                        var datax = response.data;
                        datax.forEach(element => {
                            row += `<tr>
                                <td>`+ element.section_web.name +`</td>
                                <td>`+ element.product.title +`</td>
                            </tr>`;

                        });
                        $('#tbody').html(row);
                    } else {
                        $('#tbody').html('<tr><td colspan="2">No hay productos registrados</td></tr>');
                    }
                }
            }).fail( function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
    </script>
@endsection
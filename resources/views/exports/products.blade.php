<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <table class="table table-border">
        <thead>
            <tr>
                <th style="background-color: #cccccc;" width="20"><b>SKU</b></th>
                <th style="background-color: #cccccc;" width="20"><b>Part Number</b></th>
                <th style="background-color: #cccccc;" width="80"><b>Nombre</b></th>
                <th style="background-color: #cccccc;" width="80"><b>Especificaciones</b></th>
                <th style="background-color: #cccccc;" width="20"><b>Categoría</b></th>
                <th style="background-color: #cccccc;" width="20"><b>Sub Categoría</b></th>
                <th style="background-color: #cccccc;" width="20"><b>Marca</b></th>
                <th style="background-color: #cccccc;"><b>Portada</b></th>
                <th style="background-color: #cccccc;" width="20"><b>Fecha de creación</b></th>
            </tr>
        </thead>
        <tbody>
        @foreach($product as $item)
            <tr>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->part_number }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ $item->subtitle }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->subcategory->name }}</td>
                <td>{{ $item->mark->name }}</td>
                <td>
                    @php
                        $total = $item->arts->where('art_type_id', 1)->count();
                        if ($total > 0) {
                            $img =  'SI';
                        } else {
                            $img =  'NO';
                        }
                    @endphp
                    {{ $img }}
                </td>
                <td>{{ date('d/m/Y H:i:A', strtotime($item->created_at)) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
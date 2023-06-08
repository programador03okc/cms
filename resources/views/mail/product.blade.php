<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Correo CMS-OKC</title>
    <style>
        .box{
            width: 600px;
            border: 1px solid rgba(234, 146, 55,.8);
            padding: 15px;
            border-radius: 8px;
        }
        .title{
            font-family: Arial, Helvetica, sans-serif;
            color: rgba(234, 146, 55,.8);
        }
        .text{
            font-family: Arial, Helvetica, sans-serif;
            color: rgba(0, 96, 160, .75);
            font-size: 11px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2 class="title">Datos del producto</h2>
        <hr>
        <p class="text"><strong>1. Nombre: </strong> {{ $data['name'] }}</p>
        <p class="text"><strong>2. Sku: </strong> {{ $data['sku'] }}</p>
        <p class="text"><strong>3. Marca: </strong> {{ $data['mark'] }}</p>
        <p class="text"><strong>4. Usuario: </strong> {{ $data['user'] }}</p>
    </div>
</body>
</html>
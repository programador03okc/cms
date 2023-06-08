<?php

namespace App\Imports;

use App\Models\CatalogProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class TemporalImport implements ToCollection, WithHeadingRow
{
    public $month, $type;

    public function __construct($month, $type)
    {
        $this->month = $month;
        $this->type = $type;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $code = Str::of($row['codigo'])->rtrim();
            $part = Str::of($row['partnumber'])->rtrim();
            $cate = Str::of($row['categoria'])->rtrim();
            $subc = Str::of($row['marca'])->rtrim();
            $anex = ($row['anexo'] != '') ? Str::of($row['anexo'])->rtrim() : null;
            $name = Str::of($row['nombre'])->rtrim();
            
            CatalogProduct::create([
                'month'         => $this->month,
                'type'          => $this->type,
                'code'          => $code,
                'part_number'   => $part,
                'category'      => $cate,
                'subcategory'   => $subc,
                'anexo'         => $anex,
                'name'          => $name,
                'stock'         => $row['stock']
            ]);
        }
    }
}

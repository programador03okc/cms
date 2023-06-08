<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Mark;
use App\Models\Specification;
use App\Models\Stock;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $array = [];
        $cont = 1;
        foreach ($rows as $row) {
            $part_num = Str::of($row['part_number'])->rtrim();
            $nombre = Str::of($row['nombre'])->rtrim();
            $modelo = Str::of($row['modelo'])->rtrim();
            $subid = intval($row['sub_id']);
            $marki = intval($row['marca_id']);

            if ($part_num != null) {
                $query = Product::where('part_number', $part_num)->get();

                if ($subid > 0 && $marki > 0) {
                    $cosku = $this->generateCode($subid, $marki);
        
                    if ($query->count() > 0) {
                        $query->first()->id;
                        $prod_id = $query;
                    } else {
                        $product = new Product();
                            $product->part_number = $part_num;
                            $product->sku = $cosku;
                            $product->name = $nombre;
                            $product->model = $modelo;
                            $product->category_id = $row['cat_id'];
                            $product->subcategory_id = $subid;
                            $product->mark_id = $marki;
                            $product->unit_id = $row['unidad'];
                            $product->wholesaler_id = 1;
                            $product->user_id = Auth::user()->id;
                            $product->correlative = 1;
                        $product->save();
                        $prod_id = $product->id;

                        $stock = new Stock();
                            $stock->type = "GENERAL";
                            $stock->product_id = $prod_id;
                            $stock->stock = $row['cantidad'];
                            // $stock->stock_web = 0;
                            $stock->user_id = Auth::user()->id;
                        $stock->save();
                        
        
                        if ($row['so2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['so2'];
                                $espec->feature_content = Str::upper($row['so3']);
                            $espec->save();
                        }
                        if ($row['tm2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['tm2'];
                            $espec->save();
                        }
                        if ($row['pro2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['pro2'];
                                $espec->feature_content = Str::upper($row['pro3']);
                            $espec->save();
                        }
                        if ($row['ram2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['ram2'];
                            $espec->save();
                        }
                        if ($row['alm2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['alm2'];
                                $espec->feature_content = Str::upper($row['alm3']);
                            $espec->save();
                        }
                        if ($row['cap2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['cap2'];
                                $espec->feature_content = Str::upper($row['cap3']);
                            $espec->save();
                        }
                        if ($row['vid2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['vid2'];
                                $espec->feature_content = Str::upper($row['vid3']);
                            $espec->save();
                        }
                        if ($row['ga2'] > 0) {
                            $espec = new Specification();
                                $espec->product_id = $prod_id;
                                $espec->feature_value_id = $row['ga2'];
                                $espec->feature_content = Str::upper($row['ga3']);
                            $espec->save();
                        }
                    }
                }
            }
        }
    }

    public function generateCode($subcat, $marca)
    {
        $subc = Subcategory::find($subcat, ['slug'])->slug;
        $mark = Mark::find($marca, ['slug'])->slug;

        $total = Product::where([
            ['correlative', 1], ['mark_id', $marca], ['subcategory_id', $subcat]
        ])->count();

        $number = (2000 + $total);
        $code = $subc.$mark.$number;
        return $code;
    }
}

<?php

namespace App\Http\Controllers\Intcomex;

use App\CatalogIntcomexOkc;
use App\Helpers\CmsHelper;
use App\Helpers\IntcomexApi;
use App\Http\Controllers\Controller;
use App\Models\CatalogIntcomex;
use App\Models\Category;
use App\Models\InventoryIntcomex;
use App\Models\ListDownload;
use App\Models\PriceIntcomex;
use App\Models\Product;
use App\Models\PendingProduct;
use App\Models\Stock;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class IntcomexController extends Controller
{
    protected $api;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function testDownload($type)
    {
        $api = new IntcomexApi();
        switch ($type) {
            case 'catalog':
                $query = (array) $api->getCatalog();
            break;
            case 'price':
                $query = (array) $api->getPrice();
            break;
            case 'stock':
                $query = (array) $api->getStock();
            break;
        }
        return response()->json($query, 200);
    }

    public function lista()
    {
        $filter = CatalogIntcomex::select('Category_Description')->orderBy('Category_Description', 'ASC')->distinct()->get();
        return view('intcomex.lista', compact('filter'));
    }

    public function pending()
    {
        $categ = Category::all();
        return view('intcomex.lista-pendiente', compact('categ'));
    }

    public function getDatesDownload(Request $request)
    {
        $catag = ListDownload::where('action', 'CATALOGO')->orderBy('created_at', 'DESC');
        $price = ListDownload::where('action', 'PRECIO')->orderBy('created_at', 'DESC');
        $stock = ListDownload::where('action', 'STOCK')->orderBy('created_at', 'DESC');

        if ($catag->count() > 0) {
            $getLastCatalog = new Carbon($catag->first()->created_at);
            $class_catag = CmsHelper::obtenerSeveridadFechaActualizacion($getLastCatalog);
            $txt_catag = 'Lista de Intcomex actualizada '.$getLastCatalog->diffForHumans();
        } else {
            $txt_catag = 'No hay una Lista de Productos actualizada';
            $class_catag = 'danger';
        }

        if ($price->count() > 0) {
            $getLastPrice = new Carbon($price->first()->created_at);
            $class_price = CmsHelper::obtenerSeveridadFechaActualizacion($getLastPrice);
            $txt_price = 'Lista de Precios actualizada '.$getLastPrice->diffForHumans();
        } else {
            $txt_price = 'No hay una Lista de Precios actualizada';
            $class_price = 'danger';
        }

        if ($stock->count() > 0) {
            $getLastStock = new Carbon($stock->first()->created_at);
            $class_stock = CmsHelper::obtenerSeveridadFechaActualizacion($getLastStock);
            $txt_stock = 'Lista de Stock actualizada '.$getLastStock->diffForHumans();
        } else {
            $txt_stock = 'No hay una Lista de Stock actualizada';
            $class_stock = 'danger';
        }

        return response()->json(
            array(
                'tipo'      => 'success',
                'catalogo'  => '<span class="text-'.$class_catag.'"> '.$txt_catag.'.</span>',
                'precio'    => '<span class="text-'.$class_price.'"> '.$txt_price.'.</span>',
                'stock'     => '<span class="text-'.$class_stock.'"> '.$txt_stock.'.</span>'
            ), 200);
    }

    public function dataList(Request $request)
    {
        if ($request->check_catalog == 'on') {
            $this->getCatalog();
        }

        if ($request->check_price == 'on') {
            $this->getPrice();
        }

        if ($request->check_stock == 'on') {
            $this->getStock();
        }
        
        return response()->json(array('response' => 'ok'), 200);
        
    }

    public function dataLista()
    {
        $data = CatalogIntcomex::select(['*', 
            DB::raw('COALESCE((SELECT ipi."UnitPrice" FROM intcomex.price_intcomexes ipi WHERE ipi."Sku" = catalog_intcomexes."Sku" LIMIT 1), 0) AS price'),
            DB::raw('COALESCE((SELECT ipi."CurrencyId" FROM intcomex.price_intcomexes ipi WHERE ipi."Sku" = catalog_intcomexes."Sku" LIMIT 1), \'\') AS currency'),
            DB::raw('COALESCE((SELECT iii."InStock" FROM intcomex.inventory_intcomexes  iii WHERE iii."Sku" = catalog_intcomexes."Sku" LIMIT 1), 0) AS stock')
        ]);

        return DataTables::of($data)
        ->addColumn('Check', function ($data){
            return '<input type="checkbox" class="event-check" data-id="'.$data->id.'" data-value="'.$data->Mpn.'">';
        })
        ->rawColumns(['Check'])->make(true);
    }

    public function dataListaPending()
    {
        $data = PendingProduct::orderBy('Mpn', 'ASC')->get();
        return DataTables::of($data)
            ->editColumn('UnitPrice', function($data) { return ($data->UnitPrice != null) ?  $data->UnitPrice  : 0; })
            ->editColumn('CurrencyId', function($data) { return ($data->CurrencyId != null) ?  $data->CurrencyId  : 0; })
            ->editColumn('InStock', function($data) { return ($data->UnitPrice != null) ?  $data->UnitPrice : 0; })
            ->addColumn('Check', function ($data){
                return '<input type="checkbox" class="event-check" data-id="'.$data->id.'" data-cat="'.$data->Category_Description.'" data-sub="'.$data->Subcategory_Description.'">';
            })
            ->rawColumns(['Check'])->make(true);
    }

    public function getCatalog()
    {
        $download = new ListDownload();
            $download->date = date('Y-m-d');
            $download->action = 'CATALOGO';
            $download->user_id = Auth::id();
        $download->save();

        CatalogIntcomex::truncate();

        $api = new IntcomexApi();
        $query = (array) $api->getCatalog();
        
        foreach ($query as $key) {
            $catalog = new CatalogIntcomex;
                $catalog->Sku = $key['Sku'];
                $catalog->Mpn = $key['Mpn'];
                $catalog->Description = $key['Description'];
                $catalog->Type = $key['Type'];

                $brandArray = $key['Brand'];
                    $catalog->ManufacturerId = $brandArray['ManufacturerId'];
                    $catalog->BrandId = $brandArray['BrandId'];
                    $catalog->Brand_Description = $brandArray['Description'];
                
                if (isset($key['Category'])) {
                    $categArray = $key['Category'];
                        $catalog->CategoryId = $categArray['CategoryId'];
                        $catalog->Category_Description = $categArray['Description'];
                    
                    if (isset($categArray['Subcategories'])) {
                        $subcatArray = $categArray['Subcategories'];
                        foreach ($subcatArray as $row) {
                            $catalog->Subcategory_CategoryId = $row['CategoryId'];
                            $catalog->Subcategory_Description = $row['Description'];
                        }
                    }
                }
            $catalog->save();
        }

        return response()->json(array('tipo' => 'success', 'mensaje' => 'Lista(s) actualizada(s)'), 200);
    }

    public function getPrice()
    {
        PriceIntcomex::truncate();
        $api = new IntcomexApi();
        $query = (array) $api->getPrice();

        DB::beginTransaction();

        foreach ($query as $key) {
            $price = new PriceIntcomex;
                $price->Sku = $key['Sku'];
                $price->Mpn = $key['Mpn'];

                $priceArray = $key['Price'];
                    $price->UnitPrice = $priceArray['UnitPrice'];
                    $price->CurrencyId = $priceArray['CurrencyId'];
            $price->save();
        }

        $download = new ListDownload();
            $download->date = date('Y-m-d');
            $download->action = 'PRECIO';
            $download->user_id = Auth::id();
        $download->save();

        DB::commit();

        return response()->json(array('tipo' => 'success', 'mensaje' => 'Lista(s) actualizada(s)'), 200);
    }

    public function getStock()
    {
        InventoryIntcomex::truncate();
        $api = new IntcomexApi();
        $query = (array) $api->getStock();

        DB::beginTransaction();
        
        foreach ($query as $key) {
            $stock = new InventoryIntcomex;
                $stock->Sku = $key['Sku'];
                $stock->Mpn = $key['Mpn'];
                $stock->InStock = $key['InStock'];
            $stock->save();
        }

        $download = new ListDownload();
            $download->date = date('Y-m-d');
            $download->action = 'STOCK';
            $download->user_id = Auth::id();
        $download->save();
        
        DB::commit();

        return response()->json(array('tipo' => 'success', 'mensaje' => 'Lista(s) actualizada(s)'), 200);
    }

    public function getPartNumber(Request $request)
    {
        $data = [];
        $data_exist = [];
        $data_not_exist = [];
        $data_pnd_exist = [];
        $item = sizeof($request->id);
        // dd($item);
        // exit();
        try {
            $ids = $request->id;
            $p_n = $request->value;
            for ($i = 0; $i < $item; $i++) { 
                $sql = Product::where('part_number', $p_n[$i]);

                if ($sql->count() > 0) {
                    $data = $sql->first();
                    $response = 'ok';
    
                    $stock = new Stock();
                        $stock->business_type_id = 1;
                        $stock->store_shop_id = 4;
                        $stock->type = 'RESERVADO';
                        $stock->product_id = $data->id;
                        $stock->stock = 10;
                        $stock->stock_web = 10;
                        $stock->stock_order = 'SI';
                        $stock->user_id = Auth::user()->id;
                    $stock->save();
                    array_push($data_exist, $p_n[$i]);
                } else {
                    $getInt = CatalogIntcomex::where('Mpn', $p_n[$i])->first();
                    $consult = PendingProduct::where([['Mpn', $p_n[$i]], ['Status', 1]])->count();
    
                    if ($consult > 0) {
                        $response = 'exist';
                        array_push($data_pnd_exist, $p_n[$i]);
                    } else {
                        $response = 'new';
                        $newData = new PendingProduct();
                            $newData->Sku = $getInt->Sku;
                            $newData->Mpn = $getInt->Mpn;
                            $newData->Description = $getInt->Description;
                            $newData->Type = $getInt->Type;
                            $newData->ManufacturerId = $getInt->ManufacturerId;
                            $newData->BrandId = $getInt->BrandId;
                            $newData->Brand_Description = $getInt->Brand_Description;
                            $newData->CategoryId = $getInt->CategoryId;
                            $newData->Category_Description = $getInt->Category_Description;
                            $newData->Subcategory_CategoryId = $getInt->Subcategory_CategoryId;
                            $newData->Subcategory_Description = $getInt->Subcategory_Description;
                            $newData->Status = 1;
                        $newData->save();
                        array_push($data_not_exist, $p_n[$i]);
                    }
                }
    
                CatalogIntcomex::find($ids[$i])->delete();
            }
        } catch (Exception $ex) {
            $response = 'error';
            $data = [];
        }
        $array = array('response' => $response, 'data' => $data, 'news' => $data_not_exist, 'exist' => $data_exist, 'pendients' => $data_pnd_exist);
        return response()->json($array, 200);
    }

    public function getNewCatalog(Request $request)
    {
        $sku = $request->sku;
        $status = $request->status;

        $catalog = CatalogIntcomex::where('Sku', $sku)->get();
        
        foreach ($catalog as $key) {
            $new_cat = new CatalogIntcomexOkc();
                $new_cat->Sku = $sku;
                $new_cat->Mpn = $key->Mpn;
                $new_cat->Description = $key->Description;
                $new_cat->Type = $key->Type;
                $new_cat->ManufacturerId = $key->ManufacturerId;
                $new_cat->BrandId = $key->BrandId;
                $new_cat->Brand_Description = $key->Brand_Description;
                $new_cat->CategoryId = $key->CategoryId;
                $new_cat->Category_Description = $key->Category_Description;
                $new_cat->Subcategory_CategoryId = $key->Subcategory_CategoryId;
                $new_cat->Subcategory_Description = $key->Subcategory_Description;

            $mon = '-';
            $pri = '0.00';
            $stk = 0;

            $queryPrice = PriceIntcomex::where('Sku', $sku);
            $queryStock = InventoryIntcomex::where('Sku', $sku);

            if ($queryPrice->count() > 0) {
                $mon = $queryPrice->first()->CurrencyId;
                $pri = $queryPrice->first()->UnitPrice;
            }

            if ($queryStock->count() > 0) {
                $stk = $queryStock->first()->InStock;
            }

                $new_cat->UnitPrice = $pri;
                $new_cat->CurrencyId = $mon;
                $new_cat->InStock = $stk;
                $new_cat->Status = $status;
            $new_cat->save();
        }
        return response()->json(array('tipo' => 'success', 'mensaje' => 'Se traslado el producto correctamente'), 200);
    }
}

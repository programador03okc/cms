<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Mark;
use App\Models\Unit;
use App\Models\TypeChange;
use App\Models\Feature;
use App\Models\Value;
use App\Models\FeatureValue;
use App\Models\Specification;
use App\Models\BusinessType;
use App\Models\Currency;
use App\Models\Stock;
use App\Models\PriceCost;
use App\Models\Price;
use App\Models\Segment;
use App\Models\Art;
use App\Imports\ProductsImport;
use App\Exports\ProductExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Mail;
use App\Mail\Correo;
use App\Models\ProductCombo;
use App\Models\ProductSection;
use App\Models\SectionWeb;
use App\Models\Tag;
use App\Models\ProductSegment;
use App\Models\ProductTag;
use App\Models\Wholesaler;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $cate = Category::all();
        $mark = Mark::all();
        $unit = Unit::all();
        $buss = BusinessType::all();
        $mone = Currency::all();
        $segm = Segment::all();
        $label = Tag::all();
        $sect = SectionWeb::all();
        $mayo = Wholesaler::all();
        $tica = TypeChange::latest()->first()->name;

        $data = Product::select(['*',
            DB::raw('COALESCE((SELECT ast.stock FROM admin.stocks ast WHERE ast.product_id = products.id ORDER BY ast.id DESC LIMIT 1), 0) AS stock'),
            DB::raw('COALESCE((SELECT apc.cost FROM admin.price_costs apc WHERE apc.product_id = products.id ORDER BY apc.id DESC LIMIT 1), 0) AS cost')
        ]);

        if ($request->session()->has('prodFilterCategory')) {
            $data->where('category_id', $request->session()->get('prodFilterCategory'));
        }

        if ($request->session()->has('prodFilterMark')) {
            $data->whereIn('mark_id', $request->session()->get('prodFilterMark'));
        }

        if ($request->session()->has('prodFilteWholesaler')) {
            $data->whereIn('wholesaler_id', $request->session()->get('prodFilteWholesaler'));
        }

        if ($request->ajax()) {
            return DataTables::of($data)
            ->addColumn('category', function ($data) { return $data->category->name; })
            ->addColumn('subcategory', function ($data) { return ($data->subcategory_id != null) ? $data->subcategory->name : ''; })
            ->addColumn('mark', function ($data) { return $data->mark->name; })
            ->addColumn('unit', function ($data) { return $data->unit->simbol; })
            ->addColumn('imagen', function ($data) {
                $query = Art::where([['product_id', $data->id], ['art_type_id', 1]])->latest();
                if ($query->count() > 0) {
                    $img =  'SI';
                } else {
                    $img =  'NO';
                }
                return $img;
            })
            ->addColumn('action', function ($data) {
                return '
                <div class="dropdown">
                    <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-cogs"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript: void(0);" class="edit_dt" onclick="showData('. $data->id. ');">Editar
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="delete_dt" onclick="deleteData('. $data->id. ');">Desactivar
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="label_dt" onclick="labelProd('. $data->id .');">Etiquetar
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="label_dt" onclick="segmentProd('. $data->id .');">Segmentar
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="label_dt" onclick="sectionProd('. $data->id .');">Sección Web
                            </a>
                        </li>
                    </ul>
                </div>';
            })
            ->rawColumns(['action'])->make(true);
        }
        return view('catalog.product', \compact('cate', 'mark', 'unit', 'buss', 'mone', 'tica', 'segm', 'label', 'sect', 'mayo'));
    }

    public function createFilter(Request $request)
    {
        try {
            if ($request->check_category == 'on') {
                $request->session()->put('prodFilterCategory', $request->selectCategory);
            } else {
                $request->session()->forget('prodFilterCategory');
            }
    
            if ($request->check_mark == 'on') {
                $request->session()->put('prodFilterMark', $request->selectMark);
            } else {
                $request->session()->forget('prodFilterMark');
            }
    
            if ($request->check_wholesaler == 'on') {
                $request->session()->put('prodFilteWholesaler', $request->selectWholesaler);
            } else {
                $request->session()->forget('prodFilteWholesaler');
            }

            $rpta = 'ok';
        } catch (Exception $ex) {
            $rpta = 'null';
        }
        return response()->json($rpta, 200);
    }

    public function viewStoreOkc()
    {
        $mone = Currency::all();
        $type_store = 'OKC';
        $tica = TypeChange::latest()->first()->name;
        $product = Product::orderBy('name', 'ASC')->get();
        return view('catalog.okc.product-store', \compact('product', 'mone', 'type_store', 'tica'));
    }

    ////// PENDIENTE DE REVISION
    public function viewListOkc()
    {
        $type_store = 'OKC';
        return view('catalog.okc.list-store', \compact('type_store'));
    }

    public function list_store()
    {
        $data = Product::orderBy('name', 'ASC')->get();
        $tc = TypeChange::latest()->first()->name;

        return DataTables::of($data)
            ->addColumn('category', function ($data) { return $data->category->name; })
            ->addColumn('subcategory', function ($data) { return ($data->subcategory_id != null) ? $data->subcategory->name : ''; })
            ->addColumn('mark', function ($data) { return $data->mark->name; })
            ->addColumn('unit', function ($data) { return $data->unit->simbol; })
            ->addColumn('margin_product', function ($data) {
                $margin = 20;
                $query = Price::where('product_id', $data->id);
                if ($query->count() > 0) {
                    $margin = $query->first()->margin;
                }
                return $margin;
            })
            ->addColumn('stock_product', function ($data) {
                $stock = 0;
                $query = Stock::where([['product_id', $data->id], ['type', 'GENERAL']])->latest();
                if ($query->count() > 0) {
                    $stock =  $query->first()->stock;
                }
                return $stock;
            })
            ->addColumn('stock_reserv', function ($data) {
                $stockRsv = Stock::where([['product_id', $data->id], ['type', 'RESERVADO']])->sum('stock');
                return $stockRsv;
            })
            ->addColumn('cost_product', function ($data) use ($tc) {
                $cost = 0;
                $query = PriceCost::where('product_id', $data->id)->latest();
                if ($query->count() > 0) {
                    $value = $query->first()->cost;
                    $money = $query->first()->currency_id;
                    if ($money == 1) {
                        $cost = $value;
                    } else {
                        $cost = ($value * $tc);
                    }
                }
                return $cost;
            })
            ->addColumn('combo', function ($data){
                $botton = '';
                $query = ProductCombo::where('product_id', $data->id)->get();
                if ($query->count() > 0) {
                    $botton = '<button class="btn btn-primary btn-xs" onclick="viewCombos('. $data->id. ');"><i class="fa fa-eye"></i></button>';
                }
                return $botton;
            })
            ->addColumn('action', function ($data) {
                return '
                <div class="dropdown">
                    <button class="btn btn-sm btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-cogs"></i>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript: void(0);" class="label_dt" onclick="publish('. $data->id. ');">Publicar
                            </a>
                        </li>
                        <li>
                            <a href="javascript: void(0);" class="delete_dt" onclick="productCombo('. $data->id. ');">Agregar combo
                            </a>
                        </li>
                    </ul>
                </div>';
            })
            ->rawColumns(['combo', 'action'])->make(true);
    }

    public function list_store_okc()
    {
        $tc = TypeChange::latest()->first()->name;

        $data = Product::select(['*',
            DB::raw("COALESCE((SELECT astg.stock FROM admin.stocks astg WHERE astg.product_id = products.id AND type = 'GENERAL' ORDER BY astg.id DESC LIMIT 1), 0) AS stock_product"),
            DB::raw("COALESCE((SELECT ast.stock FROM admin.stocks ast WHERE ast.product_id = products.id AND type = 'RESERVADO' AND store_shop_id = 1 ORDER BY ast.id DESC LIMIT 1), 0) AS stock_reserv"),
            DB::raw("COALESCE((SELECT apc.margin FROM admin.prices apc WHERE apc.product_id = products.id ORDER BY apc.id DESC LIMIT 1), 0) AS margin_product"),
            DB::raw("COALESCE((SELECT apcm.cost FROM admin.price_costs apcm WHERE apcm.product_id = products.id ORDER BY apcm.id DESC LIMIT 1), 0) AS cost"),
            DB::raw("COALESCE((SELECT apm.currency_id FROM admin.price_costs apm WHERE apm.product_id = products.id ORDER BY apm.id DESC LIMIT 1), 0) AS currency_id")
        ]);
        return DataTables::of($data)
            ->addColumn('category', function ($data) { return $data->category->name; })
            ->addColumn('subcategory', function ($data) { return ($data->subcategory_id != null) ? $data->subcategory->name : ''; })
            ->addColumn('mark', function ($data) { return $data->mark->name; })
            ->addColumn('unit', function ($data) { return $data->unit->simbol; })
            ->addColumn('cost_product', function ($data) use ($tc) {
                if ($data->currency_id == 1) {
                    $cost = $data->cost;
                } else {
                    $cost = ($data->cost * $tc);
                }
                return $cost;
            })->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = new Product();
                $data->part_number = $request->part_number;
                $data->sku = $request->sku;
                $data->name = $request->name;
                $data->model = $request->model;
                $data->category_id = $request->category_id;
                $data->subcategory_id = $request->subcategory_id;
                $data->mark_id = $request->mark_id;
                $data->unit_id = $request->unit_id;
                $data->detail = $request->detail;
                $data->link = $request->link;
                $data->link_index = $request->link_index;
                $data->wholesaler_id = $request->wholesaler_id;
                $data->user_id = Auth::user()->id;
                $data->correlative = $request->correlative;
            $data->save();

            if (isset($request->feature_value)) {
                $items = $request->feature_value;
                $extra = $request->feature_content;
                $count = sizeof($items);

                for ($i = 0; $i < $count; $i++) {
                    $texto = null;
                    if ($extra[$i] != null && $extra[$i] != '') {
                        $texto = Str::upper($extra[$i]);
                    }

                    $espec = new Specification();
                        $espec->product_id = $data->id;
                        $espec->feature_value_id = $items[$i];
                        $espec->feature_content = $texto;
                    $espec->save();
                }
            }

            $this->generateSlug($data->id, $data->name, $data->model, $data->category_id);
            
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el producto: <b>'.$data->name.'</b>');

            // $dataMail = [
            //     'name'      => $data->title,
            //     'sku'       => $data->sku,
            //     'mark'      => $data->mark->name,
            //     'user'      => $data->user->name
            // ];

            // Mail::to(['alvarez.programador@gmail.com'])->send(new Correo($dataMail));
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.product.index');
    }

    public function show($id)
    {
        $data = Product::with('specifications.feature_value.feature', 'specifications.feature_value.value')->find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Product::findOrFail($id);
                $data->part_number = $request->part_number;
                $data->sku = $request->sku;
                $data->name = $request->name;
                $data->model = $request->model;
                $data->category_id = $request->category_id;
                $data->subcategory_id = $request->subcategory_id;
                $data->mark_id = $request->mark_id;
                $data->unit_id = $request->unit_id;
                $data->detail = $request->detail;
                $data->link = $request->link;
                $data->user_id = Auth::user()->id;
                $data->correlative = $request->correlative;
            $data->save();

            $items = $request->feature_value;
            $speci = $request->specification_id;
            $extra = $request->feature_content;
            $count = sizeof($items);

            for ($i = 0; $i < $count; $i++) {
                $texto = null;
                if ($extra[$i] != null && $extra[$i] != '') {
                    $texto = Str::upper($extra[$i]);
                }
                
                $espec = Specification::firstOrNew(['id' => $speci[$i]]);
                    $espec->product_id = $data->id;
                    $espec->feature_value_id = $items[$i];
                    $espec->feature_content = $texto;
                $espec->save();
            }

            $this->generateSlug($data->id, $data->name, $data->model, $data->category_id);
            
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado el producto: <b>'.$data->name.'</b>');

        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.product.index');
    }

    public function destroy($id)
    {
        try {
            $data = Product::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha desactivado el producto';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }

    public function deleteSpecification(Request $request)
    {
        try {
            $data = Specification::find($request->id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado el item del producto';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }

    public function loadElements(Request $request)
    {
        $array = array('response' => 0);
        if ($request->type == 'subcategoria') {
            $data = Subcategory::where('category_id', $request->id);
        } else {
            $data = Feature::where('category_id', $request->id);
        }

        if ($data->count() > 0) {
            $array = array('response' => 1, 'data' => $data->get());
        }
        return response()->json($array, 200);
    }

    public function loadValue(Request $request)
    {
        $array = array('response' => 0);
        $data = FeatureValue::with('value')->where('feature_id', $request->id);

        if ($data->count() > 0) {
            $array = array('response' => 1, 'data' => $data->get());
        }
        return response()->json($array, 200);
    }

    public function generateCode(Request $request)
    {
        $subc = Subcategory::find($request->subca, ['slug'])->slug;
        $mark = Mark::find($request->marca, ['slug'])->slug;

        $total = Product::where([
            ['correlative', 1], ['mark_id', $request->marca], ['subcategory_id', $request->subca]
        ])->count();

        $number = (2000 + $total);
        $code = $subc.$mark.$number;
        return response()->json($code, 200);
    }

    public function generateSlug($product, $name, $model, $category)
    {
        $query = Specification::where('product_id', $product)->get();

        $titlei = '';
        $espec1 = '';
        $espec2 = '';
        $espec3 = '';
        $espec4 = '';
        $espec5 = '';
        $espec6 = '';
        $espec7 = '';
        $espec8 = '';
        $espec9 = '';
        $espec10 = '';
        $espec11 = '';

        if ($name != '') {
            if ($model != '') {
                $titlei = $name.' '.$model;
            } else {
                $titlei = $name;
            }
        } else {
            if ($model != '') {
                $titlei = $model;
            }
        }

        foreach ($query as $key) {
            $feature = Str::upper($key->feature_value->feature->name);
            $value = Str::upper($key->feature_value->value->name);
            $extra = ($key->feature_content != null) ? Str::upper($key->feature_content) : '';

            switch ($feature) {
                case 'PROCESADOR':
                    $espec_1 = $value;
                    $inival = str_replace('INTEL ', '', $espec_1);
                    $espec1 = Str::of($inival)->rtrim().' ';
                break;
                case 'MEMORIA RAM':
                    $espec_2 = $value;
                    $espec2 = Str::of($espec_2)->rtrim().' RAM'.' ';
                break;
                case 'CAPACIDAD':
                    $espec_3 = $value;
                    $espec3 = Str::of($espec_3)->rtrim().' ';
                break;
                case 'ALMACENAMIENTO':
                    $espec_4 = $value;
                    $espec4 = Str::of($espec_4)->rtrim().' ';
                break;
                case 'TAMAÑO':
                    $espec_5 = $value;
                    $espec5 = Str::of($espec_5)->rtrim().' ';
                break;
                case 'RESOLUCION':
                    $espec_6 = $value;
                    $espec6 = Str::of($espec_6)->rtrim().' ';
                break;
                case 'TARJETA DE VIDEO':
                    $espec_7 = $value;
                    $espec7 = Str::of($espec_7)->rtrim().' ';
                break;
                case 'SISTEMA OPERATIVO':
                    $espec_8 = $value;
                    $espec8 = Str::of($espec_8)->rtrim().' ';
                break;
                case 'GARANTIA':
                    $espec_9 = $value.' '.$extra;
                    $espec9 = Str::of($espec_9)->rtrim().' ';
                break;
                case 'PANTALLA':
                    $espec_10 = $value.' '.$extra;
                    $espec10 = Str::of($espec_10)->rtrim().' ';
                break;
                case 'CONECTORES':
                    $espec_11 = $value.' '.$extra;
                    $espec11 = Str::of($espec_11)->rtrim().' ';
                break;
            }
        }

        if ($category == 1) {
            $slug_short_txt = $titlei.' '.$espec1.$espec2.$espec3.$espec4.$espec5;
            $slug_large_txt = $titlei.' '.$espec1.$espec2.$espec3.$espec4.$espec7.$espec5.$espec6.$espec8.$espec9;
        } else if ($category > 1) {
            $slug_short_txt = $titlei.' '.$espec5.$espec9;
            $slug_large_txt = $titlei.' '.$espec5.$espec9.$espec10.$espec8;
        }
        
        $slug_short = Str::of($slug_short_txt)->rtrim();
        $slug_large = Str::of($slug_large_txt)->rtrim();

        $array = array('id' => $product, 'short' => $slug_short_txt, 'large' => $slug_large_txt);

        $data = Product::findOrFail($product);
            $data->title = $slug_short;
            $data->subtitle = $slug_large;
            $data->slug_large = Str::slug($slug_large, '-');
            $data->slug_short = Str::slug($slug_short, '-');
        $data->save();

       return $array;
    }

    public function updateValues(Request $request)
    {
        try {
            if ($request->type == 'stock') {
                $data = new Stock();
                    $data->type = "GENERAL";
                    $data->product_id = $request->id;
                    $data->stock = $request->value;
                    $data->stock_web = 0;
                    $data->user_id = Auth::user()->id;
                $data->save();

                $message = 'Stock actualizado';
            } else {
                $data = new PriceCost();
                    $data->product_id = $request->id;
                    $data->currency_id = $request->currency;
                    $data->cost = $request->value;
                    $data->user_id = Auth::user()->id;
                $data->save();

                $message = 'Costo actualizado';
            }
            $response = 'ok';
        }catch (Exception $ex) {
            $response = 'null';
            $message = 'Hubo un problema en el servidor. Por favor intente de nuevo';
        }
        $array = array('response' => $response, 'message' => $message);
        return response()->json($array, 200);
    }

    public function updatePrices(Request $request)
    {
        try {
            $data = new Price();
                $data->business_type_id = $request->business_type;
                $data->store_shop_id = $request->store_shop;
                $data->product_id = $request->id;
                $data->currency_id = 1;
                $data->cost = $request->cost;
                $data->margin = $request->margin;
                $data->discount = 0;
                $data->price = $request->price;
                $data->status = 'VENTA';
                $data->user_id = Auth::user()->id;
            $data->save();

            $response = 'ok';
            $message = 'Precio actualizado';
        } catch (Exception $ex) {
            $response = 'null';
            $message = 'Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        $array = array('response' => $response, 'message' => $message);
        return response()->json($array, 200);
    }

    public function stockStore(Request $request)
    {
        try {
            $data = new Stock();
                $data->business_type_id = $request->business_type_id;
                $data->store_shop_id = $request->store_shop_id;
                $data->type = 'RESERVADO';
                $data->product_id = $request->product_id;
                $data->stock = $request->stock_reserv;
                $data->stock_web = $request->stock_web;
                $data->stock_order = $request->pedido_web;
                $data->user_id = Auth::user()->id;
            $data->save();

            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha reservado el stock');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema. Por favor intente de nuevo');
        }
        return redirect()->route('channels.store_okc');
    }

    public function loadVariant(Request $request)
    {
        try {
            if ($request->type == 'ETIQUETA') {
                $data = ProductTag::with('tag')->where('product_id', $request->id)->get();
            } else if ($request->type == 'SEGMENTO') {
                $data = ProductSegment::with('segment')->where('product_id', $request->id)->get();
            } else if ($request->type == 'SECCION') {
                $data = ProductSection::with('section_web')->where('product_id', $request->id)->get();
            }
            $response = 'ok';
        } catch (Exception $ex) {
            $response = 'null';
            $data = [];
        }
        $array = array('response' => $response, 'data' => $data);
        return response()->json($array, 200);
    }

    public function loadCombo(Request $request)
    {
        try {
            $data = ProductCombo::with('product_combo')->where('product_id', $request->id)->get();
            $response = 'ok';
        } catch (Exception $ex) {
            $response = 'null';
            $data = [];
        }
        $array = array('response' => $response, 'data' => $data);
        return response()->json($array, 200);
    }

    public function loadStockWeb(Request $request)
    {
        try {
            $data = Stock::with('store_shop')->where([['product_id', $request->id], ['type', 'RESERVADO']])->get();
            $response = 'ok';
        } catch (Exception $ex) {
            $response = 'null';
            $data = [];
        }
        $array = array('response' => $response, 'data' => $data);
        return response()->json($array, 200);
    }

    public function loadPriceProduct(Request $request)
    {
        $price = 0;
        $data = Price::where('product_id', $request->value)->latest();

        if ($data->count() > 0) {
            $price = $data->first()->price;
        }
        return $price;
    }

    public function segmentStore(Request $request)
    {
        try {
            $data = new ProductSegment();
                $data->segment_id = $request->segment_id;
                $data->product_id = $request->product_id_seg;
            $data->save();
            
            $response = 'ok';
            $alert = 'success';
            $msj = 'Se ha registrado el segmento del producto';
        } catch (Exception $ex) {
            $response = 'null';
            $alert = 'error';
            $msj ='Hubo un problema al ejecutar. Por favor intente de nuevo';
        }
        return response()->json(array('response' => $response, 'message' => $msj, 'alert' => $alert), 200);
    }

    public function tagStore(Request $request)
    {
        try {
            $data = new ProductTag();
                $data->tag_id = $request->tag_id;
                $data->product_id = $request->product_id_tag;
            $data->save();
            
            $response = 'ok';
            $alert = 'success';
            $msj = 'Se ha registrado la etiqueta del producto';
        } catch (Exception $ex) {
            $response = 'null';
            $alert = 'error';
            $msj ='Hubo un problema al ejecutar. Por favor intente de nuevo';
        }
        return response()->json(array('response' => $response, 'message' => $msj, 'alert' => $alert), 200);
    }

    public function sectionStore(Request $request)
    {
        try {
            $data = new ProductSection();
                $data->section_web_id = $request->section_web_id;
                $data->product_id = $request->product_id_sect;
            $data->save();
            
            $response = 'ok';
            $alert = 'success';
            $msj = 'Se ha registrado la sección web del producto';
        } catch (Exception $ex) {
            $response = 'null';
            $alert = 'error';
            $msj ='Hubo un problema al ejecutar. Por favor intente de nuevo';
        }
        return response()->json(array('response' => $response, 'message' => $msj, 'alert' => $alert), 200);
    }

    public function comboStore(Request $request)
    {
        try {
            $code = $this->generateCodeCombo();
            $data = new ProductCombo();
                $data->code = $code;
                $data->product_id = $request->product_master_id;
                $data->product_combo_id = $request->product_combo_id;
                $data->price = $request->price;
            $data->save();
            
            $id = $data->product_id;
            $response = 'ok';
            $alert = 'success';
            $msj = 'Se ha registrado el combo del producto';
        } catch (Exception $ex) {
            $id = 0;
            $response = 'null';
            $alert = 'error';
            $msj ='Hubo un problema al ejecutar. Por favor intente de nuevo';
        }
        return response()->json(array('response' => $response, 'message' => $msj, 'alert' => $alert, 'id' => $id), 200);
    }

    public function generateCodeCombo()
    {
        $text = 'COMBO-';
        $total = ProductCombo::count() + 1;
        $number = $this->leftZero(6, $total);
        $code = $text.$number;
        return $code;
    }

    public function import(Request $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new ProductsImport(), $file);

        $this->loadDataEspec();

        $request->session()->flash('key', 'success');
        $request->session()->flash('title', 'Carga masiva de Excel');
        $request->session()->flash('message', 'Se han registrado los productos');
        return redirect()->back();
    }

    /////
    //$query->whereIn('id_empresa', $request->selectEmpresa);

    public function export()
    {
        return Excel::download(new ProductExport, 'productos.xlsx');
    }

    function leftZero($lenght, $number){
		$nLen = strlen($number);
		$zeros = '';
		for ($i = 0; $i < ($lenght - $nLen); $i++) {
			$zeros = $zeros.'0';
		}
		return $zeros.$number;
	}

    ///////////
    /// TEMPS
    public function loadDataEspec()
    {
        $sql = Product::orderBy('id', 'ASC')->get();
        $arrayName = array();

        foreach ($sql as $key) {
            $product = $key->id;
            $name = $key->name;
            $model = $key->model;
            $categ = $key->category_id;

            $value = $this->generateSlug($product, $name, $model, $categ);
            array_push($arrayName, $value);
        }
        return response()->json($arrayName, 200);
    }

    public function existProduct()
    {
        $product = Product::get();
        $si = [];
        $no = [];
        foreach ($product as $key) {
            $ruta = public_path().'/web/portadas/';
            $title = $key->part_number;
            
            $file_name = $title.'-'.time().'.png';
            $file_path = public_path().'/web/artes/'.$file_name;

            $files = $ruta.$title.'.png';
            if (file_exists($files)) {
                $si[] = ['equipo' => $title, 'status' => 'ok'];

                $old = public_path().'/web/portadas/'.$key->part_number.'.png';
                $new = public_path().'/web/artes/'.$file_name;
                copy($old, $new);

                $data = new Art();
                    $data->art_type_id = 1;
                    $data->product_id = $key->id;
                    $data->name = $file_name;
                    $data->path = $file_path;
                    $data->user_id = Auth::user()->id;
                $data->save();
            } else {
                $no[] = ['equipo' => $title, 'status' => 'null'];
            }
        }
        return response()->json(array('si' => $si, 'no' => $no), 200);
    }
}

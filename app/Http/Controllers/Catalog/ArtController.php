<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Product;
use App\Models\ArtType;
use App\Models\Section;
use App\Models\Gallery;
use App\Models\Art;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Auth;

class ArtController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $art_type = ArtType::all();
        $section = Section::all();
        $product = Product::all();
        return view('catalog.arts', \compact('art_type', 'section', 'product'));
    }

    public function show(Request $request)
    {
        $array = array('response' => 0);

        if ($request->type == 3) {
            $data = Gallery::where([['section_id', $request->section], ['art_type_id', $request->type]]);
            if ($data->count() > 0) {
                $array = array('response' => 1, 'data' => $data->get());
            }
        } else {
            $data = Art::where([['product_id', $request->product], ['art_type_id', $request->type]]);
            
            if ($data->count() > 0) {
                $array = array('response' => 1, 'data' => $data->with('product')->get());
            }
        }

        return response()->json($array, 200);
    }

    public function saveImageBanner(Request $request)
    {
        try {

            $section = Section::find($request->img_section_id);
            $code = $this->generateCodeGallery();
            $nameSec = $section->name.' '.$section->description.' '.$code;
            $title = Str::slug($nameSec, '-');

            if($request->hasFile('images')) {
                $files = $request->file('images');
    
                foreach($files as $file) {
                    $file_name = $title.'-'.time().'.'.$file->getClientOriginalExtension();
                    $file_path = public_path().'/web/banners/'.$file_name;
                    $file->move(public_path().'/web/banners/', $file_name);
    
                    $data = new Gallery();
                        $data->art_type_id = $request->img_art_type_id;
                        $data->section_id = $request->img_section_id;
                        $data->name = $file_name;
                        $data->path = $file_path;
                        $data->user_id = Auth::user()->id;
                    $data->save();
                }
            }
            $storeData = Gallery::all();

            $response = 'ok';
            $alert = 'success';
            $message = 'Se han registrado las imagenes';
        } catch (Exception $ex) {
            $response = 'error';
            $alert = 'error';
            $message = 'Hubo un problema al registrar. Por favor intente de nuevo';
        }

        $arrayJson = array(
            'response' => $response, 'alert' => $alert, 'message' => $message, 'data' => $storeData, 
            'type_input' => $request->img_art_type_id, 'product_input' => 0, 'section_input' => $request->img_section_id
        );
        return response()->json($arrayJson, 200);
    }

    public function saveImageProduct(Request $request)
    {
        try {
            $product = Product::find($request->img_product_id);
            $title = $product->sku;

            if($request->hasFile('images')) {
                $files = $request->file('images');
    
                foreach($files as $file) {
                    $file_name = $title.'-'.time().'.'.$file->getClientOriginalExtension();
                    $file_path = public_path().'/web/artes/'.$file_name;
                    $file->move(public_path().'/web/artes/', $file_name);
    
                    $data = new Art();
                        $data->art_type_id = $request->img_art_type_id;
                        $data->product_id = $request->img_product_id;
                        $data->name = $file_name;
                        $data->path = $file_path;
                        $data->user_id = Auth::user()->id;
                    $data->save();
                }
            }
            $storeData = Art::where([['product_id', $request->img_product_id], ['art_type_id', $request->img_art_type_id]])->with('product')->get();

            $response = 'ok';
            $alert = 'success';
            $message = 'Se han registrado las imagenes';
        } catch (Exception $ex) {
            $response = 'error';
            $alert = 'error';
            $message = 'Hubo un problema al registrar. Por favor intente de nuevo';
        }
        $arrayJson = array(
            'response' => $response, 'alert' => $alert, 'message' => $message, 'data' => $storeData, 
            'type_input' => $request->img_art_type_id, 'product_input' => $request->img_product_id, 'section_input' => 0
        );
        return response()->json($arrayJson, 200);
    }

    public function delete(Request $request)
    {
        try {
            if ($request->type == "banner") {
                Gallery::find($request->id)->delete();
                $msj = 'Se ha eliminado el banner';
            } else {
                Art::find($request->id)->delete();
                $msj = 'Se ha eliminado la imagen del producto';
            }
            $response = 'ok';
            $alert = 'info';
        } catch (Exception $ex) {
            $response = 'null';
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('response' => $response, 'message' => $msj, 'alert' => $alert), 200);
    }

    public function generateCodeGallery()
    {
        $tot = Gallery::count();
        $sgt = $tot + 1;
        $number = $this->leftZero(4, $sgt);
        $serie = 'IMG-OKC-'.$number;
        return $serie;
    }

    public function leftZero($lenght, $number)
    {
		$nLen = strlen($number);
		$zeros = '';
		for($i = 0; $i < ($lenght - $nLen); $i++){
			$zeros = $zeros.'0';
		}
		return $zeros.$number;
	}
}

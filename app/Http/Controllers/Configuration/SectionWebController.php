<?php

namespace App\Http\Controllers\Configuration;

use App\Models\SectionWeb;
use App\Models\Product;
use App\Models\ProductSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;

class SectionWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('configuration.section-web');
    }

    public function list()
    {
        $data = SectionWeb::orderBy('name', 'ASC')->get();
        return datatables($data)->addColumn('action', '/partials/action_section-web')->toJson();
    }

    public function store(Request $request)
    {
        try {
            $data = new SectionWeb();
                $data->name = $request->name;
                $data->page = $request->page;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la sección web: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.section-web.index');
    }

    public function show($id)
    {
        $data = SectionWeb::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = SectionWeb::findOrFail($id);
                $data->name = $request->name;
                $data->page = $request->page;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la sección web: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.section-web.index');
    }

    public function destroy($id)
    {
        try {
            $data = SectionWeb::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la sección web';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }

    public function viewSectionOkc(Request $request)
    {
        $section = SectionWeb::all();
        $product = Product::all();
        return view('catalog.okc.section-product', \compact('section', 'product'));
    }

    public function loadSection(Request $request)
    {
        $data = ProductSection::with(['product', 'section_web'])->where('section_web_id', $request->section)->get();
        if ($data->count() > 0) {
            $array = $data;
            $msj = 'ok';
        } else {
            $array = [];
            $msj = 'null';
        }
        return response()->json(array('response' => $msj, 'data' => $array), 200);
    }

    public function addSection(Request $request)
    {
        try {
            $data = new ProductSection();
                $data->section_web_id = $request->section;
                $data->product_id = $request->product;
            $data->save();
            $alert = 'info';
            $msj = 'Se ha agregado el producto a la sección web';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

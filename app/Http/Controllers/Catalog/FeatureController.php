<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Feature;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categ = Category::all();
        return view('catalog.feature', \compact('categ'));
    }

    public function list()
    {
        $data = Feature::all();
        return DataTables::of($data)
            ->addColumn('category', function ($data) { return $data->category->name; })
            ->addColumn('action', '/partials/action_feature')->make(true);
    }

    public function store(Request $request)
    {
        try {
            $data = new Feature();
                $data->category_id = $request->category_id;
                $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la característica: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.feature.index');
    }

    public function show($id)
    {
        $data = Feature::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Feature::findOrFail($id);
                $data->category_id = $request->category_id;
                $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la característica: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.feature.index');
    }

    public function destroy($id)
    {
        try {
            $data = Feature::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la característica';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

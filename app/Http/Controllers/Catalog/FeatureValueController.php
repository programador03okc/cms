<?php

namespace App\Http\Controllers\Catalog;

use App\Models\FeatureValue;
use App\Models\Feature;
use App\Models\Value;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class FeatureValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categ = Category::all();
        $value = Value::all();
        return view('catalog.specification', \compact('categ', 'value'));
    }

    public function list()
    {
        $data = FeatureValue::all();
        return datatables($data)
            ->editColumn('feature', function ($data) { return $data->feature->name; })
            ->editColumn('value', function ($data) { return $data->value->name; })
            ->addColumn('action', '/partials/action_specification')->toJson();
    }

    public function store(Request $request)
    {
        try {
            $query = FeatureValue::where([['feature_id', $request->feature_id], ['value_id', $request->value_id]])->count();

            if ($query > 0) {
                $request->session()->flash('key', 'info');
                $request->session()->flash('message', 'Se ha encontró duplicidad de la especificación');
            } else {
                $data = new FeatureValue();
                    $data->feature_id = $request->feature_id;
                    $data->value_id = $request->value_id;
                $data->save();
                $request->session()->flash('key', 'success');
                $request->session()->flash('message', 'Se ha registrado la especificación');
            }
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.feature-value.index');
    }

    public function show($id)
    {
        $data = FeatureValue::with('feature.category')->find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = FeatureValue::findOrFail($id);
                $data->feature_id = $request->feature_id;
                $data->value_id = $request->value_id;
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
            $data = FeatureValue::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la especificación';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

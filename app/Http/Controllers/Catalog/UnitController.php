<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.unit');
    }

    public function list()
    {
        $data = Unit::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_unit')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.units']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.unit.index');
        }

        try {
            $data = new Unit();
            $data->name = $request->name;
            $data->simbol = $request->simbol;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la unidad de medida: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.unit.index');
    }

    public function show($id)
    {
        $data = Unit::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Unit::findOrFail($id);
            $data->name = $request->name;
            $data->simbol = $request->simbol;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la unidad de medida: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.unit.index');
    }

    public function destroy($id)
    {
        try {
            $data = Unit::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la unidad de medida';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

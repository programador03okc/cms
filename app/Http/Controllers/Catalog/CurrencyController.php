<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.currency');
    }

    public function list()
    {
        $data = Currency::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_currency')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.currencies']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.currency.index');
        }

        try {
            $data = new Currency();
            $data->name = $request->name;
            $data->simbol = $request->simbol;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la moneda: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.currency.index');
    }

    public function show($id)
    {
        $data = Currency::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Currency::findOrFail($id);
            $data->name = $request->name;
            $data->simbol = $request->simbol;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la moneda: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.currency.index');
    }

    public function destroy($id)
    {
        try {
            $data = Currency::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la moneda';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

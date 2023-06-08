<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Wholesaler;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class WholesalerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.wholesaler');
    }

    public function list()
    {
        $data = Wholesaler::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_wholesaler')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['document' => 'unique:pgsql.admin.wholesalers']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.wholesaler.index');
        }

        try {
            $data = new Wholesaler();
                $data->document = $request->document;
                $data->name = $request->name;
                $data->address = $request->address;
            $data->save();

            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el mayorista: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.wholesaler.index');
    }

    public function show($id)
    {
        $data = Wholesaler::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Wholesaler::findOrFail($id);
            $data->document = $request->document;
            $data->name = $request->name;
            $data->address = $request->address;
            $data->save();

            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado el mayorista: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.wholesaler.index');
    }

    public function destroy($id)
    {
        try {
            $data = Wholesaler::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado el mayorista';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

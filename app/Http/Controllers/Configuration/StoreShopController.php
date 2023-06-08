<?php

namespace App\Http\Controllers\Configuration;

use App\Models\StoreShop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StoreShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('configuration.store-shop');
    }

    public function list()
    {
        $data = StoreShop::orderBy('name', 'ASC')->get();
        return datatables($data)->addColumn('action', '/partials/action_store-shop')->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.store_shops']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('configurations.store-shop.index');
        }

        try {
            $data = new StoreShop();
            $data->name = $request->name;
            $data->website = $request->website;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.store-shop.index');
    }

    public function show($id)
    {
        $data = StoreShop::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = StoreShop::findOrFail($id);
            $data->name = $request->name;
            $data->website = $request->website;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.store-shop.index');
    }

    public function destroy($id)
    {
        try {
            $data = StoreShop::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la tienda online';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

<?php

namespace App\Http\Controllers\Configuration;

use App\Models\TypeChange;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TypeChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('configuration.type-change');
    }

    public function list()
    {
        $data = TypeChange::latest()->get();
        return datatables($data)->editColumn('created_at', function ($data) { return date('d/m/Y H:i A', strtotime($data->created_at)); })->toJson();
    }

    public function store(Request $request)
    {
        try {
            $data = new TypeChange();
            $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el tipo de cambio: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.type-change.index');
    }

    public function show($id)
    {
        $data = TypeChange::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = TypeChange::findOrFail($id);
            $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado el tipo de cambio: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.type-change.index');
    }

    public function destroy($id)
    {
        try {
            $data = TypeChange::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado el tipo de cambio';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

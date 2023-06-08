<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.section');
    }

    public function list()
    {
        $data = Section::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_section')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.sections']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.section.index');
        }

        try {
            $data = new Section();
                $data->name = $request->name;
                $data->description = $request->description;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el tipo de imagen: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.section.index');
    }

    public function show($id)
    {
        $data = Section::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Section::findOrFail($id);
                $data->name = $request->name;
                $data->description = $request->description;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado el tipo de imagen: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.section.index');
    }

    public function destroy($id)
    {
        try {
            $data = Section::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado el tipo de imagen';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

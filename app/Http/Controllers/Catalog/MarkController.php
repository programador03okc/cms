<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Mark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.mark');
    }

    public function list()
    {
        $data = Mark::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_mark')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.marks']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.mark.index');
        }

        try {
            $data = new Mark();
            
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = uniqid().'-'.time().'.'.$file->getClientOriginalExtension();
                $file_path = public_path().'/image/marcas/'.$file_name;
                $file->move(public_path().'/image/marcas/', $file_name);
                $data->logo = $file_name;
                $data->path = $file_path;
            }

                $data->name = $request->name;
                $data->slug = $request->slug;
            $data->save();

            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la marca: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.mark.index');
    }

    public function show($id)
    {
        $data = Mark::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Mark::findOrFail($id);
                $data->fill($request->except('logo'));

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $file_name = uniqid().'-'.time().'.'.$file->getClientOriginalExtension();
                $file_path = public_path().'/image/marcas/'.$file_name;
                $file->move(public_path().'/image/marcas/', $file_name);
                $data->logo = $file_name;
                $data->path = $file_path;
            }

                $data->name = $request->name;
                $data->slug = $request->slug;
            $data->save();

            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la marca: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.mark.index');
    }

    public function destroy($id)
    {
        try {
            $mark = Mark::find($id);
            $nameFile = public_path().'/image/marcas/'.$mark->logo;
            File::delete($nameFile);
            $mark->delete();
            
            $alert = 'info';
            $msj = 'Se ha eliminado la marca';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

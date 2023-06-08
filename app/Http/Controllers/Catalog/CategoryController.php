<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('catalog.category');
    }

    public function list()
    {
        $data = Category::all();
        return DataTables::of($data)->addColumn('action', '/partials/action_category')->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.categories']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.category.index');
        }

        try {
            $data = new Category();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = uniqid().'-'.time().'.'.$file->getClientOriginalExtension();
                $file_path = public_path().'/web/categorias/'.$file_name;
                $file->move(public_path().'/web/categorias/', $file_name);

                $data->image = $file_name;
                $data->path = $file_path;
            }

                $data->name = $request->name;
            $data->save();

            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.category.index');
    }

    public function show($id)
    {
        $data = Category::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Category::findOrFail($id);
            $data->fill($request->except('image'));
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $file_name = time().$file->getClientOriginalName();
                $file_path = public_path().'/web/categorias/'.$file_name;
                $file->move(public_path().'/web/categorias/', $file_name);
                
                $data->image = $file_name;
                $data->path = $file_path;
            }
                $data->name = $request->name;
            $data->save();

            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.category.index');
    }

    public function destroy($id)
    {
        try {
            $data = Category::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la categoría';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

<?php

namespace App\Http\Controllers\Catalog;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $category = Category::orderBy('name', 'ASC')->get();
        return view('catalog.subcategory', \compact('category'));
    }

    public function list()
    {
        $data = Subcategory::all();
        return DataTables::of($data)
            ->addColumn('category', function ($sub) { return $sub->category->name; })
            ->addColumn('action', '/partials/action_subcategory')->make(true);
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'unique:pgsql.admin.subcategories']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese nombre');
            return redirect()->route('catalogs.subcategory.index');
        }

        try {
            $data = new Subcategory();
                $data->name = $request->name;
                $data->slug = $request->slug;
                $data->category_id = $request->category_id;
            $data->save();

            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado la sub categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.subcategory.index');
    }
    
    public function show($id)
    {
        $subcateg = Subcategory::find($id);
        return response()->json($subcateg, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Subcategory::findOrFail($id);
                $data->name = $request->name;
                $data->slug = $request->slug;
                $data->category_id = $request->category_id;
            $data->save();
            
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado la sub categoría: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('catalogs.subcategory.index');
    }
    
    public function destroy($id)
    {
        try {
            $data = Subcategory::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado la sub categoría';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

<?php

namespace App\Http\Controllers\Catalog;

use App\Models\CatalogProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TemporalImport;

class TempProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('temp.product');
    }

    public function list()
    {
        $filter = 'JUNIO';
        $data = CatalogProduct::where('month', $filter)->orderBy('name', 'ASC')->get();
        return datatables($data)->toJson();
    }

    public function import(Request $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new TemporalImport($request->month, $request->type), $file);

        $request->session()->flash('key', 'success');
        $request->session()->flash('title', 'Carga masiva de Excel');
        $request->session()->flash('message', 'Se han registrado la lista de productos temporales');
        return redirect()->back();
    }
}

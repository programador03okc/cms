<?php

namespace App\Http\Controllers\Configuration;

use App\Models\Segment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Validator;

class SegmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('configuration.segment');
    }

    public function list()
    {
        $data = Segment::orderBy('name', 'ASC')->get();
        return datatables($data)->addColumn('action', '/partials/action_segment')->toJson();
    }

    public function store(Request $request)
    {
        try {
            $data = new Segment();
                $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el segmento: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.segment.index');
    }

    public function show($id)
    {
        $data = Segment::find($id);
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Segment::findOrFail($id);
                $data->name = $request->name;
            $data->save();
            $request->session()->flash('key', 'info');
            $request->session()->flash('message', 'Se ha editado el segmento: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al editar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.segment.index');
    }

    public function destroy($id)
    {
        try {
            $data = Segment::find($id)->delete();
            $alert = 'info';
            $msj = 'Se ha eliminado el segmento';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj ='Hubo un problema al eliminar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

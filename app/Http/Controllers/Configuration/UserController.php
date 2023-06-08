<?php

namespace App\Http\Controllers\Configuration;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('configuration.user');
    }

    public function list()
    {
        $data = User::latest()->get();
        return datatables($data)
            ->addColumn('action', '/partials/action_user')
            ->editColumn('created_at', function ($data) { return date('d/m/Y H:i A', strtotime($data->created_at)); })->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'unique:pgsql.admin.users']);

        if ($validator->fails()) {
            $request->session()->flash('key', 'warning');
            $request->session()->flash('message', 'Duplicado, existe un registro con ese correo');
            return redirect()->route('configurations.user.index');
        }

        try {
            $data = new User();
                $data->name = $request->name;
                $data->email = $request->email;
                $data->password = Hash::make('cms_01OKC');
                $data->remember_token = Str::random(10);
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha registrado el usuario: <b>'.$data->name.'</b>');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->route('configurations.user.index');
    }

    public function changePassword(Request $request)
    {
        try {
            $id = $request->user_id;
                $password = $request->password;
                $data = User::findOrFail($id);
                $data->password = Hash::make($password);
            $data->save();
            $request->session()->flash('key', 'success');
            $request->session()->flash('message', 'Se ha actualizado su contraseña');
        } catch (Exception $ex) {
            $request->session()->flash('key', 'error');
            $request->session()->flash('message', 'Hubo un problema al registrar. Por favor intente de nuevo');
        }
        return redirect()->back();
    }

    public function newPassword(Request $request)
    {
        try {
            $data = User::findOrFail($request->id);
                $data->password = Hash::make('cms_01OKC');
            $data->save();
            $alert = 'success';
            $msj = 'Se ha actualizado la contraseña <b>(cms_01OKC)</b>';
        } catch (Exception $ex) {
            $alert = 'error';
            $msj = 'Hubo un problema al ejecutar. Por favor intente de nuevo';
        }
        return response()->json(array('message' => $msj, 'alert' => $alert), 200);
    }
}

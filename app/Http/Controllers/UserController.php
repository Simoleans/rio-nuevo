<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('User/Index', [
            'users' => User::orderBy('id', 'desc')
            ->where('name', 'LIKE' , "%$request->search%")
            ->where('id','!=',auth()->user()->id)
            ->active()
            ->simplePaginate(6)
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $request->except('password');

        $request->merge(['password' => bcrypt($request->password)]);
        
        $user = User::create($request->all());
        
        if($user){
            return redirect()->route('usuario.index')->with('message' , 'Usuario Creado');
        }else{
            return redirect()->route('usuario.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit(User $usuario)
    {
        return Inertia::render('User/Edit',[
            'user' => $usuario
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required',
            'rol' => 'required',
            'email' => 'required',
        ]);

        $usuario->update($request->all());

        if($usuario){
            return redirect()->route('usuario.index')->with('message' , 'Usuario Editado');
        }else{
            return redirect()->route('usuario.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function destroy(User $usuario)
    {

        if($usuario->update(['status' => 0])){
            return redirect()->route('usuario.index')->with('message' , 'Usuario Eliminado');
        }else{
            return redirect()->route('usuario.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
}

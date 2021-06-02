<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campo;
use Illuminate\Http\Request;

class CampoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Campo/Index', [
            'campos' => Campo::orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Campo/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $campo = Campo::create($request->all());
    
        if($campo){
            return redirect()->route('campo.index')->with('message' , 'Tipo de Cultivo Registrado');
        }else{
            return redirect()->route('campo.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function show(Campo $campo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function edit(Campo $campo)
    {
        return Inertia::render('Campo/Edit',[
            'campo' => $campo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campo $campo)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $campo->update($request->all());

        if($campo){
            return redirect()->route('campo.index')->with('message' , 'Campo Editado');
        }else{
            return redirect()->route('campo.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campo  $campo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campo $campo)
    {
        if($campo->delete()){
            return redirect()->route('campo.index')->with('message' , 'Campo Eliminado');
        }else{
            return redirect()->route('campo.index')->with('message' , '¡Error!');
        }
    }
}

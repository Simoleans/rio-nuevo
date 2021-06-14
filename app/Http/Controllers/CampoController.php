<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campo;
use App\Models\Productor;
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
            ->where('status',1)
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
        return Inertia::render('Campo/Create',[
            'productor' => Productor::orderBy('id', 'desc')->get(),
        ]);
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
            'localidad' => 'required',
            'productor_id' => 'required'
        ]);

        $campo = Campo::create($request->all());
    
        if($campo){
            return redirect()->route('campo.index')->with('message' , 'Tipo de Cultivo Registrado');
        }else{
            return redirect()->route('campo.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
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
            'campo' => $campo,
            'productor' => Productor::orderBy('id', 'desc')->get(),
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
            'localidad' => 'required',
            'productor_id' => 'required'
        ]);

        $campo->update($request->all());

        if($campo){
            return redirect()->route('campo.index')->with('message' , 'Campo Editado');
        }else{
            return redirect()->route('campo.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
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
        $campo->status = 0;

        if($campo->update()){
            return redirect()->route('campo.index')->with('message' , 'Campo Eliminado');
        }else{
            return redirect()->route('campo.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
}

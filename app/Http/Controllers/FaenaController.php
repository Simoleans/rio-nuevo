<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Faena;
use App\Models\Machine;
use App\Models\Productor;
use App\Models\Campo;
use App\Models\Temporada;
use Illuminate\Http\Request;

class FaenaController extends Controller
{
    
    public function index(Request $request)
    {
        return Inertia::render('Faena/Index', [
            'faenas' => Faena::orderBy('id', 'desc')
            ->where('maquina', 'LIKE' , "%$request->search%")
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
        return Inertia::render('Faena/Create',[
            'productor' => Productor::orderBy('id', 'desc')->get('razon_social'),
            'campo' => Campo::orderBy('id', 'desc')->get('nombre'),
            'maquina' => Machine::orderBy('id', 'desc')->get('nombre'),
            'temporada' => Temporada::orderBy('id', 'desc')->get('nombre'),
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
            'productor' => 'required',
            'campo' => 'required',
            'maquina' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'temporada' => 'required'
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $faena = Faena::create($request->all());
        
        if($faena){
            return redirect()->route('faena.index')->with('message' , 'Faena Registrada');
        }else{
            return redirect()->route('faena.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faena  $faena
     * @return \Illuminate\Http\Response
     */
    public function show(Faena $faena)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faena  $faena
     * @return \Illuminate\Http\Response
     */
    public function edit(Faena $faena)
    {
        return Inertia::render('Faena/Edit',[
            'faena' => $faena,
            'productor' => Productor::orderBy('id', 'desc')->get('razon_social'),
            'campo' => Campo::orderBy('id', 'desc')->get('nombre'),
            'maquina' => Machine::orderBy('id', 'desc')->get('nombre'),
            'temporada' => Temporada::orderBy('id', 'desc')->get('nombre'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faena  $faena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faena $faena)
    {
        $request->validate([
            'productor' => 'required',
            'campo' => 'required',
            'maquina' => 'required',
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
            'temporada' => 'required'
        ]);

        $faena->update($request->all());

        if($faena){
            return redirect()->route('faena.index')->with('message' , 'Faena Editada');
        }else{
            return redirect()->route('faena.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faena  $faena
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faena $faena)
    {
        if($faena->delete()){
            return redirect()->route('faena.index')->with('message' , 'Faena Eliminada');
        }else{
            return redirect()->route('faena.index')->with('message' , '¡Error!');
        }
    }

    public function disabledFaena(Faena $faena)
    {
        $faena->status = 0;

        if($faena->update()){
            return redirect()->route('faena.index')->with('message' , 'Faena Finalizada');
        }else{
            return redirect()->route('faena.index')->with('message' , '¡Error!');
        }
    }
}

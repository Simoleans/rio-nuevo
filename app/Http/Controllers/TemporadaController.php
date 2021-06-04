<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Temporada;
use Illuminate\Http\Request;

class TemporadaController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Temporada/Index', [
            'temporadas' => Temporada::orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Temporada/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'pais' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);
        
        $temporada = Temporada::create($request->all());
    
        if($temporada){
            return redirect()->route('temporada.index')->with('message' , 'Temporada Registrada');
        }else{
            return redirect()->route('temporada.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function show(Temporada $temporada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function edit(Temporada $temporada)
    {
        return Inertia::render('Temporada/Edit',[
            'temporada' => $temporada
        ]);
    }

    
    public function update(Request $request, Temporada $temporada)
    {
        $request->validate([
            'nombre' => 'required',
            'pais' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);

        $temporada->update($request->all());

        if($temporada){
            return redirect()->route('temporada.index')->with('message' , 'Temporada Editada');
        }else{
            return redirect()->route('temporada.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Temporada  $temporada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Temporada $temporada)
    {
        if($temporada->delete()){
            return redirect()->route('temporada.index')->with('message' , 'Temporada Eliminada');
        }else{
            return redirect()->route('temporada.index')->with('message' , '¡Error!');
        }
    }
}

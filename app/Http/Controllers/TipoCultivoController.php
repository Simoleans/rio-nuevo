<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\TipoCultivo;
use Illuminate\Http\Request;

class TipoCultivoController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('TipoCultivo/Index', [
            'tipo_cultivos' => TipoCultivo::orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }

    
    public function create()
    {
        return Inertia::render('TipoCultivo/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $tipoCultivo = TipoCultivo::create($request->all());
    
        if($tipoCultivo){
            return redirect()->route('tipoCultivo.index')->with('message' , 'Tipo de Cultivo Registrado');
        }else{
            return redirect()->route('tipoCultivo.index')->with('message' , '¡Error!');
        }
    }

    public function show(TipoCultivo $tipoCultivo)
    {
        //
    }

    
    public function edit(TipoCultivo $tipoCultivo)
    {
        return Inertia::render('TipoCultivo/Edit',[
            'tipo_cultivo' => $tipoCultivo
        ]);
    }

    
    public function update(Request $request, TipoCultivo $tipoCultivo)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $tipoCultivo->update($request->all());

        if($tipoCultivo){
            return redirect()->route('tipoCultivo.index')->with('message' , 'Tipo de Cultivo Editado');
        }else{
            return redirect()->route('tipoCultivo.index')->with('message' , '¡Error!');
        }
    }

    
    public function destroy(TipoCultivo $tipoCultivo)
    {
        if($tipoCultivo->delete()){
            return redirect()->route('tipoCultivo.index')->with('message' , 'Tipo de Cultivo Eliminado');
        }else{
            return redirect()->route('tipoCultivo.index')->with('message' , '¡Error!');
        }
    }
}

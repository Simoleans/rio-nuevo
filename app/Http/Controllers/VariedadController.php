<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Variedad;
use App\Models\TipoCultivo;
use Illuminate\Http\Request;

class VariedadController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Variedad/Index', [
            'variedads' => Variedad::orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }

    
    public function create()
    {
        return Inertia::render('Variedad/Create',[
            'tipo_cultivos' => TipoCultivo::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_cultivo' => 'required'
        ]);

        $variedad = Variedad::create($request->all());
    
        if($variedad){
            return redirect()->route('variedad.index')->with('message' , 'Variedad Registrada');
        }else{
            return redirect()->route('variedad.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function show(Variedad $variedad)
    {
        //
    }

    public function edit(Variedad $variedad)
    {
        return Inertia::render('Variedad/Edit',[
            'variedad' => $variedad,
            'tipo_cultivos' => TipoCultivo::all()
        ]);
    }

    public function update(Request $request, Variedad $variedad)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_cultivo' => 'required'
        ]);

        $variedad->update($request->all());

        if($variedad){
            return redirect()->route('variedad.index')->with('message' , 'Variedad Editada');
        }else{
            return redirect()->route('variedad.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function destroy(Variedad $variedad)
    {
        if($variedad->delete()){
            return redirect()->route('variedad.index')->with('message' , 'Variedad Eliminada');
        }else{
            return redirect()->route('variedad.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
}

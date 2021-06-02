<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Productor;
use Illuminate\Http\Request;

class ProductorController extends Controller
{
    
    public function index(Request $request)
    {
        return Inertia::render('Productors/Index', [
            'productors' => Productor::orderBy('id', 'desc')
            ->where('razon_social', 'LIKE' , "%$request->search%")
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
        return Inertia::render('Productors/Create');
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
                'rut' => 'required',
                'razon_social' => 'required',
                'localidad' => 'required',
                'region' => 'required',
                'comuna' => 'required',
                'direccion' => 'required',
                'nombre_responsable' => 'required',
                'email' => 'required',
                'telefono' => 'required',
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $productor = Productor::create($request->all());
        
        if($productor){
            return redirect()->route('productors.index')->with('message' , 'Productor Registrado');
        }else{
            return redirect()->route('productors.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productor  $productor
     * @return \Illuminate\Http\Response
     */
    public function show(Productor $productor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productor  $productor
     * @return \Illuminate\Http\Response
     */
    public function edit(Productor $productor)
    {
        return Inertia::render('Productors/Edit',[
            'productor' => $productor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productor  $productor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Productor $productor)
    {
        $request->validate([
            'rut' => 'required',
            'razon_social' => 'required',
            'localidad' => 'required',
            'region' => 'required',
            'comuna' => 'required',
            'direccion' => 'required',
            'nombre_responsable' => 'required',
            'email' => 'required',
            'telefono' => 'required',
        ]);

        $productor->update($request->all());

        if($productor){
            return redirect()->route('productors.index')->with('message' , 'Productor Editado');
        }else{
            return redirect()->route('productors.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productor  $productor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productor $productor)
    {
        if($productor->delete()){
            return redirect()->route('productors.index')->with('message' , 'Productor Eliminado');
        }else{
            return redirect()->route('productors.index')->with('message' , '¡Error!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Campo;
use App\Models\Machine;
use App\Models\Reporte;
use App\Models\Productor;
use App\Models\TipoCultivo;
use App\Models\Variedad;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Reporte/Index', [
            'reportes' => Reporte::orderBy('id', 'desc')
            ->where('maquina', 'LIKE' , "%$request->search%")
            ->orWhere('productor', 'LIKE' , "%$request->search%")
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
        return Inertia::render('Reporte/Create',[
            'productor' => Productor::orderBy('id', 'desc')->get('razon_social'),
            'campo' => Campo::orderBy('id', 'desc')->get('nombre'),
            'maquina' => Machine::orderBy('id', 'desc')->get('nombre'),
            'variedad' => Variedad::orderBy('id', 'desc')->get('nombre'),
            'tipo_cultivo' => TipoCultivo::orderBy('id', 'desc')->get('nombre'),
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
            'tipo_cultivo' => 'required',
            'variedad' => 'required',
            'hs_maquina' => 'required',
            'cuartel' => 'required',
            'tipo_bandeja' => 'required',
            'nro_bandeja' => 'required',
            'kg_totales' => 'required',
            'kg_teoricos' => 'required',
            'petroleo' => 'required',
            'hectareas' => 'required',
            'observacion' => 'required',
    ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $reporte = Reporte::create($request->all());
        
        if($reporte){
            return redirect()->route('reporte.index')->with('message' , '¡Reporte Creado Exitosamente!');
        }else{
            return redirect()->route('reporte.index')->with('message' , '¡Error!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function show(Reporte $reporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function edit(Reporte $reporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reporte  $reporte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reporte $reporte)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    
    public function index(Request $request)
    {
        return Inertia::render('Machine/Index', [
            'machines' => Machine::orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }


    public function create()
    {
        return Inertia::render('Machine/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:machines',
            'modelo' => 'required',
            'tipo' => 'required',
            'year' => 'required|integer',
            'serie' => 'required',
            'marca' => 'required'
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $machine = Machine::create($request->all());
        
        if($machine){
            return redirect()->route('machine.index', $machine->id)->with('message' , 'Maquina Creada');
        }else{
            return redirect()->route('machine.index', $machine->id)->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Machine $machine)
    {
        return Inertia::render('Machine/Edit',[
            'machine' => $machine
        ]);
    }

    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'nombre' => 'required',
            'modelo' => 'required',
            'tipo' => 'required',
            'year' => 'required|integer',
            'serie' => 'required',
            'marca' => 'required'
        ]);

        $machine->update($request->all());

        if($machine){
            return redirect()->route('machine.index')->with('message' , 'Maquina Editada');
        }else{
            return redirect()->route('machine.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function destroy(Machine $machine)
    {
        if($machine->delete()){
            return redirect()->route('machine.index')->with('message' , 'Maquina Eliminada');
        }else{
            return redirect()->route('machine.index')->with('class', 'bg-red-500')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
}

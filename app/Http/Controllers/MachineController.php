<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Machine;
use App\Models\Temporada;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    
    public function index(Request $request)
    {
        return Inertia::render('Machine/Index', [
            'machines' => Machine::with(['temporada'])->orderBy('id', 'desc')
            ->where('nombre', 'LIKE' , "%$request->search%")
            ->simplePaginate(6)
        ]);
    }


    public function create()
    {
        return Inertia::render('Machine/Create',[
            'temporadas' => Temporada::active()->orderBy('id', 'desc')->get(['id','nombre']),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:machines',
            'temporada_id' => 'required',
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
            'machine' => $machine,
            'temporadas' => Temporada::active()->orderBy('id', 'desc')->get(['id','nombre']),
        ]);
    }

    public function update(Request $request, Machine $machine)
    {
        $request->validate([
            'nombre' => 'required',
            'temporada_id' => 'required',
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
        $machine->status = 0;

        if($machine->update()){
            return redirect()->route('machine.index')->with('message' , 'Maquina Deshabilitada');
        }else{
            return redirect()->route('machine.index')->with('class', 'bg-red-500')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function enable(Machine $machine)
    {
        $machine->status = 1;

        if($machine->update()){
            return redirect()->route('machine.index')->with('message' , 'Maquina Habilitada');
        }else{
            return redirect()->route('machine.index')->with('class', 'bg-red-500')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }
}

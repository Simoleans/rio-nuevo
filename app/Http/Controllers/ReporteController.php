<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Campo;
use App\Models\Machine;
use App\Models\Reporte;
use App\Models\Variedad;
use App\Models\Productor;
use App\Models\Temporada;
use App\Models\TipoCultivo;
use Illuminate\Http\Request;
use App\Exports\ReporteExport;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now(); // todos los días de la semana.
        $startOfWeek = $date->startOfWeek()->subDay();

        for ($i = 0; $i < 7; $i++) {
            
            $weekDays[$i]['dates'] = $startOfWeek->addDay()->startOfDay()->copy()->format('Y-m-d');
            $weekDays[$i]['encriptedDate'] = encrypt($weekDays[$i]['dates']);
            $weekDays[$i]['dayName'] = $startOfWeek->locale('es')->dayName;
            if($i == 0){
                $weekDays[$i]['dff'] = true;
            }else{
                $weekDays[$i]['dff'] = Reporte::where('user_id',auth()->user()->id)->where('fecha', Carbon::parse($weekDays[$i]['dates'])->subDay()->format('Y-m-d'))->orWhere('fecha',$weekDays[$i]['dates'])->exists();
            }
            // if ($weekDays[$i]['dates'] == Carbon::now()->format('Y-m-d')) { //validar que sea hoy
            //     $weekDays[$i]['dff'] = Carbon::parse($weekDays[$i]['dates'])->addDay()->format('Y-m-d');
            // }
            $weekDays[$i]['totalKG'] = Reporte::totalKGforDate($weekDays[$i]['dates']);
            if ($weekDays[$i]['dates'] == Carbon::now()->format('Y-m-d')) { //validar que sea hoy
                $weekDays[$i]['todayValidation'] = true;
            }else{
                $weekDays[$i]['todayValidation'] = false;
            }

        }

        for ($i=0; $i < 7; $i++) { 
            $val[] = $weekDays[$i]['dates'];
        }

        // dd($val,$weekDays);

        $search = $request->search;
        return Inertia::render('Reporte/Index', [
            'reportes' => Reporte::with(['user','userAnular','maquina','productor','campo','tipo_cultivo','variedad'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('maquina', function($query) use ($search) {
                    $query->where('nombre', 'LIKE' , "%$search%");
                })
                ->OrWhereHas('productor', function($query) use ($search) {
                    $query->where('razon_social', 'LIKE' , "%$search%");
                });
            })->orderBy('id', 'desc')
            ->simplePaginate(6),
            'weeks' => $weekDays,
            'lastReportToUser' => Reporte::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->first(['id'])
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
            'productor' => Productor::orderBy('id', 'desc')->get(),
            'campo' => Campo::orderBy('id', 'desc')->get(),
            'maquina' => Machine::orderBy('id', 'desc')->active()->get(),
            'variedad' => Variedad::orderBy('id', 'desc')->get(),
            'tipo_cultivo' => TipoCultivo::orderBy('id', 'desc')->get(),
        ]);
    }

    public function cloneView(Reporte $reporte,$fecha)
    {
        
        if (!Gate::allows('clone-report', $reporte)) {
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡No tienes permisos de clonar este rpeorte!');
        }
        
        return Inertia::render('Reporte/Clone',[
            'productor' => Productor::orderBy('id', 'desc')->get(),
            'campo' => Campo::where('productor_id',$reporte->productor_id)->orderBy('id', 'desc')->get(),
            'maquina' => Machine::orderBy('id', 'desc')->active()->get(),
            'variedad' => Variedad::where('tipo_cultivo_id',$reporte->tipo_cultivo_id)->orderBy('id', 'desc')->get(),
            'tipo_cultivo' => TipoCultivo::orderBy('id', 'desc')->get(),
            'reporte' => $reporte,
            'fecha' => decrypt($fecha)
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
        
        $validateUsersReport = Reporte::where('user_id',auth()->user()->id)->whereDate('fecha', $request->fecha)->count();
        
        if($validateUsersReport >= env('REPORT_DIARY_USER') && auth()->user()->isOperador()){
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Solo puedes hacer 2 reportes diarios!');
        }

        $date = Carbon::now(); // todos los días de la semana.
        $startOfWeek = $date->startOfWeek()->subDay();

        for ($i = 0; $i < 7; $i++) {
            $weekDays[$i]['dates'] = $startOfWeek->addDay()->startOfDay()->copy()->format('Y-m-d');
        }

        
        $request->validate([
            'productor_id' => 'required',
            'campo_id' => 'required',
            'maquina_id' => 'required',
            'tipo_cultivo_id' => 'required',
            'variedad_id' => 'required',
            'tipo_bandeja' => 'required',
            'nro_bandeja' => 'required',
            'kg_totales' => 'required',
            'kg_teoricos' => 'required',
            'fecha' => 'required',
            'h_anterior' => 'required'
        ]);

        $query = Reporte::latest()->first();

        $hsAfter = $query->hs_maquina ?? 0;
        

        $request->merge(['user_id' => auth()->user()->id,'horas_delta' => $hsAfter - $request->hs_maquina]);

        $reporte = Reporte::create($request->all());
        
        if($reporte){
            return redirect()->route('reporte.index')->with('message' , '¡Reporte Creado Exitosamente!');
        }else{
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
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

    public function excelExport(Temporada $temporada)
    {
        $reporte = Reporte::dateBetween($temporada->fecha_inicio,$temporada->fecha_fin)->get();

        return Excel::download(new ReporteExport($reporte,$temporada), 'reportes'.date('dmyhs').'.xlsx');
    }

    public function disabledReporte(Reporte $reporte)
    {
        $reporte->status = 0;
        $reporte->user_anular = auth()->user()->id;

        if($reporte->update()){
            return redirect()->route('reporte.index')->with('message' , 'Reporte Anulado');
        }else{
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function enableReporte(Reporte $reporte)
    {
        $reporte->status = 1;

        if($reporte->update()){
            return redirect()->route('reporte.index')->with('message' , 'Reporte Habilitado');
        }else{
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function clone(Request $request)
    {

        $validateUsersReport = Reporte::where('user_id',auth()->user()->id)->whereDate('created_at', Carbon::today())->count();

        if($validateUsersReport >= env('REPORT_DIARY_USER')){
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Solo puedes hacer 2 reportes diarios!');
        }

        $request->merge(['user_id' => auth()->user()->id]);

        $reporte = Reporte::create($request->except(['id','status']));
        
        if($reporte){
            return redirect()->route('reporte.index')->with('message' , '¡Reporte Clonado Exitosamente!');
        }else{
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function createFechaReport($date)
    {

        return Inertia::render('Reporte/Create',[
            'productor' => Productor::orderBy('id', 'desc')->get(),
            'campo' => Campo::orderBy('id', 'desc')->get(),
            'maquina' => Machine::orderBy('id', 'desc')->active()->get(),
            'variedad' => Variedad::orderBy('id', 'desc')->get(),
            'tipo_cultivo' => TipoCultivo::orderBy('id', 'desc')->get(),
            'fecha' => decrypt($date)
        ]);
        
    }

    public function createReportNA($date)
    {

        return Inertia::render('Reporte/Void',[
            'fecha' => decrypt($date)
        ]);
        
    }

    public function storeReporteNA(Request $request)
    {
        
        $validateUsersReport = Reporte::where('user_id',auth()->user()->id)->whereDate('fecha', $request->fecha)->count();
        
        if($validateUsersReport >= env('REPORT_DIARY_USER') && auth()->user()->isOperador()){
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Solo puedes hacer 2 reportes diarios!');
        }
        
        $request->validate([
            'observacion' => 'required'
        ]);

        $request->merge(['user_id' => auth()->user()->id]);

        $reporte = Reporte::create($request->all());
        
        if($reporte){
            return redirect()->route('reporte.index')->with('message' , '¡Reporte Creado Exitosamente!');
        }else{
            return redirect()->route('reporte.index')->with('class', 'bg-red-500')->with('message' , '¡Error!');
        }
    }

    public function hAnterior($id){
        $maquina = Reporte::maquinaByUser($id)->latest('id')->first('hs_maquina');

        return response()->json($maquina);
    }

    public function productor_campo($id)
    {
        $campos = Campo::productores($id)->get(['id','nombre']);

        return response()->json($campos);
    }

    public function variedad_cultivo($id)
    {
        $variedad = Variedad::cultivo($id)->get(['id','nombre']);

        return response()->json($variedad);
    }
}

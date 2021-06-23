<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Reporte;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){
        
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
            $weekDays[$i]['totalKG'] = Reporte::totalKGforDate($weekDays[$i]['dates']);
            if ($weekDays[$i]['dates'] == Carbon::now()->format('Y-m-d')) { //validar que sea hoy
                $weekDays[$i]['todayValidation'] = true;
            }else{
                $weekDays[$i]['todayValidation'] = false;
            }

        }
        

        return Inertia::render('Dashboard',[
            'weeks' => $weekDays,
            'lastReportToUser' => Reporte::where('user_id',auth()->user()->id)->orderBy('created_at', 'desc')->first(['id'])
        ]);
    }
}
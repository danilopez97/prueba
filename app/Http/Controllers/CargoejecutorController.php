<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cargoejecutor;
use Illuminate\Support\Facades\DB;

class CargoejecutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
       //if(!$request->ajax()) return redirect('/');

       $buscar = $request->buscar;
       $criterio = $request->filtro;

       if ($buscar==''){
        $cargoejecutores = Cargoejecutor::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $cargoejecutores = Cargoejecutor::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
       //$cargoejecutores=Cargoejecutor::paginate(2);
        //return $cargoejecutores;
        return [
            'pagination' => [
                'total'        => $cargoejecutores->total(),
                'current_page' => $cargoejecutores->currentPage(),
                'per_page'     => $cargoejecutores->perPage(),
                'last_page'    => $cargoejecutores->lastPage(),
                'from'         => $cargoejecutores->firstItem(),
                'to'           => $cargoejecutores->lastItem(),
            ],
            'cargoejecutores' => $cargoejecutores
        ];
    }


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cargoejecutor=new Cargoejecutor();
        $cargoejecutor->nombre=$request->nombre;
        $cargoejecutor->estado='1';
        $cargoejecutor->save();
    }


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cargoejecutor=Cargoejecutor::findOrFail($request->id);
        $cargoejecutor->nombre=$request->nombre;
        $cargoejecutor->estado='1';
        $cargoejecutor->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cargoejecutor=Cargoejecutor::findOrFail($request->id);
        $cargoejecutor->estado='0';
        $cargoejecutor->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cargoejecutor=Cargoejecutor::findOrFail($request->id);
        $cargoejecutor->estado='1';
        $cargoejecutor->save();
    }

   

}

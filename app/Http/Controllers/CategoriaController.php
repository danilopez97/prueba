<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        //
       if(!$request->ajax()) return redirect('/');

       $buscar = $request->buscar;
       $criterio = $request->criterio;

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

    public function store(Request $request){
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->estado = true;
        $categoria->save();
    }

    public function update(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
    }

    public function desactivar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->estado = false;
        $categoria->save();
    }

    public function activar(Request $request){
        $categoria = Categoria::findOrFail($request->id);
        $categoria->estado = true;
        $categoria->save();
    }

}

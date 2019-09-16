<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editorial;
use Illuminate\Support\Facades\DB;

class EditorialController extends Controller
{
    public function index(Request $request){
        $filtro = $request->filtro;
        $buscar = $request->buscar;

        if($buscar == ''){
            
            $editoriales = DB::collection('editoriales')->orderBy('nombre', 'asc')->paginate(10);                
                
        }else{
            $editoriales = DB::collection('editoriales')->where($filtro, 'like', '%'. $buscar . '%')
                ->orderBy('nombre', 'asc')
                ->paginate(10);
        }
        $result = [
            'pagination' => [
                'total'        => $editoriales->total(),
                'current_page' => $editoriales->currentPage(),
                'per_page'     => $editoriales->perPage(),
                'last_page'    => $editoriales->lastPage(),
                'from'         => $editoriales->firstItem(),
                'to'           => $editoriales->lastItem(),
            ],
            'editoriales' => $editoriales
        ];
        return $result;
    }

    public function store(Request $request){
        $editorial = new Editorial();
        $editorial->nombre = $request->nombre;
        $editorial->descripcion = $request->descripcion;
        $editorial->estado = true;
        $editorial->save();
    }

    public function update(Request $request){
        $editorial = Editorial::findOrFail($request->id);
        $editorial->nombre = $request->nombre;
        $editorial->descripcion = $request->descripcion;
        $editorial->save();
    }

    public function desactivar(Request $request){
        $editorial = Editorial::findOrFail($request->id);
        $editorial->estado = false;
        $editorial->save();
    }

    public function activar(Request $request){
        $editorial = Editorial::findOrFail($request->id);
        $editorial->estado = true;
        $editorial->save();
    }
}

<?php

namespace TCG\Voyager\Http\Controllers;

use App\Models\Club;
use App\Models\Municipios;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function obtener_municipios(Request $request)
    {
        if ($request->ajax()) {
            try {
                $departamentoId = $request->departamento;
                $municipios = Municipios::where('departamento_id', $departamentoId)->get();
                return response()->json($municipios);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
    
    public function obtener_club(Request $request)
    {
        if ($request->ajax()) {
            try {
                $ligaId = $request->liga;
                $club = Club::where('liga', $ligaId)->get();
                return response()->json($club);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}

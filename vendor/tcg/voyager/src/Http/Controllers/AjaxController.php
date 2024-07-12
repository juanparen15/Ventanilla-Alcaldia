<?php

namespace TCG\Voyager\Http\Controllers;

use App\Models\ArmorumappTipopeticion;
use App\Models\Club;
use App\Models\EventoDetalleModalidadesArma;
use App\Models\ModalidadArma;
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
    public function getModalidadesByEvento($codigo_evento)
    {
        try {
            $modalidades = EventoDetalleModalidadesArma::with(['evento','tipoArma', 'tipoModalidadArma'])
                ->where('codigo_evento', $codigo_evento)
                ->get();
            return response()->json($modalidades);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function obtener_modalidades(Request $request)
    {
        if ($request->ajax()) {
            try {
                $tipoArmaIds = explode(',', $request->tipo_arma); // Convertir la cadena de tipo de arma en un array de IDs
                $modalidadArmas = ModalidadArma::whereIn('tipo_arma', $tipoArmaIds)->get();
                return response()->json($modalidadArmas);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}

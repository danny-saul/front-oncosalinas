<?php

namespace App\Http\Controllers;

use App\Models\Antecedentes_Estomatognatico_Paciente;
use App\Models\Antecedentes_Odonto_Familiar;
use App\Models\Antecedentes_Odonto_Personal;
use App\Models\Odonto_Antecedentes_Fam;
use App\Models\Odonto_Antecedentes_Per;
use App\Models\Odonto_Estomatognatico;
use App\Models\Paciente;
use Illuminate\Http\Request;

class OdontoPerAntecedenteController extends Controller
{
 
    public function guardar(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:paciente,id',
            'antecedentes' => 'required|array',
            'antecedentes.*.odonto_antecedentes_per_id' => 'required|exists:odonto_antecedentes_per,id',
            'antecedentes.*.respuesta' => 'required|in:Sí,No'
        ]);
    
        foreach ($request->antecedentes as $antecedente) {
            // Buscar si ya existe un antecedente para el paciente y ese tipo de antecedente
            $antecedenteExistente = Antecedentes_Odonto_Personal::where('paciente_id', $request->paciente_id)
                ->where('odonto_antecedentes_per_id', $antecedente['odonto_antecedentes_per_id'])
                ->first();
    
            if ($antecedenteExistente) {
                // Si existe, actualizar la respuesta
                $antecedenteExistente->respuesta = $antecedente['respuesta'];
                $antecedenteExistente->save();
            } else {
                // Si no existe, crear un nuevo antecedente
                $antecedenteOdonto = new Antecedentes_Odonto_Personal();
                $antecedenteOdonto->paciente_id = $request->paciente_id;
                $antecedenteOdonto->odonto_antecedentes_per_id = $antecedente['odonto_antecedentes_per_id'];
                $antecedenteOdonto->respuesta = $antecedente['respuesta'];
                $antecedenteOdonto->fecha = now();
                $antecedenteOdonto->estado = 'A'; // Estado "A" por defecto
                $antecedenteOdonto->save();
            }
        }
    
        return response()->json(['mensaje' => 'Antecedentes guardados con éxito.']);
    }
    
        

    // ✅ Recuperar antecedentes de un paciente
    public function obtenerAntecedentes($paciente_id)
    {
        // Validar que el paciente exista
        $paciente = Paciente::find($paciente_id);
        if (!$paciente) {
            return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
        }
    
        // Obtener los antecedentes guardados para ese paciente
        $antecedentes = Antecedentes_Odonto_Personal::where('paciente_id', $paciente_id)
            ->with('odonto_antecedentes_per') // Relación con la tabla de antecedentes
            ->get();
    
        // Devolver los antecedentes en formato JSON
        return response()->json([
            'mensaje' => 'Antecedentes obtenidos correctamente.',
            'antecedentes' => $antecedentes
        ]);
    }
    

/**ANTECEEDENTES FAMILIARES  */

public function guardarAFamiliares(Request $request)
{
    $request->validate([
        'paciente_id' => 'required|exists:paciente,id',
        'antecedentes' => 'required|array',
        'antecedentes.*.odonto_antecedentes_fam_id' => 'required|exists:odonto_antecedentes_fam,id',
        'antecedentes.*.respuesta' => 'required|in:Sí,No'
    ]);

    foreach ($request->antecedentes as $antecedente) {
        // Buscar si ya existe un antecedente para el paciente y ese tipo de antecedente
        $antecedenteExistenteF = Antecedentes_Odonto_Familiar::where('paciente_id', $request->paciente_id)
            ->where('odonto_antecedentes_fam_id', $antecedente['odonto_antecedentes_fam_id'])
            ->first();

        if ($antecedenteExistenteF) {
            // Si existe, actualizar la respuesta
            $antecedenteExistenteF->respuesta = $antecedente['respuesta'];
            $antecedenteExistenteF->save();
        } else {
            // Si no existe, crear un nuevo antecedente
            $antecedenteOdontoF = new Antecedentes_Odonto_Familiar();
            $antecedenteOdontoF->paciente_id = $request->paciente_id;
            $antecedenteOdontoF->odonto_antecedentes_fam_id = $antecedente['odonto_antecedentes_fam_id'];
            $antecedenteOdontoF->respuesta = $antecedente['respuesta'];
            $antecedenteOdontoF->fecha = now();
            $antecedenteOdontoF->estado = 'A'; // Estado "A" por defecto
            $antecedenteOdontoF->save();
        }
    }

    return response()->json(['mensaje' => 'Antecedentes guardados con éxito.']);
}




    // ✅ Recuperar antecedentes de un paciente
    public function obtenerAntecedentesFam($paciente_id)
    {
        // Validar que el paciente exista
        $paciente = Paciente::find($paciente_id);
        if (!$paciente) {
            return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
        }
    
        // Obtener los antecedentes guardados para ese paciente
        $antecedentes = Antecedentes_Odonto_Familiar::where('paciente_id', $paciente_id)
            ->with('odonto_antecedentes_fam') // Relación con la tabla de antecedentes
            ->get();
    
        // Devolver los antecedentes en formato JSON
        return response()->json([
            'mensaje' => 'Antecedentes obtenidos correctamente.',
            'antecedentes' => $antecedentes
        ]);
    }
    




    public function guardarAestomatognatico(Request $request)
    {
    $request->validate([
        'paciente_id' => 'required|exists:paciente,id',
        'antecedentes' => 'required|array',
        'antecedentes.*.odonto_estomatognatico_id' => 'required|exists:odonto_estomatognatico,id',
        'antecedentes.*.respuesta' => 'required|in:Sí,No'
    ]);

    foreach ($request->antecedentes as $antecedente) {
        // Buscar si ya existe un antecedente para el paciente y ese tipo de antecedente
        $antecedenteExistenteEsto = Antecedentes_Estomatognatico_Paciente::where('paciente_id', $request->paciente_id)
            ->where('odonto_estomatognatico_id', $antecedente['odonto_estomatognatico_id'])
            ->first();

        if ($antecedenteExistenteEsto) {
            // Si existe, actualizar la respuesta
            $antecedenteExistenteEsto->respuesta = $antecedente['respuesta'];
            $antecedenteExistenteEsto->save();
        } else {
            // Si no existe, crear un nuevo antecedente
            $antecedenteOdontoF = new Antecedentes_Estomatognatico_Paciente();
            $antecedenteOdontoF->paciente_id = $request->paciente_id;
            $antecedenteOdontoF->odonto_estomatognatico_id = $antecedente['odonto_estomatognatico_id'];
            $antecedenteOdontoF->respuesta = $antecedente['respuesta'];
            $antecedenteOdontoF->fecha = now();
            $antecedenteOdontoF->estado = 'A'; // Estado "A" por defecto
            $antecedenteOdontoF->save();
        }
    }

    return response()->json(['mensaje' => 'Antecedentes guardados con éxito.']);
}





    // ✅ Recuperar antecedentes de un paciente
    public function obtenerAntecedentesEsto($paciente_id)
    {
        // Validar que el paciente exista
        $paciente = Paciente::find($paciente_id);
        if (!$paciente) {
            return response()->json(['mensaje' => 'Paciente no encontrado.'], 404);
        }
    
        // Obtener los antecedentes guardados para ese paciente
        $antecedentes = Antecedentes_Estomatognatico_Paciente::where('paciente_id', $paciente_id)
            ->with('odonto_estomatognatico') // Relación con la tabla de antecedentes
            ->get();
    
        // Devolver los antecedentes en formato JSON
        return response()->json([
            'mensaje' => 'Antecedentes obtenidos correctamente.',
            'antecedentes' => $antecedentes
        ]);
    }
    















 
  
}
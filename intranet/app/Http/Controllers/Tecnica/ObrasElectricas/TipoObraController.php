<?php

namespace App\Http\Controllers\Tecnica\ObrasElectricas;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreTipoDeObraRequest;
use App\Http\Requests\UpdateTipoDeObraRequest;
use App\Models\Tecnica\ObrasElectricas\TipoObra;

class TipoObraController extends Controller
{
    public function index()
    {
        $tiposObras = TipoObra::all();

        return view('tecnica.obrasElectricas.tiposDeObras.index', compact('tiposObras'));
    }

    public function create()
    {
        return view('tecnica.obrasElectricas.tiposDeObras.create');
    }

    public function store(StoreTipoDeObraRequest $request)
    {
        try {
            TipoObra::create([
                'TOE_ABREVIATURA' => $request->input('abreviatura'),
                'TOE_DESCRIPCION' => $request->input('descripcion'),
                'TOE_INTERNO' => $request->has('interno') ? 'S' : 'N'
            ]);

            return redirect()->route('tipos-obras')->with('status', 'Tipo de Obra Creado Correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->withErrors(['abreviatura' => 'La abreviatura ya existe.']);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error inesperado.']);
        }
    }

    public function edit(TipoObra $tipoObra)
    {
        return view('tecnica.obrasElectricas.tiposDeObras.edit', compact('tipoObra'));
    }

    public function update(UpdateTipoDeObraRequest $request, TipoObra $tipoObra)
    {
        try {
            $data = [
                'TOE_ABREVIATURA' => $request->input('abreviatura'),
                'TOE_DESCRIPCION' => $request->input('descripcion'),
                'TOE_INTERNO' => $request->has('interno') ? 'S' : 'N',
            ];
            $tipoObra->update($data);

            return redirect()->route('tipos-obras')->with('status', 'Tipo de Obra Actualizada Correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()->back()->withInput()->withErrors(['abreviatura' => 'La abreviatura ya existe.']);
            }

            return redirect()->back()->withInput()->withErrors(['error' => 'Ocurrió un error inesperado.']);
        }
    }

    public function destroy(TipoObra $tipoObra)
    {
        $tipoObra->delete();
        return redirect()->route('tipos-obras')->with('status', 'Tipo de Obra Eliminada correctamente!');
    }
}

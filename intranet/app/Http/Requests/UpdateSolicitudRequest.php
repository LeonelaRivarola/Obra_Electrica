<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSolicitudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cuit' => 'required|string|max:15',
            'apellido' => 'required|string|max:30',
            'nombre' => 'required|string|max:30',
            'calle' => 'required|string|max:20',
            'altura' => 'required|string|max:6',
            'piso' => 'nullable|string|max:3',
            'dpto' => 'nullable|string|max:3',
            'localidad' => 'required|integer',
            'celular' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'tipo' => 'required|integer',
            'subestacion' => 'nullable|string|max:6',
            'asociado' => 'nullable|integer',
            'path' => 'nullable|string|max:255'
        ];
    }
}

<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoObra extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.TIPO_OBRA_ELECTRICA';
    protected $primaryKey = 'TOE_ID';
    public $timestamps = false;

    protected $fillable = [
        'TOE_ABREVIATURA',
        'TOE_DESCRIPCION',
        'TOE_INTERNO'
    ];

    public function setTOEABREVIATURAAttribute($value)
    {
        $this->attributes['TOE_ABREVIATURA'] = strtoupper(trim($value));
    }

    public function setTOEDESCRIPCIONAttribute($value)
    {
        $this->attributes['TOE_DESCRIPCION'] = strtoupper(trim($value));
    }

    public function tipoObra()
    {
        return $this->belongsTo(TipoObra::class, 'SOE_TIPO_ID', 'TOE_ID');
    }
}

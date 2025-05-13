<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.OBSERVACION_SOLICITUD_OBRA';
    protected $primaryKey = 'OSO_ID';
    public $timestamps = false;

    protected $fillable = [
        'OSO_DESCRIPCION',
    ];

    public function solicitudObservaciones()
    {
        return $this->hasMany(SolicitudObservacion::class, 'SOB_OBSERVACION_ID', 'OSO_ID');
    }
}

<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudObservacion extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.SOLICITUD_OBSERVACION';
    protected $primaryKey = 'SOB_ID';
    public $timestamps = false;

    protected $fillable = [
        'SOB_SES_ID',
        'SOB_OBSERVACION_ID',
        'SOB_USUARIO',
        'SOB_FECHA'
    ];

    public function getSobFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function solicitudEstado()
    {
        return $this->belongsTo(SolicitudEstado::class, 'SOB_SES_ID', 'SES_ID');
    }

    public function observacion()
    {
        return $this->belongsTo(Observacion::class, 'SOB_OBSERVACION_ID', 'OSO_ID');
    }
}

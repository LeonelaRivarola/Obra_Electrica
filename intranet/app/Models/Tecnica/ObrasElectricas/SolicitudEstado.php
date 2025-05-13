<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudEstado extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.SOLICITUD_ESTADO';
    protected $primaryKey = 'SES_ID';
    public $timestamps = false;

    protected $fillable = [
        'SES_SOLICITUD_ID',
        'SES_ESTADO_ID',
        'SES_USUARIO',
        'SES_FECHA'
    ];

    public function getSesFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'SES_SOLICITUD_ID', 'SOE_ID');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'SES_ESTADO_ID', 'ESO_ID');
    }

    public static function ultimoEstado($soe_id)
    {
        return self::where('SES_SOLICITUD_ID', $soe_id)
            ->orderBy('SES_FECHA', 'desc')
            ->first();
    }

    public function observaciones()
    {
        return $this->hasMany(SolicitudObservacion::class, 'SOB_SES_ID', 'SES_ID');
    }

    public function ultimaObservacion()
    {
        return $this->hasOne(SolicitudObservacion::class, 'SOB_SES_ID', 'SES_ID')
            ->latestOfMany('SOB_FECHA');
    }
}

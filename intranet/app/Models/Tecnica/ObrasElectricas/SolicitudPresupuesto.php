<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPresupuesto extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.SOLICITUD_PRESUPUESTO';
    protected $primaryKey = 'SPR_ID';
    public $timestamps = false;

    protected $fillable = [
        'SPR_SOLICITUD_ID',
        'SPR_PRESUPUESTO_ID',
        'SPR_USUARIO',
        'SPR_FECHA'
    ];

    public function getSprFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'SPR_SOLICITUD_ID', 'SOE_ID');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'SPR_PRESUPUESTO_ID', 'PSO_ID');
    }

    public static function ultimoPresupuesto($pso_id)
    {
        return self::where('SPR_PRESUPUESTO_ID', $pso_id)
            ->orderBy('SPR_FECHA', 'desc')
            ->first();
    }
}

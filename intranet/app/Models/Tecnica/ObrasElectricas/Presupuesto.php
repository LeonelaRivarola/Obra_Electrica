<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.PRESUPUESTO_SOLICITUD_OBRA';
    protected $primaryKey = 'PSO_ID';
    public $timestamps = false;

    protected $fillable = [
        'PSO_NOTIFICA',
        'PSO_VECES',
        'PSO_USU_NOTIFICA',
        'PSO_F_NOTIFICA',
        'PSO_ACEPTA',
        'PSO_F_ACEPTA',
        'PSO_USU_ACEPTA',
        'PSO_PATH',
    ];

    public function getPsoFAceptaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getPsoFNotificaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function solicitudPresupuestos()
    {
        return $this->hasMany(solicitudPresupuesto::class, 'SPR_PRESUPUESTO_ID', 'PSO_ID');
    }
}

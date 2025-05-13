<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSolicitud extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.EMAIL_SOLICITUD_OBRA';
    protected $primaryKey = 'EMSO_ID';
    public $timestamps = false;

    protected $fillable = [
        'EMSO_SOLICITUD_ID',
        'EMSO_ORIGEN',
        'EMSO_DESTINO',
        'EMSO_ASUNTO',
        'EMSO_MENSAJE',
        'EMSO_ADJUNTO',
        'EMSO_USUARIO',
        'EMSO_FECHA'
    ];

    public function getEmsoFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'EMSO_SOLICITUD_ID', 'SOE_ID');
    }
}

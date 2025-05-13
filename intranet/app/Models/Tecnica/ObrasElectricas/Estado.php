<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.ESTADO_SOLICITUD_OBRA';
    protected $primaryKey = 'ESO_ID';
    public $timestamps = false;

    protected $fillable = [
        'ESO_DESCRIPCION',
    ];

    public function solicitudesEstados()
    {
        return $this->hasMany(SolicitudEstado::class, 'SES_ESTADO_ID', 'ESO_ID');
    }
}

<?php

namespace App\Models\Tecnica\ObrasElectricas;

use Carbon\Carbon;
use App\Models\Localidad;
use App\Models\Tecnica\ObrasElectricas\SolicitudEstado;
use App\Models\Tecnica\ObrasElectricas\SolicitudObservacion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $connection = 'ALUM';
    protected $table = 'ALUM.dbo.SOLICITUD_OBRA_ELECTRICA';
    protected $primaryKey = 'SOE_ID';
    public $timestamps = false;

    protected $fillable = [
        'SOE_CUIT',
        'SOE_APELLIDO',
        'SOE_NOMBRE',
        'SOE_CALLE',
        'SOE_ALTURA',
        'SOE_PISO',
        'SOE_DPTO',
        'SOE_LOCALIDAD_ID',
        'SOE_CELULAR',
        'SOE_EMAIL',
        'SOE_TIPO_ID',
        'SOE_SUBESTACION',
        'SOE_ASOCIADO',
        'SOE_SUMINISTRO',
        'SOE_OBRA',
        'SOE_USUARIO',
        'SOE_FECHA',
        'SOE_UPDATE',
        'SOE_PATH',
    ];

    public function getRouteKeyName()
    {
        return 'SOE_ID';
    }

    public function setSOEAPELLIDOAttribute($value)
    {
        $this->attributes['SOE_APELLIDO'] = strtoupper(trim($value));
    }

    public function setSOENOMBREAttribute($value)
    {
        $this->attributes['SOE_NOMBRE'] = strtoupper(trim($value));
    }

    public function setSOECALLEAttribute($value)
    {
        $this->attributes['SOE_CALLE'] = strtoupper(trim($value));
    }

    public function setSOEPISOAttribute($value)
    {
        $this->attributes['SOE_PISO'] = strtoupper(trim($value));
    }

    public function setSOEDPTOAttribute($value)
    {
        $this->attributes['SOE_DPTO'] = strtoupper(trim($value));
    }

    public function getSoeFechaAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function getSoeUpdateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d-m-Y') : null;
    }

    public function estados()
    {
        return $this->hasMany(SolicitudEstado::class, 'SES_SOLICITUD_ID', 'SOE_ID');
    }

    public function ultimoEstado()
    {
        return $this->hasOne(SolicitudEstado::class, 'SES_SOLICITUD_ID', 'SOE_ID')
            ->latest('SES_FECHA');
    }

    public function tipos()
    {
        return $this->hasOne(TipoObra::class, 'TOE_ID', 'SOE_TIPO_ID');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'SOE_LOCALIDAD_ID', 'LOC_ID');
    }

    public function presupuestos()
    {
        return $this->hasMany(SolicitudPresupuesto::class, 'SPR_SOLICITUD_ID', 'SOE_ID');
    }

    public function ultimoPresupuesto()
    {
        return $this->hasOne(SolicitudPresupuesto::class, 'SPR_SOLICITUD_ID', 'SOE_ID')
            ->latest('SPR_FECHA');
    }

    public function observaciones()
    {
        return $this->hasManyThrough(
            Observacion::class,
            SolicitudObservacion::class,
            'SOB_SES_ID',
            'OSO_ID',
            'SOE_ID',
            'SOB_OBSERVACION_ID'
        );
    }

    public function presupuestosDirectos()
    {
        return $this->hasManyThrough(
            Presupuesto::class,
            SolicitudPresupuesto::class,
            'SPR_SOLICITUD_ID',
            'PSO_ID',
            'SOE_ID',
            'SPR_PRESUPUESTO_ID'
        );
    }

    public function emailSolicitudes()
    {
        return $this->hasMany(EmailSolicitud::class, 'EMSO_SOLICITUD_ID', 'SOE_ID');
    }
}

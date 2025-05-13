<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UsuarioCorpico extends Authenticatable
{
    protected $connection = 'GeaSeguridad';
    protected $table = 'GeaSeguridad_Corpico.dbo.USUARIOS';
    protected $primaryKey = 'USU_CODIGO';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getAuthPassword()
    {
        return $this->USU_PASSWORD;
    }
}

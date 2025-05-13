<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $connection = 'GeaCorpico';
    protected $table = 'GeaCorpico.dbo.LOCALIDAD';
    protected $primaryKey = 'LOC_ID';
    public $timestamps = false;
}

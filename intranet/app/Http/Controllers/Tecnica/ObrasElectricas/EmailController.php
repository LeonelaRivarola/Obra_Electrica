<?php

namespace App\Http\Controllers\Tecnica\ObrasElectricas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnica\ObrasElectricas\EmailSolicitud;

class EmailController extends Controller
{
    public function index()
    {
        $emails = EmailSolicitud::paginate(50);

        return view('tecnica.obrasElectricas.emails.index', compact('emails'));
    }

    public function show(EmailSolicitud $email)
    {
        $email->load('solicitud');

        return view('tecnica.obrasElectricas.emails.show', compact('email'));
    }
}

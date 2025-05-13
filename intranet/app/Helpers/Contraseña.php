<?php

namespace App\Helpers;

class Contraseña
{
    public static function codificar($pass)
    {
        $wEsimPar = 1;
        $n = 1;
        $i = strlen($pass);
        $cPass = "";
        while ($i != 0) {
            $sCaracter = substr($pass, $i - 1, 1);
            if ($wEsimPar == 1) {
                $sCaracter = chr(ord($sCaracter) + $n);
                if ($sCaracter == chr(39) || $sCaracter == '|') {
                    $sCaracter = chr(ord($sCaracter) + 2);
                }
                $wEsimPar = 0;
            } else {
                $sCaracter = chr(ord($sCaracter) - $n);
                if ($sCaracter == chr(39) || $sCaracter == '|') {
                    $sCaracter = chr(ord($sCaracter) + 2);
                }
                $wEsimPar = 1;
            }
            $cPass = $cPass . $sCaracter;
            $i = $i - 1;
            $n = $n + 1;
        }
        return $cPass;
    }

    public static function decodificar($pass)
    {
        $n = strlen($pass);
        $wEsimPar = $n % 2 == 0 ? 1 : 0;
        $i = strlen($pass);
        $dPass = "";
        while ($i != 0) {
            $sCaracter = substr($pass, $i - 1, 1);
            if ($wEsimPar) {
                $sCaracter = chr(ord($sCaracter) + $n);
                if ($sCaracter == chr(39) || $sCaracter == '|') {
                    $sCaracter = chr(ord($sCaracter) - $n);
                }
                $wEsimPar = false;
            } else {
                $sCaracter = chr(ord($sCaracter) - $n);
                if ($sCaracter == chr(39) || $sCaracter == '|') {
                    $sCaracter = chr(ord($sCaracter) - $n);
                }
                $wEsimPar = true;
            }
            $dPass = $dPass . $sCaracter;
            $i = $i - 1;
            $n = $n - 1;
        }
        return $dPass;
    }
}

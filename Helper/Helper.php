<?php

class Helper
{

    public static function valorNumerico($datos)
    {
        return ctype_digit($datos);
    }

    public static function soloAlfabetico($datos)
    {
        return ctype_alpha($datos);
    }
}

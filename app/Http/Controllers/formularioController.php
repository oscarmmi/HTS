<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class formularioController extends Controller
{
    public function guardarDatos(Request $request){ 
        $errores=array(); 
        if(!$request->nombre || !is_string($request->nombre) || $request->nombre==""){
            $errores[]="- El nombre no puede estar vacio";
        }      
        if(!$request->apellidos || !is_string($request->apellidos)  || $request->apellidos==""){
            $errores[]="- Los apellidos no pueden estar vacios";
        }      
        if(!$request->edad || $request->edad=="" || !is_numeric($request->edad) || (intval($request->edad)<=0 || intval($request->edad)>100)){
            $errores[]="- La edad ingresada no es valida";
        }     
        if(!$request->profesion || !is_string($request->profesion)   || $request->profesion==""){
            $errores[]="- La profesion no puede estar vacia";
        }
        if(count($errores)){
            throw ValidationException::withMessages($errores);
        }
        var_dump($request->nombre, $request->apellidos, $request->edad, $request->profesion);
    }
}

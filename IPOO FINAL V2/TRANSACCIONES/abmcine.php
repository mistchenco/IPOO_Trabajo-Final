<?php

class abmcine
{

    public function agregarCine($datosFuncion)
    {

        $objCine = new Cine();
        $objCine->cargar($datosFuncion);
        $objCine->insertar();

        return $objCine;
    }


    public function seleccionarCine($id_funcion)
    {

        $objCine = new Cine();
        $respuesta=$objCine->Buscar($id_funcion);
        if(!$respuesta){
            $objCine=null;
        }
        return $objCine;
    }
    public function modificarCine($objCine, $nombre, $precio)
    {


        $objCine->setNombre_funcion($nombre);
        $objCine->setPrecio($precio);

        $respuesta = $objCine->modificar();
        return $respuesta;
    }

    public function eliminarCine($objCine){

        $respuesta=$objCine->eliminar();
        return $respuesta;


    }



}

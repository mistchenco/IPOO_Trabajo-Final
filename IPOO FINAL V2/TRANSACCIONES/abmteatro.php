<?php

class abmteatro
{
    // recibe un array asociativo con los datos de un teatro
    public function agregarTeatro($datosTeatro)
    {
        //Creo una nueva instancia del teatro
        $objTeatro = new Teatro();
       
        //cargo los datos en ese objeto y los seteo
        $objTeatro->cargar($datosTeatro);
        
        //Inserto los datos en la BD
        $objTeatro->insertar();
        
        return $objTeatro;
    }

    public function seleccionarTeatro($id_teatro)
    {
        $objTeatro = new Teatro();
        $respuesta=$objTeatro->Buscar($id_teatro);
        
        if(!$respuesta){
            $objTeatro=null;
    }
        
    return $objTeatro;
    }


    public function eliminarTeatro($objTeatro)
    {

        $coleccionfunciones = $objTeatro->getColeccionfunciones();
        $i = 0;
        $respuesta = true;

        while ($i < count($coleccionfunciones) && $respuesta) {
            $respuesta = $coleccionfunciones[$i]->eliminar();

            $i++;
        }

        if ($respuesta) {
            $respuesta = $objTeatro->eliminar();
        }
        return $respuesta;
    }

    public function modificarTeatro($objTeatro, $nombre, $direccion)
    {
        $objTeatro->setNombre_teatro($nombre);
        $objTeatro->setDireccion($direccion);
        $respuesta = $objTeatro->modificar();
        return $respuesta;
    }
}

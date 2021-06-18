<?php
class abmMusical
{
    public function agregarMusical($datosFuncion)
    {

        $objMusical = new Musical();
        $objMusical->cargar($datosFuncion);
        $objMusical->insertar();
        
        return $objMusical;
    }

    public function seleccionarMusical($id_funcion)
    {

        $objMusical = new Musical();
        $respuesta=$objMusical->Buscar($id_funcion);
        if(!$respuesta){
        $objMusical=null;
        }
        return $objMusical;
    }
    
    public function modificarMusical($objMusical, $nombre, $precio)
    {


        $objMusical->setNombre_funcion($nombre);
        $objMusical->setPrecio($precio);

        $respuesta = $objMusical->modificar();
        return $respuesta;
    }

    public function eliminarMusical($objMusical){

        $respuesta=$objMusical->eliminar();
        return $respuesta;


    }



}

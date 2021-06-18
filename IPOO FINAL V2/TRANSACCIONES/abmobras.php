<?php
class abmObra{
public function agregarObra($datosFuncion)
    {

        $objObra = new ObrasTeatro();
        $objObra->cargar($datosFuncion);
        $objObra->insertar();
        
        return $objObra;
    }
    public function seleccionarObra($id_funcion){
      
        $objObra=new ObrasTeatro();
        $objObra->Buscar($id_funcion);
       
        return $objObra;
    }
    public function modificarObra($objObra, $nombre, $precio)
    {
        
        
        $objObra->setNombre_funcion($nombre);
        $objObra->setPrecio($precio);
       
        $respuesta = $objObra->modificar();
        return $respuesta;
    }

    public function eliminarObra($objObra){

        $respuesta=$objObra->eliminar();
        return $respuesta;


    }



}
<?php
include_once 'Teatro.php';
include_once 'BaseDatos.php';

class Funcion{
    private $id_funcion;
    private $nombre_funcion;
    private $horario_inicio;
    private $duracion;
    private $precio;
    //Modificacion realizada!!
    private $objTeatro;
  
    private $mensaje_operacion;



public function __construct()
{
    $this->id_funcion = 0;
    $this->nombre_funcion = "";
    $this->horario_inicio = "";
    $this->duracion = "";
    $this->precio = "";
    $this->objTeatro = "";
}

    public function getId_funcion()
    {
        return $this->id_funcion;
    }

 
    public function setId_funcion($id_funcion)
    {
        $this->id_funcion = $id_funcion;

        return $this;
    }


    public function getNombre_funcion()
    {
        return $this->nombre_funcion;
    }

 
    public function setNombre_funcion($nombre_funcion)
    {
        $this->nombre_funcion = $nombre_funcion;

        return $this;
    }

 
    public function getHorario_inicio()
    {
        return $this->horario_inicio;
    }

   
    public function setHorario_inicio($horario_inicio)
    {
        $this->horario_inicio = $horario_inicio;

        return $this;
    }

 
    public function getDuracion()
    {
        return $this->duracion;
    }

    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

   
    public function getPrecio()
    {
        return $this->precio;
    }

  
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

  
    public function getObjTeatro()
    {
        return $this->objTeatro;
    }

  
    public function setObjTeatro($objTeatro)
    {
        $this->objTeatro = $objTeatro;

        return $this;
    }


    public function getMensaje_operacion()
    {
        return $this->mensaje_operacion;
    }

  
    public function setMensaje_operacion($mensaje_operacion)
    {
        $this->mensaje_operacion = $mensaje_operacion;

        return $this;
    }

    public function cargar($datosFuncion)
    {
        $this->setId_funcion($datosFuncion['id_funcion']);
        $this->setNombre_Funcion($datosFuncion['nombre_funcion']);
        $this->setHorario_Inicio($datosFuncion['hora_inicio']);
        $this->setDuracion($datosFuncion['duracion']);
        $this->setPrecio($datosFuncion['precio']);
        $this->setObjTeatro($datosFuncion['objTeatro']);
       
        
    }


   
    public function Buscar($id_funcion)
    {
        
        $base = new BaseDatos();
        $consultaFuncion = "Select * from funcion where id_funcion=".$id_funcion;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaFuncion)) {
                if ($row2 = $base->Registro()) {
                    $this->setId_funcion($id_funcion);
                    $this->setNombre_Funcion($row2['nombre_funcion']);
                    $this->setHorario_Inicio($row2['horario_inicio']);
                    $this->setDuracion($row2['duracion']);
                    $this->setPrecio($row2['precio']);
                  
                    $objTeatro = new Teatro();
                    $objTeatro->Buscar($row2['id_teatro']);
                    $this->setObjTeatro($objTeatro); 
                    $resp= true;
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $resp;
    }

   //Modificacion Realizada
    public function listar($condicion)
    {
      
        $base = new BaseDatos();
        $consultaFuncion = "Select * from funcion ";
        if ($condicion != "") {
            $consultaFuncion = $consultaFuncion . ' where ' . $condicion;
        }
        $consultaFuncion .= " order by nombre_funcion ";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaFuncion)) {
                $coleccionFunciones = array();
                while ($row2 = $base->Registro()) {
                   
                    $objFuncion = new Funcion();
                    $objFuncion->Buscar($row2['id_funcion']);
                   
                    array_push($coleccionFunciones, $objFuncion);
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $coleccionFunciones;
    }

 
    public function insertar()
    {
        
        //Modificacion Realizada!
        $objTeatro=$this->getObjTeatro();
        $id_teatro=$objTeatro->getId_teatro();
    
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO funcion( nombre_funcion, horario_inicio, duracion, precio,id_teatro)
				VALUES ('".$this->getNombre_Funcion()."','".$this->getHorario_inicio()."',".$this->getDuracion().",".$this->getPrecio().",'".$id_teatro."')";
            
        if ($base->Iniciar()) {
           
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setId_funcion($id);
                $resp = true;
            }
        }
         else {
            $this->setMensaje_operacion($base->getError());
        }
       
        return $resp;
    }

    public function modificar()
    {
  
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica="UPDATE funcion SET nombre_funcion='".$this->getNombre_funcion()."',precio=". $this->getPrecio().
         " WHERE id_funcion=".$this->getId_funcion();
        
         if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $resp;
    }

 
  public function eliminar()
  {
      $base = new BaseDatos();
      $resp = false;
      if ($base->Iniciar()) {
          $consultaBorra = "DELETE FROM funcion WHERE id_funcion=" . $this->getId_funcion();
          if ($base->Ejecutar($consultaBorra)) {
           
              $resp = true;
          } else {
              $this->setMensaje_operacion($base->getError());
          }
      } else {
          $this->setMensaje_operacion($base->getError());
      }
      
      return $resp;
  }

public function darCostos(){
  $costo= $this->getPrecio();
    return $costo;
}

public function __toString()
{
    return "Nombre Funcion: ".$this->getNombre_funcion()."\n
            Horario Inicio: ".$this->getHorario_inicio()."\n
            Duracion: ".$this->getDuracion()."\n
            Precio: ".$this->getPrecio()."\n
            id Funcion : ".$this->getId_funcion()."\n
            Id teatro: ".$this->getObjTeatro()."\n";
}


}






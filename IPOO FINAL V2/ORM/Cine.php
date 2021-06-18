<?php
include_once 'Funcion.php';
include_once "BaseDatos.php";

class Cine extends Funcion
{

   
    private $genero;
    private $origen;
    private $mensaje_operacion;
    
    public function __construct()
    {
        parent::__construct();
        $this->genero = "";
        $this->origen = "";
    }

    
    public function cargar($datosFuncion)
    {
        parent::cargar($datosFuncion);
        
        $this->setGenero($datosFuncion['genero']);
        $this->setOrigen($datosFuncion['origen']);
    }

    public function getGenero()
    {
        return $this->genero;
    }

    public function getOrigen()
    {
        return $this->origen;
    }

   
    public function setGenero($genero)
    {
        $this->genero = $genero;
    }

    public function setOrigen($origen)
    {
        $this->origen = $origen;
    }


    public function __toString()
    {
        $cadena = parent::__toString() . " Genero: " . $this->getGenero() . "\n Pais de origen: " . $this->getOrigen() . "\n";
        return $cadena;
    }

 
    public function darCostos()
    {
        $precio= parent::darCostos();
        $precioFinal= $precio+ ($precio*0.65);
        return $precioFinal;
    }

   

    /**
     * Recupera los datos de un teatro por id
     *
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $consulta = "Select * from cine where id=".$id;
        $resp = false;
        
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::Buscar($id);
                    $this->setGenero($row2['genero']);
                    $this->setOrigen($row2['origen']);
                    $resp = true;
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $resp;
    }

  
    public function listar($condicion)
    {
      $arreglo=array();
        $base = new BaseDatos();
        $consulta = "SELECT * FROM cine ";
        if ($condicion != "") {
            $consulta = $consulta . ' where ' . $condicion;
        }
        $consulta .= " order by genero ";
       
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo = array();
                while ($row2 = $base->Registro()) {
                    $obj = new Cine();
                    $obj->Buscar($row2['id']);
                    array_push($arreglo, $obj);
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
       
        return $arreglo;
    }

   
    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
      
        if (parent::insertar()) {
            
           $consultaInsertar = "INSERT INTO cine(id, genero, origen)
			VALUES (" . parent::getId_funcion() . ",'" . $this->getGenero() . "','" . $this->getOrigen() . "')";
            
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }
        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
       
        if (parent::modificar()) {
            $consultaModifica = "UPDATE cine SET genero='" . $this->getGenero() . "',origen='" . $this->getOrigen() . "' WHERE id=" . parent::getId_funcion();
          
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModifica)) {
                    $resp = true;
                } else {
                    $this->setmensajeoperacion($base->getError());
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }

        return $resp;
    }

  
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM cine WHERE id=" . parent::getId_funcion();
            if ($base->Ejecutar($consultaBorra)) {
                if (parent::eliminar()) {
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
}
?>
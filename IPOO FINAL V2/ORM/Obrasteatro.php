<?php
include_once 'Funcion.php';
include_once "BaseDatos.php";

class ObrasTeatro extends Funcion
{


    private $autor;
    private $mensaje_operacion;
   
    public function __construct()
    {
        parent::__construct();
        $this->autor = "";
    }

    
    public function cargar($datosFuncion)
    {
        parent::cargar($datosFuncion);
        $this->setAutor($datosFuncion['autor']);
    }

   
    public function getAutor()
    {
        return $this->autor;
    }

    public function setAutor($autor)
    {
        $this->autor = $autor;
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

    /**
     * Recupera los datos de un teatro por id
     *
     * @return true en caso de encontrar los datos, false en caso contrario
     */
    public function Buscar($id)
    {
        $base = new BaseDatos();
        $consulta = "Select * from obrasteatro where id=" . $id;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::Buscar($id);
                    $this->setAutor($row2['autor']);
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
        $consulta = "SELECT * FROM obrasteatro ";
        if ($condicion != "") {
            $consulta = $consulta . ' where' . $condicion;
        }
        $consulta .= " order by autor ";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo = array();
                while ($row2 = $base->Registro()) {
                    $obj = new ObrasTeatro();
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
            $consultaInsertar = "INSERT INTO obrasteatro(id, autor)
				VALUES (" . parent::getId_funcion() . ",'" . $this->getAutor() . "')";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $resp = true;
                } else {
                    $this->setMensaje_operacion($base->getError());
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        }
        return $resp;
    }

  
    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        if (parent::modificar()) {
            $consultaModifica = "UPDATE obrasteatro SET autor='" . $this->getAutor() . "' WHERE id=" . parent::getId_funcion();
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModifica)) {
                    $resp = true;
                } else {
                    $this->setMensaje_operacion($base->getError());
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        }

        return $resp;
    }

   
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM obrasteatro WHERE id=" . parent::getId_funcion();
            if ($base->Ejecutar($consultaBorra)) {
                if (parent::eliminar()) {
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

    public function darCostos()
    {
        $precio= parent::darCostos();
        $precioFinal= $precio+ ($precio*0.45);
        return $precioFinal;
    }
     
    
    public function __toString()
    {
        $cadena = parent::__toString();
        $cadena = $cadena . " Autor: " . $this->getAutor() . "\n";
        return $cadena;
    }

}

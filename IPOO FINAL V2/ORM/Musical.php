<?php
include_once 'Funcion.php';
include_once "BaseDatos.php";

class Musical extends Funcion
{


    private $director;
    private $cantPersonas;
    private $mensaje_operacion;

    public function __construct()
    {
        parent::__construct();
        $this->director = "";
        $this->cantPersonas = "";
    }


    public function cargar($datosfuncion)
    {
        parent::cargar($datosfuncion);
        $this->setDirector($datosfuncion['director']);
        $this->setCantPersonas($datosfuncion['cantPersonas']);
    }


    public function getDirector()
    {
        return $this->director;
    }

    public function getCantPersonas()
    {
        return $this->cantPersonas;
    }


    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function setCantPersonas($cantPersonas)
    {
        $this->cantPersonas = $cantPersonas;
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
        $consulta = "Select * from musical where id=" . $id;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::Buscar($id);
                    $this->setDirector($row2['director']);
                    $this->setCantPersonas($row2['cantPersonas']);
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
        $consulta = "SELECT * FROM musical";
        if ($condicion != "") {
            $consulta = $consulta . ' where . ' . $condicion;
        }
        $consulta .= " order by director ";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arreglo = array();
                while ($row2 = $base->Registro()) {
                    $obj = new Musical();
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
            $consultaInsertar = "INSERT INTO musical(id, director, cantPersonas)
				VALUES (" . parent::getId_funcion() . ",'" . $this->getDirector() . "'," . $this->getCantPersonas() . ")";
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
            $consultaModifica = "UPDATE musical SET director='" . $this->getDirector() . "',cantPersonas='" . $this->getCantPersonas() . "' WHERE id=" . parent::getId_funcion();

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
            $consultaBorra = "DELETE FROM musical WHERE id=" . parent::getId_funcion();
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
        $precioFinal= $precio+ ($precio*0.12);
        return $precioFinal;
    }
    public function __toString()
    {
        $cadena = parent::__toString() . " Director: " . $this->getDirector() . "\n Cantidad de personas en escena: " . $this->getCantPersonas() . "\n";
        return $cadena;
    }
}

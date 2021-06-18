<?php
include_once "BaseDatos.php";


class Teatro
{


    private $id_teatro;

    private $nombre_teatro;

    private $direccion;

    private $coleccionfunciones;

    private $mensaje_operacion;

    public function __construct()
    {
        $this->id_teatro = "";
        $this->nombre_teatro = "";
        $this->direccion = "";
        $this->coleccionfunciones = array();
    }

    public function cargar($datosTeatro)
    {
        $this->setId_teatro($datosTeatro['id_teatro']);
        $this->setNombre_Teatro($datosTeatro['nombre_teatro']);
        $this->setDireccion($datosTeatro['direccion']);
        $this->setColeccionfunciones($datosTeatro['coleccionfunciones']);
    }

    public function getId_teatro()
    {
        return $this->id_teatro;
    }


    public function setId_teatro($id_teatro)
    {
        $this->id_teatro = $id_teatro;

        return $this;
    }


    public function getNombre_teatro()
    {
        return $this->nombre_teatro;
    }


    public function setNombre_teatro($nombre_teatro)
    {
        $this->nombre_teatro = $nombre_teatro;

        return $this;
    }


    public function getDireccion()
    {
        return $this->direccion;
    }


    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getColeccionfunciones()
    {
        //Modificacion Realizada!!
        
        $objCine = new Cine();
        $objMusical = new Musical();
        $objObraTeatro = new ObrasTeatro();
        $condicion = "";
        
        
        $coleccionCine = $objCine->listar($condicion);
        
        $coleccionMusical = $objMusical->listar($condicion);
        
        $coleccionObras = $objObraTeatro->listar($condicion);
       
        $coleccionfunciones =array_merge($coleccionCine, $coleccionMusical, $coleccionObras);
        $this->setColeccionfunciones($coleccionfunciones);
        
        return $coleccionfunciones;
    }


    public function setColeccionfunciones($coleccionfunciones)
    {
        $this->coleccionfunciones = $coleccionfunciones;
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
    public function Buscar($id_teatro)
    {
        $base = new BaseDatos();
        $consultaTeatro = "Select * from teatro where id_teatro=" . $id_teatro;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaTeatro)) {
                if ($row2 = $base->Registro()) {
                    $this->setId_teatro($id_teatro);
                    $this->setNombre_Teatro($row2['nombre_teatro']);
                    $this->setDireccion($row2['direccion']);
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

//modificacion realizada
    public function listar($condicion = "")
    {
        $coleccionTeatros = null;
        $base = new BaseDatos();
        $consultaTeatro = "Select * from teatro ";
        if ($condicion != "") {
            $consultaTeatro = $consultaTeatro . ' where ' . $condicion;
        }
        $consultaTeatro .= " order by id_teatro ";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaTeatro)) {
                $coleccionTeatros = array();
                while ($row2 = $base->Registro()) {
                    $row2['id_teatro']=array();
                    $teatro = new Teatro();
                    $teatro->cargar($row2);

                    array_push($coleccionTeatros, $teatro);
                }
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $coleccionTeatros;
    }


    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO teatro( nombre_teatro, direccion)
				VALUES ('" . $this->getNombre_Teatro() . "','" . $this->getDireccion() . "')";

        if ($base->Iniciar()) {

            if ($id_teatro = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setId_teatro($id_teatro);
               
                $resp = true;
            } else {
                $this->setMensaje_operacion($base->getError());
            }
        } else {
            $this->setMensaje_operacion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE teatro SET nombre_teatro='" . $this->getNombre_Teatro() . "',direccion='" . $this->getDireccion() . "' WHERE id_teatro='" . $this->getId_teatro() . "'";
       
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
            $consultaBorra = "DELETE FROM teatro WHERE id_teatro=" . $this->getId_teatro();
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

    public function verificarHorario($horafuncionNueva, $duracionObraNueva)
    {
        $sepuede = true;
        $coleccion = $this->getColeccionFunciones();
        $horaInicio=null;
        $horaFin=null;
        $horaFinfuncionNueva=null;
        //cuento la cantidad de elementos y recorro la coleccion
        $i=0;
        while( $i < count($coleccion) && $sepuede) {
            $horaInicio = $coleccion[$i]->getHorario_inicio(); //traigo el valor del atributo
            $horaFin = $horaInicio + $coleccion[$i]->getDuracion();
            $horaFinfuncionNueva = $horafuncionNueva + $duracionObraNueva; //no realizo conversion de horas y minutos ya que no lo requeria el enunciado
            if (($horafuncionNueva <= $horaFin) || $horaInicio > $horaFinfuncionNueva) { //condicional que me ayudo la profe viviana
                $sepuede = false;
            }
            $i++;
        }
        return $sepuede;
    }

    
    public function costoPorFuncion($objTeatro){
        $coleccion=$objTeatro->getColeccionfunciones();
              
        $costo=0;
    foreach ($coleccion as $objFuncion) {
        $costoFuncion=$objFuncion->darCostos();
        $costo=$costo+$costoFuncion;
        
    }
    return $costo;
    }


    public function mostrarColeccion($coleccion)
    {
        $arregloStr = "";
        $array = $coleccion;
        $contador = count($array);
        for ($i = 0; $i < $contador; $i++) {
            $arregloStr .= $array[$i] . "\n";
            $arregloStr .= "---------------\n";
        }
        return $arregloStr;
    }

    public  function __toString()
    {
        $coleccionfunciones = $this->getColeccionfunciones();
        return "id_teatro: " . $this->getId_teatro() . "\n
            nombre teatro: " . $this->getNombre_teatro() . "\n
            direccion: " . $this->getDireccion() . "\n
            coleccion: " . $this->mostrarColeccion($coleccionfunciones);
    }

}

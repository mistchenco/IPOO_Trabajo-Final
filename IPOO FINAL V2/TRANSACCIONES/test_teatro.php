<?php
include_once '../ORM/Teatro.php';
include_once '../ORM/Funcion.php';
include_once '../ORM/Musical.php';
include_once '../ORM/Cine.php';
include_once '../ORM/Obrasteatro.php';
include_once 'abmteatro.php';
include_once 'abmcine.php';
include_once 'abmmusical.php';
include_once 'abmobras.php';
function seleccionarOpcion()
{
    
    echo "\n --------------------------------------------------------------\n";
    echo "\n ( 1 ) Agregar un nuevo Teatro";
    echo "\n ( 2 ) Modificar datos de un Teatro";
    echo "\n ( 3 ) Eliminar un Teatro ";
    echo "\n ( 4 ) ingresar funciones: ";
    echo "\n ( 5 ) Modificar funciones: ";
    echo "\n ( 6 ) Eliminar una funcion";
    echo "\n ( 7 ) Costo de las funciones: ";
    echo "\n ( 8 ) Terminar: ";
    echo "\n --------------------------------------------------------------\n";
   
    do {
        echo "Indique una opcion valida :";
        $opcion = (trim(fgets(STDIN)));
        if ($opcion < 1 && $opcion > 8) {
            echo "Debe ingresar una opcion valida \n";
            $opcionValida = false;
        } else {
            $opcionValida = true;
        }
    } while (!$opcionValida);

    return $opcion;
}
//creo una nueva instancia
$abmTeatro = new abmteatro();
do {

    $opcion = seleccionarOpcion();

    switch ($opcion) {

        case 1:

            echo "Seleccione el nombre para el teatro: ";
            $nombre = (trim(fgets(STDIN)));

            echo "Seleccione la direccion: ";
            $direccion = (trim(fgets(STDIN)));


            $datosTeatro = array('id_teatro' => 0, 'nombre_teatro' => $nombre, 'direccion' => $direccion, 'coleccionfunciones' => array());

            $objteatro = $abmTeatro->agregarTeatro($datosTeatro);
            
            $coleccionfunciones = $objteatro->getColeccionfunciones();

            echo "Ingrese 2 funciones destinadas al teatro: \n";
            $cantidadFunciones = 2;
            for ($i = 0; $i < $cantidadFunciones; $i++) {
                $coleccionfunciones = cargarFunciones($objteatro,);

                $objteatro->setColeccionfunciones($coleccionfunciones);
                
            }
            if ($objteatro != null) {


                echo "El nuevo teatro fue cargado! \n";
            } else {
                echo "El teatro no pudo ser cargado! \n";
            }

            break;

        case 2:
            echo "Seleccione el  nombre para el teatro: ";
            $nombre = (trim(fgets(STDIN)));

            echo "Seleccione la direccion: ";
            $direccion = (trim(fgets(STDIN)));

            echo "ingrese el id del teatro a modificar: ";
            $id = (trim(fgets(STDIN)));

            $objteatro = $abmTeatro->seleccionarTeatro($id);
            $modificar = $abmTeatro->modificarTeatro($objteatro, $nombre, $direccion);
            if ($modificar) {
                echo "El teatro se modifico!!\n";
            } else {
                echo "El teatro no se modifico!!\n";
            }



            break;

        case 3:
            echo "ingrese el id del teatro a eliminar: ";
            $id = (trim(fgets(STDIN)));

            $objteatro = $abmTeatro->seleccionarTeatro($id);

            $eliminar = $abmTeatro->eliminarTeatro($objteatro);
            if ($eliminar) {
                echo "El teatro se elimino!!";
            } else {
                echo "El teatro no se elimino!!";
            }



            break;

        case 4:
            echo "Ingrese al id del teatro al que quiere ingresar la funcion: ";
            $id = trim(fgets(STDIN));
            $objteatro = $abmTeatro->seleccionarTeatro($id);
            if(!is_null($objteatro)){//si el objeto que seleccione tiene datos lo cargo!!
            $coleccionfunciones = $objteatro->getColeccionfunciones();
            $coleccionfunciones = cargarFunciones($objteatro, $coleccionfunciones);
            $objteatro->setColeccionfunciones($coleccionfunciones);
            }else{
                echo "no se encontro un teatro con ese ID!!";
            }
            break;
        case 5:
            echo "Ingrese el id de la funcion a modificar: ";
            $id = trim(fgets(STDIN));
            echo "ingrese que tipo de funcion desea modificar: (cine/musical/obra) ";
            $tipo = trim(fgets(STDIN));

            echo "nuevo nombre de la funcion: ";
            $nombre = trim(fgets(STDIN));
            echo "Nuevo Precio: ";
            $precio = trim(fgets(STDIN));
            if ($tipo == "Musical") {
                $abmmusical = new abmMusical();
                $objMusical = $abmmusical->seleccionarMusical($id);
                echo "musical".$objMusical;
                if(!is_null($objMusical)){
                $respuesta = $abmmusical->modificarMusical($objMusical, $nombre, $precio);
                if ($respuesta) {
                    echo "la funcion se modifico!!";
                } else {
                    echo "La funcion no se modifico!!";
                }
            }
            } elseif ($tipo == "Cine") {
                $abmcine = new abmcine();
                $objCine = $abmcine->seleccionarCine($id);
                $respuesta = $abmcine->modificarCine($objCine, $nombre, $precio);
                if ($respuesta) {
                    echo "la funcion se modifico!!";
                } else {
                    echo "La funcion no se modifico!!";
                }
            } else {

                $abmObra = new abmObra;
                $objObra = $abmObra->seleccionarObra($id);
                $respuesta = $abmObra->modificarObra($objCine, $nombre, $precio);
                if ($respuesta) {
                    echo "la funcion se modifico!!";
                } else {
                    echo "La funcion no se modifico!!";
                }
            }

            break;
            case 6:
                echo "Ingrese el id de la funcion a Eliminar: ";
                $id = trim(fgets(STDIN));
                echo "ingrese que tipo de funcion desea Eliminar: (cine/musical/obra) ";
                $tipo = trim(fgets(STDIN));
                if ($tipo == "Musical") {
                    $abmmusical = new abmMusical();
                    $objMusical = $abmmusical->seleccionarMusical($id);
                    $respuesta = $abmmusical->eliminarMusical($objMusical);
                    if ($respuesta) {
                        echo "la funcion se Elimino!!";
                    } else {
                        echo "La funcion no pudo ser Eliminada!!";
                    }
                }if ($tipo == "Cine") {
                    $abmcine = new abmcine();
                    $objCine = $abmcine->seleccionarCine($id);
                    $respuesta = $abmcine->eliminarCine($objCine);
                    if ($respuesta) {
                        echo "la funcion se Elimino!!";
                    } else {
                        echo "La funcion no pudo ser Eliminada!!";
                    }
                }if($tipo == "Obra") {
                    $abmObra = new abmObra();
                    $objObra = $abmObra->seleccionarObra($id);
                    $respuesta = $abmObra->eliminarObra($objObra);
                    if ($respuesta) {
                        echo "la funcion se Elimino!!";
                    } else {
                        echo "La funcion no pudo ser Eliminada!!";
                    }
            
                }
            
            break; 
            case 7:
                echo "Ingrese al id del teatro para saber sus costos: ";
                $id = trim(fgets(STDIN));
                
                $objteatro = $abmTeatro->seleccionarTeatro($id);
               
                $costo = $objteatro->costoPorFuncion($objteatro);
                echo "El costo de las funciones del teatro es $ ".$costo."\n";
            break;
    }
} while ($opcion != 8);

function cargarFunciones($objteatro)
{
    $datosFuncion = array();
    $idteatro = $objteatro->getId_teatro();
    
    $coleccionfunciones=$objteatro->getColeccionfunciones();

    echo ("Ingrese el nombre de la funcion: ");
    $nombre = trim(fgets(STDIN));
    echo ("Ingrese el precio: ");
    $precio = trim(fgets(STDIN));
    echo ("Ingrese el horario de inicio: ");
    $horario = trim(fgets(STDIN));
    echo ("Ingrese la duracion de la funcion: ");
    $duracion = trim(fgets(STDIN));
    $verificarHorario=true;
    if(!empty($coleccionfunciones)){
    
    $verificarHorario = $objteatro->verificarHorario($horario, $duracion);
    }
    if ($verificarHorario) {
        echo (" Que tipo de funcion es: (cine/musical/obra) ");
        $tipo = trim(fgets(STDIN));

        if ($tipo == "Cine") {
            echo ("Ingrese el Genero: ");
            $genero = trim(fgets(STDIN));
            echo ("Ingrese el pais: ");
            $pais = trim(fgets(STDIN));
            $datosFuncion = array(
                "id_funcion" => 0, 'nombre_funcion' => $nombre, 'hora_inicio' => $horario,
                'duracion' => $duracion, 'precio' => $precio, 'objTeatro' => $objteatro, 'genero' => $genero, 'origen' => $pais, 'id_teatro' => $idteatro
            );
            $abmcine = new abmcine();
            $objCine = $abmcine->agregarCine($datosFuncion);
            array_push($coleccionfunciones, $objCine);
        } elseif ($tipo == "Musical") {
            echo ("Ingrese el director: ");
            $director = trim(fgets(STDIN));
            echo ("cantidad de personas en escena: ");
            $cantPersonas = trim(fgets(STDIN));
            $datosFuncion = array(
                "id_funcion" => 0, 'nombre_funcion' => $nombre, 'hora_inicio' => $horario,
                'duracion' => $duracion, 'precio' => $precio, 'objTeatro' => $objteatro, 'director' => $director, 'cantPersonas' => $cantPersonas, 'id_teatro' => $idteatro
            );

            $abmmusical = new abmMusical();
            $objMusical = $abmmusical->agregarMusical($datosFuncion);

            array_push($coleccionfunciones, $objMusical);
        } else {
            echo ("Ingrese el autor de la obra: ");
            $autor = trim(fgets(STDIN));
            $datosFuncion = array(
                "id_funcion" => 0, 'nombre_funcion' => $nombre, 'hora_inicio' => $horario,
                'duracion' => $duracion, 'precio' => $precio, 'objTeatro' => $objteatro, 'autor' => $autor, 'id_teatro' => $idteatro
            );
            $abmObra = new abmObra();
            $objObra = $abmObra->agregarObra($datosFuncion);

            array_push($coleccionfunciones, $objObra);
        }
        echo "Funcion cargada con Exito! \n";
    } else {
        echo "¡¡El horario se solapa con otra funcion!! \n";
    }
   
    return $coleccionfunciones;
}

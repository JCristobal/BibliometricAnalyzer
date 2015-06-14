        <?php

/*
            //para bahia
            $dsn = "localhost"; 
            $usuario= "26050687";
            $password= "29392";
            $bd="26050687";
*/

            // para mi localhost
            $dsn = "localhost"; 
            $usuario= "root";
            $password= "29392";
            $bd="prueba";

            //$conexion = @mysql_connect($dsn,$usuario, $password);
            $conexion = @mysql_connect($dsn,$usuario);

            if (!$conexion) {
                die('<strong>No pudo conectarse:</strong> ' . mysql_error());
            }else{
            //echo 'Conectado  satisfactoriamente al servidor <br/>';
            }

            mysql_select_db($bd, $conexion) or die(mysql_error($conexion));


      
            // Generaremos una apiKey aleatoriamente de una lista de válidas, ya que cada una tiene 20.000 peticiones como tope para algunas funcionalidades
            $listakey = array("c0dee35412af407a9c07b4fabc7bc447", "3e4a6a7418e11764249c10a0febb9e83");
            $clave_aleatoria = array_rand($listakey, 1);
            $apikey = $listakey[$clave_aleatoria];


            ?>


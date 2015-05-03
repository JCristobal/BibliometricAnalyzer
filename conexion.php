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


            ?>


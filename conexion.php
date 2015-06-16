        <?php

            // para mi localhost
            $dsn = ""; 
            $usuario= "";
            $password= "";
            $bd="";

            //$conexion = @mysql_connect($dsn,$usuario, $password);
            $conexion = @mysql_connect($dsn,$usuario);

            if (!$conexion) {
                die('<strong>No pudo conectarse:</strong> ' . mysql_error());
            }else{
            //echo 'Conectado  satisfactoriamente al servidor <br/>';
            }

            mysql_select_db($bd, $conexion) or die(mysql_error($conexion));



            ?>


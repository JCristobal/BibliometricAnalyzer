<?php

error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP

/*
Mostraremos las entradas (hasta 15) de las publicaciones que se ajusten a la consulta dada (con $idConsulta)

*/
        $i=0;

        $consulta_publicaciones= "SELECT * FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` DESC";
      
        $resultados=mysql_query($consulta_publicaciones,$conexion); 


        echo "<div id='lista_entradas'>";

        while (($row=mysql_fetch_array($resultados)) && ($i<15)) {   
          $muestratitulo=$row['titulo']; 
          $muestracreador=$row['creador']; 
          $muestrapublicacion=$row['nombre_publi']; 
          $muestrafecha=$row['fecha_portada'];
          $muestravolumen=$row['volumen'];
          $muestrarango=$row['rango_pags'];  
          $muestraafil=$row['afiliacion_nombre'];
          $muestraafil_ciudad=$row['afiliacion_ciudad'];
          $muestraafil_pais=$row['afiliacion_pais'];
          $muestraenlace=$row['enlace_preview'];
          $muestratipo=$row['tipo_publi'];
          $muestrasubtipo=$row['subtipo_publi'];
          $muestraenlace=$row['enlace_preview'];
          $muestradoi=$row['doi'];
          $muestracitedby=$row['enlace_citedby'];
          //$muestraeid=$row['eid'];
          $muestraissn=$row['issn'];
          $muestracoautores=$row['enlace_coautores'];
          $muestra_citas_publicaciones=$row['citas'];

          if(($i%2)==0){echo "<div class='content-section-a'>";} // Alternamos la clase según las entradas
          else{echo"<div class='content-section-b'>";}  

        echo "<div class='entrada'>";

          //echo "<p> Entry number ".$i."</p>"; 
          $i++;

          // Comprobamos que tiene portada. Primero creamos el enlace a la portada
          $portada = array('http://www.sciencedirect.com/science/journal/',$muestraissn);
          $portada=implode("", $portada); 
          // Y vemos las cabeceras enviadas  en respuesta a una petición HTTP del enlace creado
          $headers =get_headers($portada);
          // Viendo la cabeceras comprobamos si existe el enlace a la publicación y creamos una imagen con su portada
          if($headers[0]=="HTTP/1.0 200 OK"){
            echo "<a class=\"img_portada\" href=\"http://www.sciencedirect.com/science/journal/$muestraissn\"><img src=\"http://api.elsevier.com/content/serial/title/issn/$muestraissn?view=coverimage&httpAccept=image/gif&apiKey=$apikey\" alt=\"sin imagen\" \"></img> </a>"; 
          }
          else{  // si no existe cargamos una imagen por defecto
            echo "<img class=\"img_portada\" src=\"img/Sin_imagen_disponible.jpg\" height=\"200\" width=\"150\"></img>";
          }

          echo " <div class=\"cuerpo_entrada\">  <p style='font-weight: bold;'> $muestratitulo </p> <p>"; 


          $contectado=false;              // Esta variable nos dirá si estamos conectados a una red asociada a Scopus
          if($muestracoautores != ""){
            $contectado=true;             // Si la lista de autores está rellena es que ha podido consultar el enlace de la publicación que sólo está disponible en redes asociadas a Scopus
            $coautores = explode(",", $muestracoautores);

            echo $coautores[0]."<form style =\"float: left; margin: 0px;\">By<input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautores[0]\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\" onclick=\"espera()\"> $coautores[0]</button></form>";

            for($cont=1; $cont<count($coautores); $cont++){
              echo "<form style =\"float: left; margin: 0px;\"><input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautores[$cont]\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\" onclick=\"espera()\"> $coautores[$cont]</button></form>";
            }
          }
          
          if($contectado){echo "</p><p style=\"clear: left\">";}
          else{echo "<p>By $muestracreador (to see all authors have to be registered in <a href='http://www.scopus.com/'>Scopus</a>)";} //Si no estamos en una red de Scopus sólo podemos consultar el primer autor de la publicación (campo "creator")

          if(strlen($muestraafil)){echo " of the affiliation $muestraafil in $muestraafil_ciudad ($muestraafil_pais) ";}
          else{echo "(No associated affiliation)  </p> ";}  
          echo "<p> Published in $muestrapublicacion ";
          if($muestravolumen!=0){echo"(volume $muestravolumen) ";}
          if($muestrarango!=0){echo "in the pages $muestrarango ";}
          if($muestrafecha!=0){echo "with cover date $muestrafecha ";}
          echo "</p>";

          echo "<p> Type $muestratipo ($muestrasubtipo) </p>";
                                                                                                                                                               
          echo"<p> <a href=\"$muestracitedby\">  <img src=\"http://api.elsevier.com/content/abstract/citation-count?doi=$muestradoi&httpAccept=image/jpeg&apiKey=$apikey\"></img>  </a>";  
          
          echo"<a style= \"margin-left: 20px;\" href=\"$muestraenlace&apiKey=$apikey\"> Link to Scopus PREVIEW </a></p>";

          if($muestra_citas_publicaciones){
            echo "<div class='citas'> <p>In the publications: </p>";
            $muestra_citas_publicaciones = explode("*", $muestra_citas_publicaciones);
              for($a=1; $a<count($muestra_citas_publicaciones); $a++){
                echo"<p> - $muestra_citas_publicaciones[$a] </p>"; 
              }
            echo "</div>";
          }


          echo '</div>  <div style="clear: left"></div> ';

        echo "</div>  </div>"; // final de entrada y content-section-a/b
   
    
        }

        echo "</div>"; //fin id='lista_entradas'



?>
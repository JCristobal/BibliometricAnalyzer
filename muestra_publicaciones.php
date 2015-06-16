<?php
/*
Mostraremos las entradas (hasta 50) de las publicaciones que se ajusten a la consulta dada (con $idConsulta)

*/
        $i=0;

        $consulta_publicaciones= "SELECT * FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` DESC";
      
        $resultados=mysql_query($consulta_publicaciones,$conexion); 

        echo "<div id='lista_entradas'>";

        while (($row=mysql_fetch_array($resultados)) && ($i<50)) {   
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
          $muestraeid=$row['eid'];
          $muestraissn=$row['issn'];
          $muestracoautores=$row['enlace_coautores'];

        echo "<div class='entrada'>";

          echo "<p> Entry number ".$i."</p>"; 
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

          // Consultamos lo que tiene almacenado como "coautores". Son los demás autores, pero en el apartado de "creator" sólo muestra el primero de la lista
          $arraycoautores= array($muestracoautores,"&httpAccept=application/json&apikey=",$apikey);
          $json_string=implode("", $arraycoautores); 
          $datos_coautores = json_decode(file_get_contents($json_string),true);
          $contador_coautores=1;
          $contectado=false;   // En caso de no estar conectado a una red asociada a Scopus sólo se puede mostrar el primero de la lista, apartado "creator"

          $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][0]["ce:indexed-name"];
          if(!empty($coautor)){
            echo "<form style =\"float: left; margin: 0px;\">By<input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautor\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\"> $coautor</button></form>";      
            $contectado=true;
          }
          while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
            $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
            echo "<form style =\"float: left; margin: 0px;\">,<input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautor\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\"> $coautor</button></form>";
            $contador_coautores++;
          }
          if($contectado){echo "</p><p style=\"clear: left\">";}
          else{echo "<p>By $muestracreador (to see all authors have to be registered in Scopus)";}

          if(strlen($muestraafil)){echo " of the affiliation $muestraafil in $muestraafil_ciudad ($muestraafil_pais) ";}
          else{echo "(No associated affiliation)  </p> ";}  
          echo "<p> Published in $muestrapublicacion ";
          if($muestravolumen!=0){echo"(volume $muestravolumen) ";}
          if($muestrarango!=0){echo "in the pages $muestrarango ";}
          if($muestrafecha!=0){echo "with cover date $muestrafecha ";}
          echo "</p>";

          echo "<p> Type $muestratipo: $muestrasubtipo </p>";

          echo"<p><a href=\"$muestraenlace&apiKey=$apikey\"> Link to Scopus PREVIEW </a></p>";
                                                                                                                                                              //QUOTA_EXCEEDED: Maximum number of 20000 requests exceeded  
          echo" <a href=\"$muestracitedby\">  <img src=\"http://api.elsevier.com/content/abstract/citation-count?doi=$muestradoi&httpAccept=image/jpeg&apiKey=$apikey\"></img>  </a>";  // 6492f9c867ddf3e84baa10b5971e3e3d
          
          echo"<p><a href='http://api.elsevier.com/content/search/scopus?query=refeid%28$muestraeid%29&apiKey=$apikey'> Link to Scopus Cites </a></p>"; 

          echo '</div>  <div style="clear: left"></div> ';

        echo "</div><br>";
   

          echo "<br>";      
        }

        echo "</div>"; //fin id='conjunto_entradas'



?>
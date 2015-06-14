<?php
/*
Mostraremos las entradas de las publicaciones que se ajusten a la consulta dada (con $idConsulta)

*/
        $i=1;
        $consulta_publicaciones= "SELECT * FROM publicaciones WHERE id=".$idConsulta ;
                    
        $resultados=mysql_query($consulta_publicaciones,$conexion);   

        echo "<div id='lista_entradas'>";

        while ($row=mysql_fetch_array($resultados)) {   
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

          echo " <div class=\"cuerpo_entrada\">  <p style='font-weight: bold;'> $muestratitulo </p> 
          <p> <form> <input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$muestracreador\"> <button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\">by $muestracreador </button></form>";
          if(strlen($muestraafil)){echo " of the affiliation $muestraafil in $muestraafil_ciudad ($muestraafil_pais) </p>";}
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
      
//http://api.elsevier.com/documentation/AbstractCitationCountAPI.wadl
//http://api.elsevier.com/documentation/metadata/abstractCitationCountMeta.json
//http://www.scopus.com/results/citedbyresults.url?sort=plf-f&cite=2-s2.0-49549114022&src=s&imp=t&sid=EC4E03F932C14A3FE555B99C71AB440B.aXczxbyuHHiXgaIW6Ho7g%3a780&sot=cite&sdt=a&sl=0&origin=inward&editSaveSearch=&txGid=EC4E03F932C14A3FE555B99C71AB440B.aXczxbyuHHiXgaIW6Ho7g%3a77
//http://api.elsevier.com/content/search/scopus?query=refeid%282-s2.0-49549114022%29&apiKey=c0dee35412af407a9c07b4fabc7bc447          


        /*$html = file_get_html($muestraenlace);
        foreach($html->find('hr p.marginB3') as $elemento){
               echo $elemento->plaintext."<br>";           
        } */       


          echo "<br>";      
        }

        echo "</div>"; //fin id='conjunto_entradas'



?>
<?php

/*
Almacenaremos hasta las 200 entradas con datos de publicaciones que se ajusten a la consulta dada.

Necesitaremos $consulta que contendrá un array que transformaremos en string para hacer la petición y su id con $idConsulta.

$entradasTotales será el número de entradas que contiene la consulta. Si no hay $hay_entradas tomará valor false
*/

    $json_string=implode("", $consulta); 
    $data = json_decode(file_get_contents($json_string),true);

    $entradasTotales = $data["search-results"]["opensearch:totalResults"];
    $hay_entradas=true;



if($entradasTotales > 0){

    ///echo " <a href='",$json_string,"'> URL de la 1ª pagina de resultados </a> <br>";

      for($i = 0; $i < $data["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$data["search-results"]["entry"][$i]["dc:creator"];
            $creador = str_replace("'", "\'", $creador);
            $publicacion =$data["search-results"]["entry"][$i]["prism:publicationName"];
            $publicacion = str_replace("(", "\(", $publicacion);
            $publicacion = str_replace(")", "\)", $publicacion); 
            $publicacion = str_replace("'", "\'", $publicacion);
            $rang_pag = $data["search-results"]["entry"][$i]["prism:pageRange"];
            $fecha_letra = $data["search-results"]["entry"][$i]["prism:coverDisplayDate"];
            $fecha = $data["search-results"]["entry"][$i]["prism:coverDate"];
            $tipo = $data["search-results"]["entry"][$i]["prism:aggregationType"];
            $subtipo = $data["search-results"]["entry"][$i]["subtypeDescription"];
            $issn = $data["search-results"]["entry"][$i]["prism:issn"];
            $volume = $data["search-results"]["entry"][$i]["prism:volume"];
            $id = $data["search-results"]["entry"][$i]["dc:identifier"]; 
            $eid = $data["search-results"]["entry"][$i]["eid"];
            $afil = $data["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
            $afil = str_replace("'", "\'", $afil);
            $afil_ciudad = $data["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
            $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
            $afil_pais = $data["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
            $doi = $data["search-results"]["entry"][$i]["prism:doi"];
            $enlace_coautores = $data["search-results"]["entry"][$i]["link"][1]["@href"];
            $enlace_preview = $data["search-results"]["entry"][$i]["link"][2]["@href"];
            $enlace_citedby = $data["search-results"]["entry"][$i]["link"][3]["@href"];

          $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
          $array_aux=implode("", $arraycoautores); 
          $datos_coautores = json_decode(file_get_contents($array_aux),true);
          $contador_coautores=0;
          $lista_autores=array("");

          while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
            $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
            $lista_autores[]= $coautor;
            $contador_coautores++;
          }

          $enlace_coautores=implode(",", $lista_autores); 
          $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

          $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

        }
}
else{ echo "NO ENTRIES"; $hay_entradas=false;}



        $cuenta=25;

        if ($entradasTotales > 25) {
          if($entradasTotales < 50) {$cuenta=$entradasTotales-25;}
            //$consulta_2_pag = array($data["search-results"]["link"][2]["@href"]);  // link a la segunda pagina de 
            $consulta_2_pag = array($json_string,'&start=25&count=',$cuenta);
            $json_string_2_pag=implode("", $consulta_2_pag); 
            ///echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina de resultados </a> <br>";
            $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);


            for($i = 0; $i < $data_2_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_2_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_2_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_2_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_2_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data_2_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_2_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_2_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_2_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_2_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_2_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_2_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_2_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_2_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_2_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_2_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_2_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_2_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_2_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_2_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array("");

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

          $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                                                                                  
                 
                 mysql_query($insert) or die(mysql_error()); 

              }




        }

        if($entradasTotales > 50){
          if($entradasTotales < 75) {$cuenta=$entradasTotales-50;}

            $consulta_3_pag = array($json_string,'&start=50&count=',$cuenta);
            $json_string_3_pag=implode("", $consulta_3_pag);      
            ///echo " <a href='",$json_string_3_pag,"'> URL de la 3ª pagina de resultados </a> <br>";
            $data_3_pag = json_decode(file_get_contents($json_string_3_pag),true);

            for($i = 0; $i < $data_3_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_3_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_3_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_3_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_3_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data_3_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_3_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_3_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_3_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_3_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_3_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_3_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_3_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_3_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_3_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_3_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_3_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_3_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_3_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_3_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

          $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                                                                                  
                  
                  mysql_query($insert) or die(mysql_error()); 

              }



        }

        if($entradasTotales > 75){
          if($entradasTotales < 100) {$cuenta=$entradasTotales-75;}

            $consulta_4_pag = array($json_string,'&start=75&count=',$cuenta);
            $json_string_4_pag=implode("", $consulta_4_pag);        
            ///echo " <a href='",$json_string_4_pag,"'> URL de la 4ª pagina de resultados </a> <br>";
            $data_4_pag = json_decode(file_get_contents($json_string_4_pag),true);

            for($i = 0; $i < $data_4_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_4_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_4_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_4_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_4_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data_4_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_4_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_4_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_4_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_4_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_4_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_4_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_4_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_4_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_4_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_4_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_4_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_4_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_4_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_4_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

         $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                  
                  mysql_query($insert) or die(mysql_error()); 

              }



        }

        if($entradasTotales > 100){
          if($entradasTotales < 125) {$cuenta=$entradasTotales-100;}

            $consulta_5_pag = array($json_string,'&start=100&count=',$cuenta);
            $json_string_5_pag=implode("", $consulta_5_pag);        
            ///echo " <a href='",$json_string_5_pag,"'> URL de la 5ª pagina de resultados </a> <br>";
            $data_5_pag = json_decode(file_get_contents($json_string_5_pag),true);

            for($i = 0; $i < $data_5_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_5_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_5_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_5_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_5_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data_5_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_5_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_5_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_5_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_5_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_5_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_5_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_5_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_5_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_5_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_5_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_5_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_5_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_5_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_5_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

         $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                  
                  mysql_query($insert) or die(mysql_error()); 

              }


        }

        if($entradasTotales > 125){
          if($entradasTotales < 150) {$cuenta=$entradasTotales-125;}

            $consulta_6_pag = array($json_string,'&start=125&count=',$cuenta);
            $json_string_6_pag=implode("", $consulta_6_pag);        
            ///echo " <a href='",$json_string_6_pag,"'> URL de la 6ª pagina de resultados </a> <br>";
            $data_6_pag = json_decode(file_get_contents($json_string_6_pag),true);

            for($i = 0; $i < $data_6_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_6_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_6_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_6_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_6_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data_6_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_6_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_6_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_6_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_6_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_6_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_6_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_6_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_6_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_6_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_6_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_6_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_6_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_6_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_6_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

         $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                  
                  mysql_query($insert) or die(mysql_error()); 

              }


        }

        if($entradasTotales > 150){
          if($entradasTotales < 175) {$cuenta=$entradasTotales-150;}

            $consulta_7_pag = array($json_string,'&start=150&count=',$cuenta);
            $json_string_7_pag=implode("", $consulta_7_pag);        
            ///echo " <a href='",$json_string_7_pag,"'> URL de la 7ª pagina de resultados </a> <br>";
            $data_7_pag = json_decode(file_get_contents($json_string_7_pag),true);

            for($i = 0; $i < $data_7_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_7_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_7_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_7_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_7_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data7_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_7_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_7_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_7_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_7_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_7_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_7_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_7_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_7_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_7_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_7_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_7_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_7_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_7_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_7_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

         $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                  
                  mysql_query($insert) or die(mysql_error()); 

              }


        }

        if($entradasTotales > 175){
          if($entradasTotales < 200) {$cuenta=$entradasTotales-175;}

            $consulta_8_pag = array($json_string,'&start=175&count=',$cuenta);
            $json_string_8_pag=implode("", $consulta_8_pag);        
            ///echo " <a href='",$json_string_8_pag,"'> URL de la 8ª pagina de resultados </a> <br>";
            $data_8_pag = json_decode(file_get_contents($json_string_8_pag),true);

            for($i = 0; $i < $data_8_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_8_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_8_pag["search-results"]["entry"][$i]["dc:creator"];
                  $creador = str_replace("'", "\'", $creador);
                  $publicacion =$data_8_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "\(", $publicacion);
                  $publicacion = str_replace(")", "\)", $publicacion); 
                  $publicacion = str_replace("'", "\'", $publicacion);
                  $rang_pag = $data_8_pag["search-results"]["entry"][$i]["prism:pageRange"];
                  $fecha_letra = $data8_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"];
                  $fecha = $data_8_pag["search-results"]["entry"][$i]["prism:coverDate"];
                  $tipo = $data_8_pag["search-results"]["entry"][$i]["prism:aggregationType"];
                  $subtipo = $data_8_pag["search-results"]["entry"][$i]["subtypeDescription"];
                  $issn = $data_8_pag["search-results"]["entry"][$i]["prism:issn"];
                  $volume = $data_8_pag["search-results"]["entry"][$i]["prism:volume"];
                  $id = $data_8_pag["search-results"]["entry"][$i]["dc:identifier"]; 
                  $eid = $data_8_pag["search-results"]["entry"][$i]["eid"];
                  $afil = $data_8_pag["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
                  $afil = str_replace("'", "\'", $afil);
                  $afil_ciudad = $data_8_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
                  $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
                  $afil_pais = $data_8_pag["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
                  $doi = $data_8_pag["search-results"]["entry"][$i]["prism:doi"];
                  $enlace_coautores = $data_8_pag["search-results"]["entry"][$i]["link"][1]["@href"];
                  $enlace_preview = $data_8_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_8_pag["search-results"]["entry"][$i]["link"][3]["@href"];

            $arraycoautores= array($enlace_coautores,"&httpAccept=application/json&apikey=",$apikey);
            $array_aux=implode("", $arraycoautores); 
            $datos_coautores = json_decode(file_get_contents($array_aux),true);
            $contador_coautores=0;
            $lista_autores=array();

            while(!empty($datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"])){
              $coautor = $datos_coautores["abstracts-retrieval-response"]["authors"]["author"][$contador_coautores]["ce:indexed-name"];
              $lista_autores[]= $coautor;
              $contador_coautores++;
            }

            $enlace_coautores=implode(",", $lista_autores); 
            $enlace_coautores = str_replace("'", "\'", $enlace_coautores);

         $arrayconsulta_citas= array("http://api.elsevier.com/content/search/scopus?query=refeid(",$eid,")&apikey=",$apikey);
          $array_citas=implode("", $arrayconsulta_citas); 
          $datos_citas = json_decode(file_get_contents($array_citas),true);
          $lista_citas=array("");

          for($a = 0; $a < $datos_citas["search-results"]["opensearch:itemsPerPage"]; $a++){
              $lista_citas[]= $datos_citas["search-results"]["entry"][$a]["dc:creator"];
          }

          $citas=implode(",", $lista_citas); 
          $citas = str_replace("'", "\'", $citas);


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_coautores, enlace_preview, enlace_citedby, citas) VALUES (\''.$idConsulta.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_coautores.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',\''.$citas.'\')'; 
                  
                  mysql_query($insert) or die(mysql_error()); 

              }


        }
?>
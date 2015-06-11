<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Consulta por tema">
    <meta name="author" content="JCristobal">
    

    <title>Consulta de tema</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/estilo.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]
    <script src="js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/highcharts-3d.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>  

<!-- http://github.hubspot.com/pace/docs/welcome/  -->
<script src="pace.min.js"></script>
<link href="css/pace_center_simple.css" rel="stylesheet" />
<!--<link href="css/pace_big_counter.css" rel="stylesheet" />
<link href="css/pace_center_atom.css" rel="stylesheet" />-->

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Bibliometric consultant by JCristobal</a>
        </div>  
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.html">Home</a></li>
            <li><a href="https://github.com/JCristobal">About</a></li>
            <li><a href="mailto:tobas92@gmail.com">Contact</a></li>
          </ul>
        </div>   
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">


<?php

      
        error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP      
        $apikey = "c0dee35412af407a9c07b4fabc7bc447";

        $tema = $_POST['busqueda_tema'];
        $palabra = $_POST['busqueda_basica'];
        $titulo = $_POST['busqueda_titulo'];

        $hay_tema=false;
        $hay_palabra=false;
        $hay_titulo=false;

        //echo "<h1>Consulta  bibliométrica sobre ".$tema." </h1>";

        echo "<h1>Consulta  bibliométrica";

        if(strlen($palabra)){ echo " about '".$palabra."'"; $hay_palabra=true;}
        if(strlen($tema)){ echo " with topic ".$tema; $hay_tema=true;}
        if(strlen($titulo)){ echo " with title: ".$titulo; $hay_titulo=true;}
        echo "</h1>";


        switch ($tema) {
          case "Agricultural and Biological Sciences":
              $tema="AGRI";
              break;
          case "Artes y Humanidades":
              $tema="ARTS";
              break;
          case "Biochemistry, Genetics and Molecular Biology":
              $tema="BIOC";
              break;
          case "Business, Management and Accounting":
              $tema="BUSI";  
              break;  
          case "Chemical Engineering":
              $tema="CENG"; 
              break;
          case "Chemistry":
              $tema="CHEM";
              break;
          case "Computer Science":
              $tema="COMP"; 
              break;
          case "Decision Sciences":
              $tema="DECI"; 
              break;
          case "Dentistry":
              $tema="DENT"; 
              break;
          case "Earth and Planetary Sciences":
              $tema="EART"; 
              break;
          case "Economics, Econometrics and Finance":
              $tema="ECON"; 
              break;
          case "Energy":
              $tema="ENER"; 
              break;
          case "Engineering":
              $tema="ENGI"; 
              break;
          case "Environmental Science":
              $tema="ENVI"; 
              break;
          case "Health Professions":
              $tema="HEAL"; 
              break;
          case "Immunology and Microbiology":
              $tema="INMU"; 
              break;
          case "Materials Science":
              $tema="MATE"; 
              break;
          case "Mathematics":
              $tema="MATH"; 
              break;
          case "Medicine":
              $tema="MEDI"; 
              break;
          case "Neuroscience":
              $tema="NEUR"; 
              break;
          case "Nursing":
              $tema="NURS"; 
              break;
           case "Pharmacology, Toxicology and Pharmaceutics":
              $tema="PHAR";    
              break;                  
          case "Physics and Astronomy":
              $tema="FHYS"; 
              break;
          case "Psychology":
              $tema="PSYC"; 
              break;
          case "Social Sciences":
              $tema="SOCI"; 
              break;
          case "Veterinary":
              $tema="VETE"; 
              break;
          case "Multidisciplinary":
              $tema="MULT"; 
              break;
        }
      


        echo"<p>Did not you want to search this? <a href='index.html'> Go home </a> </p>";


        //Traducimos los caracteres especiales dados a UTF-8
        $palabra = str_replace(" ", "%20", $palabra);
        $palabra = str_replace("á", "%%C3%A1", $palabra);
        $palabra = str_replace("é", "%C3%A9", $palabra);
        $palabra = str_replace("í", "%C3%AD", $palabra);
        $palabra = str_replace("ó", "%C3%B3", $palabra);
        $palabra = str_replace("ú", "%C3%BA", $palabra);

        $titulo = str_replace(" ", "%20", $titulo);
        $titulo = str_replace("á", "%%C3%A1", $titulo);
        $titulo = str_replace("é", "%C3%A9", $titulo);
        $titulo = str_replace("í", "%C3%AD", $titulo);
        $titulo = str_replace("ó", "%C3%B3", $titulo);
        $titulo = str_replace("ú", "%C3%BA", $titulo);


        
        if($hay_tema){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_palabra){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=',$palabra,'&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_titulo){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_tema && $hay_palabra){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=',$palabra,'%20AND%20SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_tema && $hay_titulo){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=TITLE("',$titulo,'")%20AND%20SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_palabra && $hay_titulo){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=',$palabra,'%20AND%20TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
        }
        if($hay_tema && $hay_palabra && $hay_titulo){
          $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=',$palabra,'%20AND%20SUBJAREA(',$tema,')%20AND%20TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
        }


        $json_stringtema=implode("", $consulta); 
        $datatema = json_decode(file_get_contents($json_stringtema),true);

        $entradasTotales = $datatema["search-results"]["opensearch:totalResults"];
        $hay_entradas=true;

        echo " Total number of results: " .$entradasTotales,"<br><br>";

        echo " <a href='",$json_stringtema,"'> URL de la 1º página de resultados  </a> <br> ";

      include'conexion.php'; 

      //echo "<p> Almacenamos en la BD </p>";
if($entradasTotales > 0){
      for($i = 0; $i < $datatema["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $datatema["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$datatema["search-results"]["entry"][$i]["dc:creator"];
            $publicacion =$datatema["search-results"]["entry"][$i]["prism:publicationName"];
            $publicacion = str_replace("(", "", $publicacion);
            $publicacion = str_replace(")", "", $publicacion); 
            $publicacion = str_replace("'", "", $publicacion);
            $rang_pag = $datatema["search-results"]["entry"][$i]["prism:pageRange"];
            $fecha_letra = $datatema["search-results"]["entry"][$i]["prism:coverDisplayDate"];
            $fecha = $datatema["search-results"]["entry"][$i]["prism:coverDate"];
            $tipo = $datatema["search-results"]["entry"][$i]["prism:aggregationType"];
            $subtipo = $datatema["search-results"]["entry"][$i]["subtypeDescription"];
            $issn = $datatema["search-results"]["entry"][$i]["prism:issn"];
            $volume = $datatema["search-results"]["entry"][$i]["prism:volume"];
            $id = $datatema["search-results"]["entry"][$i]["dc:identifier"]; 
            $eid = $datatema["search-results"]["entry"][$i]["eid"];
            $afil = $datatema["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
            $afil = str_replace("'", "\'", $afil);
            $afil_ciudad = $datatema["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
            $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
            $afil_pais = $datatema["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
            $doi = $datatema["search-results"]["entry"][$i]["prism:doi"];
            $enlace_preview = $datatema["search-results"]["entry"][$i]["link"][2]["@href"];
            $enlace_citedby = $datatema["search-results"]["entry"][$i]["link"][3]["@href"];
            /*$pii = $datatema["search-results"]["entry"][$i]["pii"];
            $veces_citado = $datatema["search-results"]["entry"]["citedby-count"];
            $source_id = $datatema["search-results"]["entry"]["source-id"];*/

           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')'; 
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }
}
else{ echo "NO ENTRIES"; $hay_entradas=false;}



        $cuenta=25;

        if ($entradasTotales >= 25) {
          if($entradasTotales < 50) {$cuenta=$entradasTotales-25;}
            //$consulta_2_pag = array($datatema["search-results"]["link"][2]["@href"]);  
            $consulta_2_pag = array($json_stringtema,'&start=25&count=',$cuenta);
            $json_string_2_pag=implode("", $consulta_2_pag); 
            echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina de resultados </a> <br>";
            $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);


            for($i = 0; $i < $data_2_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_2_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_2_pag["search-results"]["entry"][$i]["dc:creator"];
                  $publicacion =$data_2_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "", $publicacion);
                  $publicacion = str_replace(")", "", $publicacion); 
                  $publicacion = str_replace("'", "", $publicacion);
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
                  $enlace_preview = $data_2_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_2_pag["search-results"]["entry"][$i]["link"][3]["@href"];

                  $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')';                                                                                  
                 
                 mysql_query($insert) or die(mysql_error()); 

                 //echo "Entrada número ",$i," almacenada<br>";
              }




        }

        if($entradasTotales >= 50){
          if($entradasTotales < 75) {$cuenta=$entradasTotales-50;}
            //$consulta_3_pag = array($data_2_pag["search-results"]["link"][3]["@href"]);  // link a la 3pagina de resultados
            $consulta_3_pag = array($json_stringtema,'&start=50&count=',$cuenta);
            $json_string_3_pag=implode("", $consulta_3_pag);      
            echo " <a href='",$json_string_3_pag,"'> URL de la 3ª pagina de resultados </a> <br>";
            $data_3_pag = json_decode(file_get_contents($json_string_3_pag),true);


             //echo "<p> Almacenamos la 3 pagina en la BD </p>";
            for($i = 0; $i < $data_3_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_3_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_3_pag["search-results"]["entry"][$i]["dc:creator"];
                  $publicacion =$data_3_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "", $publicacion);
                  $publicacion = str_replace(")", "", $publicacion); 
                  $publicacion = str_replace("'", "", $publicacion);
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
                  $enlace_preview = $data_3_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_3_pag["search-results"]["entry"][$i]["link"][3]["@href"];

                  $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')';                                                                                  
                  
                  mysql_query($insert) or die(mysql_error()); 

                 //echo "Entrada de la 3PAG número ",$i," almacenada<br>";
              }



        }

        if($entradasTotales >= 75){
          if($entradasTotales < 100) {$cuenta=$entradasTotales-75;}
            //$consulta_4_pag = array($data_3_pag["search-results"]["link"][3]["@href"]);  // link a la 4 pagina de resultados
            $consulta_4_pag = array($json_stringtema,'&start=75&count=',$cuenta);
            $json_string_4_pag=implode("", $consulta_4_pag);        
            echo " <a href='",$json_string_4_pag,"'> URL de la 4ª pagina de resultados </a> <br>";
            $data_4_pag = json_decode(file_get_contents($json_string_4_pag),true);

             //echo "<p> Almacenamos la 4 pagina en la BD </p>";
            for($i = 0; $i < $data_4_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_4_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_4_pag["search-results"]["entry"][$i]["dc:creator"];
                  $publicacion =$data_4_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "", $publicacion);
                  $publicacion = str_replace(")", "", $publicacion); 
                  $publicacion = str_replace("'", "", $publicacion);
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
                  $enlace_preview = $data_4_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_4_pag["search-results"]["entry"][$i]["link"][3]["@href"];

                  $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')';                                                                                  
                  
                  mysql_query($insert) or die(mysql_error()); 

                 //echo "Entrada de la 4PAG número ",$i," almacenada<br>";
              }



        }

        if($entradasTotales >= 100){
          if($entradasTotales < 125) {$cuenta=$entradasTotales-100;}
             // link a la 5 pagina de resultados
            $consulta_5_pag = array($json_stringtema,'&start=100&count=',$cuenta);
            $json_string_5_pag=implode("", $consulta_5_pag);        
            echo " <a href='",$json_string_5_pag,"'> URL de la 5ª pagina de resultados </a> <br>";
            $data_5_pag = json_decode(file_get_contents($json_string_5_pag),true);


             //echo "<p> Almacenamos la 4 pagina en la BD </p>";
            for($i = 0; $i < $data_5_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
                  
                  $titulo = $data_5_pag["search-results"]["entry"][$i]["dc:title"];
                  $titulo = str_replace("'", "\'", $titulo);
                  $creador =$data_5_pag["search-results"]["entry"][$i]["dc:creator"];
                  $publicacion =$data_5_pag["search-results"]["entry"][$i]["prism:publicationName"];
                  $publicacion = str_replace("(", "", $publicacion);
                  $publicacion = str_replace(")", "", $publicacion); 
                  $publicacion = str_replace("'", "", $publicacion);
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
                  $enlace_preview = $data_5_pag["search-results"]["entry"][$i]["link"][2]["@href"];
                  $enlace_citedby = $data_5_pag["search-results"]["entry"][$i]["link"][3]["@href"];

                  $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')';                                                                                  
                  
                  mysql_query($insert) or die(mysql_error()); 

                 //echo "Entrada de la 5PAG número ",$i," almacenada<br>";
              }






        }

        echo "<p> ------- </p>";




        //include_once('simple_html_dom.php');

        echo "<p> Mostramos de la BD </p>";

        $i=1;
        $consulta= "SELECT * FROM publicaciones";
                    
        $resultados=mysql_query($consulta,$conexion);   

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
          $muestradoi=$row['doi'];
          $muestraissn=$row['issn'];
          $muestracitedby=$row['enlace_citedby'];
          $muestraeid=$row['eid'];

        echo "<div style='border-style: solid; margin-bottom: 2px'>";

          echo "Entry number ".$i;
          $i++;
          echo " <p style='font-weight: bold;'> $muestratitulo </p> 
          <p> by $muestracreador ";
          if(strlen($muestraafil)){echo " of the affiliation $muestraafil in $muestraafil_ciudad ($muestraafil_pais) </p>";}
          else{echo "(No associated affiliation)  </p> ";}  
          echo "<p> Published in $muestrapublicacion ";
          if($muestravolumen!=0){echo"(volume $muestravolumen) ";}
          if($muestrarango!=0){echo "in the pages $muestrarango ";}
          if($muestrafecha!=0){echo "with cover date $muestrafecha ";}
          echo "</p>";

          echo "<p> Type $muestratipo: $muestrasubtipo </p>";

          echo"<p><a href=\"$muestraenlace&apiKey=$apikey\"> Link to Scopus PREVIEW </a></p>";

          echo" <a href=\"$muestracitedby\"><img src=\"http://api.elsevier.com/content/abstract/citation-count?doi=$muestradoi&httpAccept=image/jpeg&apiKey=$apikey\"></img> </a>";

          echo "<a href=\"http://www.sciencedirect.com/science/journal/$muestraissn\"><img src=\"http://api.elsevier.com/content/serial/title/issn/$muestraissn?view=coverimage&httpAccept=image/gif&apiKey=$apikey\"></img> </a>"; 
          
          echo"<p><a href='http://api.elsevier.com/content/search/scopus?query=refeid%28$muestraeid%29&apiKey=$apikey'> Link to Scopus Cites </a></p>";

        echo "</div><br>";
    
        }


        $phpaises = array(); 
        $consulta_paises= "SELECT afiliacion_pais FROM publicaciones";
        $resultados_paises=mysql_query($consulta_paises,$conexion);
        while ($row=mysql_fetch_array($resultados_paises)) {  
          $muestrapais=$row['afiliacion_pais'];
          $phpaises[]=$muestrapais;
        }
        

        $phpanios = array(); 
        $consulta_anios= "SELECT fecha_portada_0 FROM publicaciones ORDER BY `fecha_portada_0` ASC";
        $resultados_anios=mysql_query($consulta_anios,$conexion);
        while ($row=mysql_fetch_array($resultados_anios)) {  
          $phpanios[]=$row['fecha_portada_0'];
        }

        $phpautor = array(); 
        $consulta_autor= "SELECT nombre_publi FROM publicaciones ";
        $resultados_autor=mysql_query($consulta_autor,$conexion);
        while ($row=mysql_fetch_array($resultados_autor)) {  
          $phpautor[]=$row['nombre_publi'];
        }

      $borratodo= "DELETE FROM publicaciones";            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";
      

?>


<script>
        var hay_entradas = <?php echo json_encode($hay_entradas); ?>;
     

        //Copiamos el vector de paises que hemos calculado con php
        var listaPaises = <?php echo json_encode($phpaises); ?>; 

        //Contamos las veces que se repite cada país
        var counts = {};
        var counts = new Array();
        for(var i=0;i< listaPaises.length;i++){
          var key = listaPaises[i];
          counts[key] = (counts[key])? counts[key] + 1 : 1 ;       
        }


        // la función "unique" eliminará los elementos repetidos del array
        Array.prototype.unique=function(a){
          return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });
        listaPaises=listaPaises.unique()

        if(hay_entradas){ 
          //mostramos los paises
          document.write("<p>Paises y número de publicaciones recientes: </p>");
          for(index = 0; index < listaPaises.length; index++) {
              document.write(""+listaPaises[index]+": "+counts[listaPaises[index]]+"<br>");
          }
        } 



  //var hay_entradas = <?php echo json_encode($hay_entradas); ?>;
  if(hay_entradas){

    var listaAnios = <?php echo json_encode($phpanios); ?>;
    var soloAnios = {};
    var soloAnios = new Array();

    //Cogemos sólo el año de la fecha
    for(index = 0; index < listaAnios.length; index++) {
      var ss = listaAnios[index].split("-");
      soloAnios[index]=ss[0];
    }
    //Contamos las veces que se repite cada año
    var counts_anios = {};
    var counts_anios = new Array();
    for(var i=0;i< soloAnios.length;i++){
      var key = soloAnios[i];
      counts_anios[key] = (counts_anios[key])? counts_anios[key] + 1 : 1 ;       
    }

    // la función "unique" eliminará los elementos repetidos del array
    /*Array.prototype.unique=function(a){
      return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });*/
    soloAnios=soloAnios.unique()
}
</script>

    <script type="text/javascript">

    </script>



<script>
      google.load("visualization", "1", {packages:["geochart"]});
      google.setOnLoadCallback(drawRegionsMap);

      var data_paises;

      function drawRegionsMap() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Publicaciones'],
          [ listaPaises[0] , counts[listaPaises[0]] ],
          [ listaPaises[1] , counts[listaPaises[1]] ],
          [ listaPaises[2] , counts[listaPaises[2]] ],
          [ listaPaises[3] , counts[listaPaises[3]] ],
          [ listaPaises[4] , counts[listaPaises[4]] ],
          [ listaPaises[5] , counts[listaPaises[5]] ],
          [ listaPaises[6] , counts[listaPaises[6]] ],
          [ listaPaises[7] , counts[listaPaises[7]] ],
          [ listaPaises[8] , counts[listaPaises[8]] ],
          [ listaPaises[9] , counts[listaPaises[9]] ],
          [ listaPaises[10] , counts[listaPaises[10]] ],
          [ listaPaises[11] , counts[listaPaises[11]] ],
          [ listaPaises[12] , counts[listaPaises[12]] ],
          [ listaPaises[13] , counts[listaPaises[13]] ],
          [ listaPaises[14] , counts[listaPaises[14]] ],
          [ listaPaises[15] , counts[listaPaises[15]] ],
          [ listaPaises[16] , counts[listaPaises[16]] ],
          [ listaPaises[17] , counts[listaPaises[17]] ],
          [ listaPaises[18] , counts[listaPaises[18]] ],
          [ listaPaises[19] , counts[listaPaises[19]] ],
          [ listaPaises[20] , counts[listaPaises[20]] ],
          [ listaPaises[21] , counts[listaPaises[21]] ],
          [ listaPaises[22] , counts[listaPaises[22]] ],
          [ listaPaises[23] , counts[listaPaises[23]] ],
          [ listaPaises[24] , counts[listaPaises[24]] ],
          [ listaPaises[25] , counts[listaPaises[25]] ],
          [ listaPaises[26] , counts[listaPaises[26]] ],
          [ listaPaises[27] , counts[listaPaises[27]] ],
          [ listaPaises[28] , counts[listaPaises[28]] ],
          [ listaPaises[29] , counts[listaPaises[29]] ],
          [ listaPaises[30] , counts[listaPaises[30]] ],
          [ listaPaises[31] , counts[listaPaises[31]] ],
          [ listaPaises[32] , counts[listaPaises[32]] ],
          [ listaPaises[33] , counts[listaPaises[33]] ],
          [ listaPaises[34] , counts[listaPaises[34]] ],
          [ listaPaises[35] , counts[listaPaises[35]] ],
          [ listaPaises[36] , counts[listaPaises[36]] ],
          [ listaPaises[37] , counts[listaPaises[37]] ],
          [ listaPaises[38] , counts[listaPaises[38]] ],
          [ listaPaises[39] , counts[listaPaises[39]] ],
          [ listaPaises[40] , counts[listaPaises[40]] ],
          [ listaPaises[41] , counts[listaPaises[41]] ],
          [ listaPaises[42] , counts[listaPaises[42]] ],
          [ listaPaises[43] , counts[listaPaises[43]] ],
          [ listaPaises[44] , counts[listaPaises[44]] ],
          [ listaPaises[45] , counts[listaPaises[45]] ],
          [ listaPaises[46] , counts[listaPaises[46]] ],
          [ listaPaises[47] , counts[listaPaises[47]] ],
          [ listaPaises[48] , counts[listaPaises[48]] ],
          [ listaPaises[49] , counts[listaPaises[49]] ]

        ]);

        data_paises = data;

        var options = {colorAxis: {colors: ['#aacd9f', '#299f2e']}, keepAspectRatio: 'true',width: '100%'};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }

      // DONUT
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        //  =
        var data = data_paises;

        var options = {
          title: 'Contribución por pais',
          pieHole: 0.4,
          keepAspectRatio: 'true', width: '100%'
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }


      if(hay_entradas){ 
         document.write('<div id="regions_div" style="max-width:100%; height: 500px"></div>');
         document.write('<div id="donutchart" style="max-width: 100%; height: 500px;"></div>');
      }   


</script>





<script>
if(hay_entradas){ 
    //mostramos los años
    document.write("<p>Años y número de publicaciones : </p>");
    for(index = 0; index < soloAnios.length; index++) {
      document.write("Año "+soloAnios[index]+": "+counts_anios[soloAnios[index]]+" publicaciones<br>");
    }

    $(function () {
        $('#container_columns').highcharts({
            chart: {
                type: 'column',
                margin: 75,
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: 'Número de publicaciones por año'
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                //categories: Highcharts.getOptions().lang.shortMonths
                categories: [soloAnios[0], soloAnios[1], soloAnios[2], soloAnios[3], soloAnios[4], soloAnios[5], soloAnios[6], soloAnios[7], soloAnios[8], soloAnios[9], soloAnios[10], soloAnios[11], soloAnios[12], soloAnios[13], soloAnios[14], soloAnios[15], soloAnios[16], soloAnios[17], soloAnios[18], soloAnios[19], soloAnios[20], soloAnios[21], soloAnios[22], soloAnios[23], soloAnios[24], soloAnios[25] ],
                title: {
                    text: 'Años'
                }

            },
            yAxis: {
                title: {
                    text: 'Publicaciones'
                }
            },
            series: [{
                name: 'Número de publicaciones',
                data: [counts_anios[soloAnios[0]], counts_anios[soloAnios[1]], counts_anios[soloAnios[2]], counts_anios[soloAnios[3]], counts_anios[soloAnios[4]], counts_anios[soloAnios[5]], counts_anios[soloAnios[6]], counts_anios[soloAnios[7]], counts_anios[soloAnios[8]], counts_anios[soloAnios[9]], counts_anios[soloAnios[10]], counts_anios[soloAnios[11]], counts_anios[soloAnios[12]], counts_anios[soloAnios[13]], counts_anios[soloAnios[14]], counts_anios[soloAnios[15]], counts_anios[soloAnios[16]], counts_anios[soloAnios[17]], counts_anios[soloAnios[18]], counts_anios[soloAnios[19]], counts_anios[soloAnios[20]], counts_anios[soloAnios[21]], counts_anios[soloAnios[22]], counts_anios[soloAnios[23]], counts_anios[soloAnios[24]], counts_anios[soloAnios[25]]]
                
            }
            ]

        });
    });



  document.write('<div id="container_columns" style="height: 400px"></div>');

}
</script>




<form>
    <input type="submit" value="Borrar BD publicaciones" formaction="borra_publicaciones.php">
</form>


      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>



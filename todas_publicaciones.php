<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    <link rel="icon" href="BibliometricAnalyzer_icon.png"> 
    <!-- Consulta la licencia en el documento LICENSE -->
    <title>BibliometricAnalyzer: all the publications</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/estilo.css" rel="stylesheet">

    <!-- Alertas personalizadas "SweetAlert"-->
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">

    <script language=JavaScript>
      function cargada() {
        swal({
          type: "success",
          title: "",
          text: "All the publications are loaded ",
          confirmButtonColor: "#8FBC8F",
          confirmButtonText: "See the publications",
        }); 
      }
      function espera() {
        swal({
          title: "Loading publications",
          text: "Please, wait the alert ",
          imageUrl: "img/BibliometricAnalyzer.png",
          showConfirmButton: false, 
          timer:5000
        }); 
      }
    </script>
  </head>

  <body onLoad="cargada()">

    <nav class="navbar navbar-inverse navbar-static-top" > 
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" >BibliometricAnalyzer by JCristobal</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.html">Home</a></li>
            <li><a href="https://github.com/JCristobal/BibliometricAnalyzer">About</a></li>
          </ul>
        </div>
      </div> 
    </nav>

    <div class="container">

      <div class="template">


<?php

    error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP   

    //cargamos los datos de la consulta original
    $autor2 = $_GET['consultaA2'];
    $autor = $_GET['consultaA1'];

    $tema = $_GET['consultaT1'];
    $palabra = $_GET['consultaT2'];
    $titulo = $_GET['consultaT3'];
    $fecha0 = $_GET['consultaT4'];
    $fecha1 = $_GET['consultaT5'];

    $hay_tema=false;
    $hay_palabra=false;
    $hay_titulo=false;
    if(strlen($tema)){ $hay_tema=true;}
    if(strlen($palabra)){ $hay_palabra=true;}
    if(strlen($titulo)){ $hay_titulo=true;}


    include_once('funciones.php');

    $autor = iso2utf($autor);
    $autor2 = iso2utf($autor2);
    $palabra = iso2utf($palabra);
    $titulo = iso2utf($titulo);

    include'generaApiKey.php';

    //Consulta de todas las publicaciones en el análisis de un tema
    $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')&apiKey=',$apikey,'&httpAccept=application/json');
        
    if($hay_tema){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_palabra){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20KEY(',$palabra,')&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_titulo){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_tema && $hay_palabra){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20KEY(',$palabra,')%20AND%20SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_tema && $hay_titulo){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20TITLE("',$titulo,'")%20AND%20SUBJAREA(',$tema,')&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_palabra && $hay_titulo){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20KEY(',$palabra,')%20AND%20TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
    }
    if($hay_tema && $hay_palabra && $hay_titulo){
        $consulta = array('http://api.elsevier.com:80/content/search/scopus?query=(PUBYEAR%3C',$fecha1,')%20and%20(PUBYEAR%3E',$fecha0,')%20and%20KEY(',$palabra,')%20AND%20SUBJAREA(',$tema,')%20AND%20TITLE("',$titulo,'")&apiKey=',$apikey,'&httpAccept=application/json');     
    }

    //Consulta de todas las publicaciones en el análisis de un autor      
    if(strlen($autor2)){
      $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 
    }

    $idConsulta = mt_rand();

    include'conexion.php'; 

    include 'almacena_publicaciones.php';   // ALMACENAMOS EN LA BD las publicaciones

    echo "<h1 class='text-center'> Showing a total of $entradasTotales entries </h1>";


/*

Mostraremos todas las entradas de las publicaciones que se ajusten a los datos introducimos para el análisis original

*/


        $i=0;

        $consulta_publicaciones= "SELECT * FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` DESC";
      
        $resultados=mysql_query($consulta_publicaciones,$conexion); 


        while ($row=mysql_fetch_array($resultados))  {   
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
          $muestraissn=$row['issn'];
          $muestracoautores=$row['enlace_coautores'];
          $muestra_citas_publicaciones=$row['citas'];
          
          if(($i%2)==0){echo "<div class='content-section-a'>";} // Alternamos la clase según las entradas
          else{echo"<div class='content-section-b'>";}  

          echo "<div class='entrada'>";
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


        //Borramos los datos de la consulta
        $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
        mysql_query($borratodo) or die(mysql_error()); 


?>

      </div>

  <p class="footer"> <a href="mailto:tobas92@gmail.com"> JCristobal </a></p>
  
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>



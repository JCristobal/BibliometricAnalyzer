<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    

    <title>BibliometricAnalyzer: all the publications</title>

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

  <script src="js/pace.min.js"></script>
  <link href="css/pace_style.css" rel="stylesheet" />

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">BibliometricAnalyzer by JCristobal</a>
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

    $idConsulta = $_GET['consulta'];
    $cantidadEntradas = $_GET['cantidad'];



    echo "<h1 style='text-align:center'> Showing a total of $cantidadEntradas entries </h1>";


/*

Mostraremos todas las entradas de las publicaciones que se ajusten a la consulta dada (con $idConsulta)

*/

      include'conexion.php'; 
      include'generaApiKey.php';

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
          $muestraeid=$row['eid'];
          $muestraissn=$row['issn'];
          $muestracoautores=$row['enlace_coautores'];

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

            echo $coautores[0]."<form style =\"float: left; margin: 0px;\">By<input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautores[0]\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\"> $coautores[0]</button></form>";

            for($cont=1; $cont<count($coautores); $cont++){
              echo "<form style =\"float: left; margin: 0px;\"><input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =\"$coautores[$cont]\"><button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\"> $coautores[$cont]</button></form>";
            }
          }
          
          if($contectado){echo "</p><p style=\"clear: left\">";}
          else{echo "<p>By $muestracreador (to see all authors have to be registered in Scopus)";} //Si no estamos en una red de Scopus sólo podemos consultar el primer autor de la publicación (campo "creator")

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

        echo "</div>  </div>"; // final de entrada y content-section-a/b
   
    
        }




        $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
        mysql_query($borratodo) or die(mysql_error()); 
        ///echo "<p> Borrados los datos de la BD </p>";



?>

      </div>

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



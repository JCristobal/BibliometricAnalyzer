<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    

    <title>Consulta</title>

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
          <a class="navbar-brand" href="#">Consultor básico bibliométrico</a>
        </div>  
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="https://github.com/JCristobal">About</a></li>
            <li><a href="mailto:tobas92@gmail.com">Contact</a></li>
          </ul>
        </div>   
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">


<?php

        
      if($_POST['busqueda_tema']){

        $tema = $_POST['busqueda_tema'];

        echo "<h1>Consulta  bibliométrica sobre ".$tema." </h1>";

        switch ($tema) {
          case "Química":
              $tema="CHEM";
          case "Artes y Humanidades":
              $tema="ARTS";
          case "Bioquímica, genética y biología molecular":
              $tema="BIOC";
          case "Agricultura y ciencias biológicas":
              $tema="AGRI";
          case "Empresas , Administración y Contabilidad":
              $tema="BUSI";    
          case "Ingeniería Química":
              $tema="CENG"; 
          case "Ciencias de la Computación":
              $tema="COMP"; 
          case "Teoría de la decisión":
              $tema="DECI"; 
          case "Odontología":
              $tema="DENT"; 
          case "Ciencia de la Tierra y Planetarias":
              $tema="EART"; 
          case "Economía, Econometría y Finanzas":
              $tema="ECON"; 
          case "Energía":
              $tema="ENER"; 
          case "Ingeniería":
              $tema="ENGI"; 
          case "Ciencias Medioambientales":
              $tema="ENVI"; 
          case "Salud":
              $tema="HEAL"; 
          case "Inmunología y Microbiología":
              $tema="INMU"; 
          case "Ciencia de los Materiales":
              $tema="MATE"; 
          case "Matemáticas":
              $tema="MATH"; 
          case "Medicina":
              $tema="MEDI"; 
          case "Neurociencia":
              $tema="NEUR"; 
          case "Enfermería":
              $tema="NURS"; 
           case "Farmacología, Toxicología y Farmacia":
              $tema="PHAR";                      
          case "Física y Astronomía":
              $tema="FHYS"; 
          case "Psicología":
              $tema="PSYC"; 
          case "Ciencias Sociales":
              $tema="SOCI"; 
          case "Veterinaria":
              $tema="VETE"; 
          case "Multidisciplinar":
              $tema="MULT"; 
        }
      


        echo" <p>¿No quieres buscar esto? <a href=\"index.html\">Vuelve atrás </a> </p>";

        $consultatema = array('http://api.elsevier.com:80/content/search/scopus?query=SUBJAREA(',$tema,')&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');     
        $json_stringtema=implode("", $consultatema); 
        $datatema = json_decode(file_get_contents($json_stringtema),true);

        echo " <a href='",$json_stringtema,"'> URL de consulta del tema  </a>";

        echo "<p> ------- </p>";

        echo " Número de resultados: " .$datatema["search-results"]["opensearch:totalResults"] ,"<br><br>";


         for($i = 0; $i < $datatema["search-results"]["opensearch:itemsPerPage"]; $i++){
            echo "Entrada número ",$i,"<br>";

            echo "Título: " .$datatema["search-results"]["entry"][$i]["dc:title"],"<br>";
            echo "Creador: " .$datatema["search-results"]["entry"][$i]["dc:creator"],"<br>";
            echo "Publicación: " .$datatema["search-results"]["entry"][$i]["prism:publicationName"],"<br>";
            echo "Rango de páginas: " .$datatema["search-results"]["entry"][$i]["prism:pageRange"],"<br>";
            echo "Fecha de tapa: " .$datatema["search-results"]["entry"][$i]["prism:coverDisplayDate"],"<br>";
            echo "Tipo de trabajo: " .$datatema["search-results"]["entry"][$i]["subtypeDescription"],"<br><br><br>";
            
        }


        echo "<p> resultados de la SEGUNDA PAGINA  </p>";

        $consulta_2_pag = array($datatema["search-results"]["link"][2]["@href"]);  // link a la segunda pagina de resultados
        $json_string_2_pag=implode("", $consulta_2_pag); 
        
        echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina  </a>";

        $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);

        echo "<p> ------- </p>";
         for($i = 0; $i < $data_2_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
            echo "Entrada número ",$i+25,"<br>";

            echo "Título: " .$data_2_pag["search-results"]["entry"][$i]["dc:title"],"<br>";
            echo "Creador: " .$data_2_pag["search-results"]["entry"][$i]["dc:creator"],"<br>";
            echo "Publicación: " .$data_2_pag["search-results"]["entry"][$i]["prism:publicationName"],"<br>";
            echo "Rango de páginas: " .$data_2_pag["search-results"]["entry"][$i]["prism:pageRange"],"<br>";
            echo "Fecha de tapa: " .$data_2_pag["search-results"]["entry"][$i]["prism:coverDisplayDate"],"<br>";
            echo "Tipo de trabajo: " .$data_2_pag["search-results"]["entry"][$i]["subtypeDescription"],"<br><br><br>";
            
        }
      }

?>


        <h1>Consulta  bibliométrica de  <?php  $autor = $_POST['busqueda_basica'];  echo $autor;  ?>  </h1>


      <?php
        echo " <form name=\"ejemplo3\" action=\"http://api.elsevier.com:80/content/search/scopus?query=",$autor,"&apiKey=c0dee35412af407a9c07b4fabc7bc447\" method=\"POST\">
          <p class=\"lead\">Continúa para buscar <b>",$autor,"</b> con Scopus </p>
          <input type=\"submit\" value=\"Buscar el XML\">
        </form> ";
      ?>


	   <p>¿No quieres buscar esto? <a href="index.html">Vuelve atrás </a> </p>

     <?php
 
        echo "<p> ---------- CONSULTA A SCOPUS ----------  </p>";

        $consulta = array('http://api.elsevier.com/content/search/scopus?query=', $autor, '&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');     
        // $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(', $autor, ')&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');     
        $json_string=implode("", $consulta); 
        
        echo " <a href='",$json_string,"'> URL de consulta  </a>";

        //echo "<br><p> JSON sin parsear: </p>";


        //$data = json_decode(preg_replace('/^t\(/', '', preg_replace('/\)$/', '', file_get_contents($json_string))));
        $data = json_decode(file_get_contents($json_string),true);
        //print_r($data);

        echo "<p> ------- </p>";

        echo " Número de resultados: " .$data["search-results"]["opensearch:totalResults"] ,"<br><br>";


         for($i = 0; $i < $data["search-results"]["opensearch:itemsPerPage"]; $i++){
            echo "Entrada número ",$i,"<br>";

            echo "Título: " .$data["search-results"]["entry"][$i]["dc:title"],"<br>";
            echo "Creador: " .$data["search-results"]["entry"][$i]["dc:creator"],"<br>";
            echo "Publicación: " .$data["search-results"]["entry"][$i]["prism:publicationName"],"<br><br><br>";
            
        }

        echo "<p> resultados de la SEGUNDA PAGINA  </p>";

        $consulta_2_pag = array($data["search-results"]["link"][2]["@href"]);  // link a la segunda pagina de resultados
        $json_string_2_pag=implode("", $consulta_2_pag); 
        
        echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina  </a>";

        $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);

        echo "<p> ------- </p>";
         for($i = 0; $i < $data_2_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
            echo "Entrada número ",$i+25,"<br>";

            echo "Título: " .$data_2_pag["search-results"]["entry"][$i]["dc:title"],"<br>";
            echo "Creador: " .$data_2_pag["search-results"]["entry"][$i]["dc:creator"],"<br>";
            echo "Publicación: " .$data_2_pag["search-results"]["entry"][$i]["prism:publicationName"],"<br><br><br>";
            
        }



/*
        echo "<p> ---------- CONSULTA A GOOGLE ACADEM.----------  </p>";

        include_once('simple_html_dom.php');           // simple_html_dom  http://simplehtmldom.sourceforge.net/

        $consulta2 = array('http://scholar.google.es/citations?view_op=search_authors&mauthors=autor:', $autor, '&hl=es&oi=ao');     
        $string2=implode("", $consulta2); 
        print_r($string2);
        echo "( <a href='",$string2,"'> URL de consulta  </a> )";

        // Create DOM from URL or file
        $html = file_get_html($string2);

        echo "<p> ------- </p> <p> Imágenes </p>";

        // Find all images
        foreach($html->find('img') as $element)
               echo ' <img src="http://scholar.google.es' . $element->src . '" </img> <br>';

*/
/*
      include'conexion.php'; 

      require("conexion.php");

      echo "<p> Almacenamos en la BD </p>";

      for($i = 0; $i < $data["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data["search-results"]["entry"][$i]["dc:title"];
            $creador =$data["search-results"]["entry"][$i]["dc:creator"];
            $publicacion =$data["search-results"]["entry"][$i]["prism:publicationName"];
            $publicacion = str_replace("(", "", $publicacion);
            $publicacion = str_replace(")", "", $publicacion); 
            $publicacion = str_replace("'", "", $publicacion);

           $insert = 'INSERT INTO prueba1(titulo, creador, publicacion) VALUES (\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\')';
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

            echo "Entrada número ",$i," almacenada<br>";
        }


        echo "<p> Mostramos de la BD </p>";

        $consulta= "SELECT * FROM prueba1";
                    
        $resultados=mysql_query($consulta,$conexion);   

        while ($row=mysql_fetch_array($resultados)) {   
          $muestratitulo=$row['titulo']; 
          $muestracreador=$row['creador']; 
          $muestrapublicacion=$row['publicacion']; 
          echo " <p> Titulo: $muestratitulo del creador: $muestracreador  </p> <p> $muestrapublicacion </p> <br><br>";
        }


      $borratodo= "DELETE FROM prueba1";            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";
*/
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



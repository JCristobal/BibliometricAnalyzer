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

        $autor = $_POST['busqueda_basica_autor'];

        echo "<h1>Consulta  bibliométrica";

        if(strlen($autor)){ echo " del autor ".$autor; }

        echo "</h1>";

        $autor = str_replace(" ", "%20", $autor);
                // TILDES
        // TILDES
        // TILDES
        // TILDES
        // TILDES

?>


	   <p>¿No quieres buscar esto? <a href="index.html">Vuelve atrás </a> </p>

     <?php
 
      //  error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP    

/*
        echo "<p> ---------- CONSULTA A SCOPUS ----------  </p>";

        //$consulta = array('http://api.elsevier.com/content/search/scopus?query=', $palabra, '&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');     
         $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(', $autor, ')&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');     
        $json_string=implode("", $consulta); 
        
        echo " <a href='",$json_string,"'> URL de consulta  </a>";

        $data = json_decode(file_get_contents($json_string),true);




        $consulta_2_pag = array($data["search-results"]["link"][2]["@href"]);  // link a la segunda pagina de resultados
        $json_string_2_pag=implode("", $consulta_2_pag); 
        
        echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina  </a>";

        $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);



        echo "<p> ------- </p>";

        echo " Número de resultados: " .$data["search-results"]["opensearch:totalResults"] ,"<br><br>";

*/

        echo "<p> ---------- CONSULTA A GOOGLE ACADEM.----------  </p>";

        include_once('simple_html_dom.php');           // simple_html_dom  http://simplehtmldom.sourceforge.net/

        $consulta2 = array('http://scholar.google.es/citations?view_op=search_authors&mauthors=autor:', $autor, '&hl=es&oi=ao');     
        $string2=implode("", $consulta2); 
        
        echo "( <a href='",$string2,"'> URL de consulta  </a> )";

        // Create DOM from URL or file
        $html = file_get_html($string2);



        echo "<p> ------- </p> ";

        $listaFotos = array();
        foreach($html->find('img') as $element){
               $foto = array('<img src="http://scholar.google.es',$element->src,'" </img>');
               $foto=implode("", $foto); 
               //echo $foto."<br>";
               $listaFotos[]= $foto ;
               
        }
        //
        $listaAutores = array(); 
        foreach($html->find('div.gsc_1usr_text h3 a') as $elemento){
               $author = array('http://scholar.google.es',$elemento->href);
               $author=implode("", $author); 
               //echo "<p> <a href='".$author."'> Enlace al autor </a></p>";
               $listaAutores[]= $author;
               
        }

        $listaNombres = array(); 
        foreach($html->find('div.gsc_1usr_text h3 a') as $elemento){
               echo $elemento->plaintext."<br>";
               $listaNombres[]= $elemento->plaintext;
               
        }


        
        
/*

      include'conexion.php'; 


      echo "<p> Almacenamos en la BD </p>";

      for($i = 0; $i < $data["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$data["search-results"]["entry"][$i]["dc:creator"];
            $publicacion =$data["search-results"]["entry"][$i]["prism:publicationName"];
            $publicacion = str_replace("(", "", $publicacion);
            $publicacion = str_replace(")", "", $publicacion); 
            $publicacion = str_replace("'", "", $publicacion);
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
            $enlace_preview = $data["search-results"]["entry"][$i]["link"][1]["@href"];


           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\')'; 
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }

      //echo "<p> Almacenamos la 2 pagina en la BD </p>";

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
            $enlace_preview = $data_2_pag["search-results"]["entry"][$i]["link"][1]["@href"];

           $insert = 'INSERT INTO publicaciones(id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview) VALUES (\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\')';
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }




        include_once('simple_html_dom.php');

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

          echo "Entrada número ".$i;
          $i++;
          echo " <p> Titulo: $muestratitulo del creador: $muestracreador  </p> <p> Publicado en $muestrapublicacion";
          if($muestravolumen!=0){echo" (volumen $muestravolumen) ";}
          echo "en las paginas $muestrarango y fecha de portada $muestrafecha</p> ";
          echo "";
          echo "<p> $muestratipo: $muestratipo </p>";
          if(strlen($muestraafil)){echo "<p> De la afiliación $muestraafil de $muestraafil_ciudad ($muestraafil_pais) </p>";}
          else{echo " <p> No tiene asociada una afiliación  </p> ";}
          echo"<p><a href=\"$muestraenlace\"> Enlace al PREVIEW de Scopus</a></p>";


          echo "<br><br>";      
        }

 */       
/*
      $borratodo= "DELETE FROM prueba1";            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";
*/

      ?>
    <h2> Autores que coincidan con ese nombre </h2>
    <script>
      //Copiamos los vectores  que hemos calculado con php
      var listaAut = <?php echo json_encode($listaAutores); ?>; 
      var listaFot = <?php echo json_encode($listaFotos); ?>; 
      var listaNom = <?php echo json_encode($listaNombres); ?>; 

      document.write("<p>Foto y autor: </p>");
      for(index = 0; index < listaAut.length; index++) {
          document.write("<div style='border-style: solid; margin-bottom: 2px'>");
          //document.write("<img src=\"http://scholar.google.es"+listaFot[index]+"\" </img> " );
          //document.write("<p><a href='http://scholar.google.es"+listaAut[indice]+"\'> Enlace al autor</a></p>");
          document.write(listaFot[index]);
          document.write(listaNom[index]);
          
          document.write('<form> <input type="text" name="busqueda_autor" style ="visibility: hidden; display: inline;" value ="'+listaNom[index]+'"> <input type="text" name="busqueda_autor_enlace" style ="visibility: hidden; display: inline;" value ="'+listaAut[index]+'"> <br> <button type="submit" formmethod="post" formaction="busqueda_autor.php" class="btn btn-default">Info sobre el autor</button></form>');
          
          document.write("<p> <a href='"+listaAut[index]+"'> Enlace al autor </a></p>");
          document.write("</div>");
      }  

    </script>
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



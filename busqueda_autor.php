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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/highcharts-3d.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>





  <script src="http://phuonghuynh.github.io/js/bower_components/d3/d3.min.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/d3-transform/src/d3-transform.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/extarray.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/misc.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/micro-observer.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/microplugin/src/microplugin.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/bubble-chart.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/central-click/central-click.js"></script>
  <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/lines/lines.js"></script>
   <style>
    .bubbleChart {
      min-width: 50px;
      max-width: 350px;
      height: 350px;
      margin: 0 auto;
    }
    .bubbleChart svg{
      background: #000000 ;
    }
  </style>





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

        $autor0 = $_POST['busqueda_autor'];
        $autor = $_POST['busqueda_autor'];
        $enlace_autor = $_POST['busqueda_autor_enlace'];

        // Formateamos de UTF a ASCII para mostrarlo
        $autor0 = str_replace("%20", " ", $autor0);
        $autor0 = str_replace("%C3%A1", "á", $autor0);
        $autor0 = str_replace("%C3%A9", "é", $autor0);
        $autor0 = str_replace("%C3%AD", "í", $autor0);
        $autor0 = str_replace("%C3%B3", "ó", $autor0);
        $autor0 = str_replace("%C3%BA", "ú", $autor0);
        $autor0 = str_replace("%2D", "-", $autor0);


        echo "<h1>Consulta  bibliométrica del autor ".$autor0."</h1>";

        echo "enlace a autor en G Escolar: ".$enlace_autor;

        // Formateamos de ASCII a UTF para trabajar con él
        $autor = str_replace(" ", "%20", $autor);
        $autor = str_replace("á", "%C3%A1", $autor);
        $autor = str_replace("é", "%C3%A9", $autor);
        $autor = str_replace("í", "%C3%AD", $autor);
        $autor = str_replace("ó", "%C3%B3", $autor);
        $autor = str_replace("ú", "%C3%BA", $autor);
        $autor = str_replace("-", "%2D", $autor);

        

?>


	   <p>¿No quieres buscar esto? <a href="index.html">Vuelve atrás </a> </p>

     <?php
 
        error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP    
        $apikey = "c0dee35412af407a9c07b4fabc7bc447";





        echo "<p> ---------- CONSULTA Al enlace -------  </p>";

        include_once('simple_html_dom.php');           // simple_html_dom  http://simplehtmldom.sourceforge.net/



        // Create DOM from URL or file
        $html = file_get_html($enlace_autor);

        echo "<p> imagen </p> ";

        $foto = "";

        foreach($html->find('img') as $element){
               $foto = array('<img src="http://scholar.google.es',$element->src,'" />');
               $foto=implode("", $foto); 
               echo $foto."<br>";
           
        }


        $datos = array(); 

        foreach($html->find('td.gsc_rsb_std') as $element){
               //echo $element->plaintext."<br>";
               $datos[]=$element->plaintext;
        }
        echo "<p> ".$datos[0]." citas </p> ";
        echo "<p> Desde 2010: ".$datos[1]." citas </p> ";
        echo "<p> indice H: ".$datos[2]." </p> ";
        echo "<p> indice H desde 2010: ".$datos[3]." </p> ";
        echo "<p> indice H10: ".$datos[4]." </p> ";
        echo "<p> indice H10 desde 2010: ".$datos[5]." </p> ";

        echo "<p> ------- </p> ";

        echo "Correo confirmado: ";
           foreach($html->find('#gsc_prf_ivh') as $element){
               echo $element."<br>";
        }

        echo "<p> ------- </p> ";

        echo "Coautores: <br>";
           foreach($html->find('.gsc_rsb_aa') as $element){

              // "extraigo" de la URL el ID del autor para ver su foto
              $img = substr($element->href, 11, 17);
              echo "<img src='http://scholar.google.es/citations?view_op=view_photo&amp;".$img."&amp;citpid=1'> </img>";

               echo $element->plaintext." y  <a href=\"http://scholar.google.es".$element->href."\"> enlace a GSCHOLAR </a>  ";   

              $element->plaintext = str_replace(" ", "%20", $element->plaintext);
              $element->plaintext = str_replace("á", "%C3%A1", $element->plaintext);
              $element->plaintext = str_replace("é", "%C3%A9", $element->plaintext);
              $element->plaintext = str_replace("í", "%C3%AD", $element->plaintext);
              $element->plaintext = str_replace("ó", "%C3%B3", $element->plaintext);
              $element->plaintext = str_replace("ú", "%C3%BA", $element->plaintext);

               echo " <form> <input type=\"text\" name=\"busqueda_autor\" style =\"visibility: hidden; width:1px; display: inline;\" value =".$element->plaintext."> <input type=\"text\" name=\"busqueda_autor_enlace\" style =\"visibility: hidden; width:1px; display: inline;\" value =http://scholar.google.es".$element->href."> <button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-default\">Info sobre el autor con este buscador</button></form><br>";
        }


//http://bl.ocks.org/phuonghuynh/54a2f97950feadb45b07
echo '  
<script>
$(document).ready(function () {
  var bubbleChart = new d3.svg.BubbleChart({
    supportResponsive: true,
    //container: => use @default
    size: 600,
    //viewBoxSize: => use @default
    innerRadius: 600 / 3.5,
    //outerRadius: => use @default
    radiusMin: 50,
    //radiusMax: use @default
    //intersectDelta: use @default
    //intersectInc: use @default
    //circleColor: use @default
    data: {
      items: [
        {text: "'.$autor0.'", count: "1"},
        {text: " Autor 2", count: "0"},
        {text: "Autor 3", count: "0"},
        {text: "Autor 4", count: "0"},
        {text: "Autor 5", count: "0"},
        {text: "Autor 6", count: "0"},
        {text: "Autor 7", count: "0"},
        {text: "Autor 8", count: "0"},
        {text: "Autor 9", count: "0"},
      ],
      eval: function (item) {return item.count;},
      classed: function (item) {return item.text.split(" ").join("");}
    },
    plugins: [
      {
        name: "central-click",
        options: {
          text: "(See more detail)",
          style: {
            "font-size": "12px",
            "font-style": "italic",
            "font-family": "Source Sans Pro, sans-serif",
            //"font-weight": "700",
            "text-anchor": "middle",
            "fill": "white"
          },
          attr: {dy: "65px"},
          centralClick: function() {
            //alert("Here is more details!!");
          }
        }
      },
      {
        name: "lines",
        options: {
          format: [
            {// Line #0
              textField: "count",
              classed: {count: true},
              style: {
                visibility: "hidden"
              },
              attr: {
                dy: "0px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            },
            {// Line #1
              textField: "text",
              classed: {text: true},
              style: {
                "font-size": "14px",
                "font-family": "Source Sans Pro, sans-serif",
                "text-anchor": "middle",
                fill: "white"
              },
              attr: {
                dy: "20px",
                x: function (d) {return d.cx;},
                y: function (d) {return d.cy;}
              }
            }
          ],
          centralFormat: [
            {// Line #0
              style: {"font-size": "30px"},
              attr: {visibility: "hidden"}
            },
            {// Line #1
              style: {"font-size": "50px"},
              attr: {dy: "40px"}
            }
          ]
        }
      }]
  });
});
</script>

<div class="bubbleChart"> </div>  ';















        echo "<p> ---------- CONSULTA A SCOPUS ----------  </p>";
       
        //$consulta_0 = array('http://api.elsevier.com/content/search/scopus?query=AUTH(', $autor, ')&apiKey',$apikey,'=&httpAccept=application/json');   
        $consulta_0 = array('http://api.elsevier.com/content/search/scopus?query=FIRSTAUTH(', $autor, ')&apiKey=',$apikey,'&httpAccept=application/json');           
        $json_string_0=implode("", $consulta_0); 
        
        echo " <a href='",$json_string_0,"'> URL de consulta  </a>";

        $data_0 = json_decode(file_get_contents($json_string_0),true);


/*
        echo "<p> ------- </p>";

        echo " Número de resultados: " .$data_0["search-results"]["opensearch:totalResults"] ," en los es el PRINCIPAL autor<br><br>";

        for($i = 0; $i < $data_0["search-results"]["opensearch:itemsPerPage"]; $i++){
            echo "Entrada número ",$i,"<br>";

            echo "Título: " .$data_0["search-results"]["entry"][$i]["dc:title"],"<br>";
            echo "Creador principal: " .$data_0["search-results"]["entry"][$i]["dc:creator"],"<br>";
            echo "Publicado en: " .$data_0["search-results"]["entry"][$i]["prism:publicationName"],"<br>";
            echo "Rango de páginas: " .$data_0["search-results"]["entry"][$i]["prism:pageRange"],"<br>";
            echo "Fecha de tapa: " .$data_0["search-results"]["entry"][$i]["prism:coverDisplayDate"],"<br>";
            echo "[Fecha de tapa]: " .$data_0["search-results"]["entry"][$i]["prism:coverDate"],"<br>";
            echo "ISSN: " .$data_0["search-results"]["entry"][$i]["prism:issn"]." y volumen ".$data_0["search-results"]["entry"][$i]["prism:volume"]."<br>";

            if(strlen($data_0["search-results"]["entry"][$i]["affiliation"][0]["@_fa"])){
              echo "Corresponde a la afiliación: " .$data_0["search-results"]["entry"][$i]["affiliation"][0]["affilname"]." de ".$data_0["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"]." (".$data_0["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"].") <br>";
            }
            else{ echo "No tiene asociada una afiliación <br>";}
            echo "Tipo de trabajo: " .$data_0["search-results"]["entry"][$i]["prism:aggregationType"].": ".$data_0["search-results"]["entry"][$i]["subtypeDescription"],"<br>";
            echo "<a href=\"".$data_0["search-results"]["entry"][$i]["link"][2]["@href"]."\">Enlace al PREVIEW</a> <br><br><br>";

        }
*/

        $consulta = array('http://api.elsevier.com/content/search/scopus?query=', $autor, '&apiKey=',$apikey,'&httpAccept=application/json');   
        //$consulta = array('http://api.elsevier.com/content/search/scopus?query=', $autor, '%20or%20FIRSTAUTH(', $autor, ')&apiKey=c0dee35412af407a9c07b4fabc7bc447&httpAccept=application/json');           
        $json_string=implode("", $consulta); 
        
        echo " <a href='",$json_string,"'> URL de consulta  </a>";

        $data = json_decode(file_get_contents($json_string),true);



      include'conexion.php'; 


      echo "<p> Almacenamos el autor </p>";


           $insert_autor = 'INSERT INTO autores(id,nombre, urlImagen, citas, citas_2010, h,h_2010, h10, h10_2010) VALUES (\''.$autor0.'\',\''.$autor0.'\',\''.$foto.'\',\''.$datos[0].'\',\''.$datos[1].'\',\''.$datos[2].'\',\''.$datos[3].'\',\''.$datos[4].'\',\''.$datos[5].'\')'; 
                                                                                  
           mysql_query($insert_autor) or die(mysql_error()); 

           echo "Autor almacenado<br>";
        

      echo "<p> Almacenamos las propias en la BD </p>";

      for($i = 0; $i < $data_0["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data_0["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$data_0["search-results"]["entry"][$i]["dc:creator"];
            $creador = str_replace("'", "", $creador);
            $publicacion =$data_0["search-results"]["entry"][$i]["prism:publicationName"];
            $publicacion = str_replace("(", "", $publicacion);
            $publicacion = str_replace(")", "", $publicacion); 
            $publicacion = str_replace("'", "", $publicacion);
            $rang_pag = $data_0["search-results"]["entry"][$i]["prism:pageRange"];
            $fecha_letra = $data_0["search-results"]["entry"][$i]["prism:coverDisplayDate"];
            $fecha = $data_0["search-results"]["entry"][$i]["prism:coverDate"];
            $tipo = $data_0["search-results"]["entry"][$i]["prism:aggregationType"];
            $subtipo = $data_0["search-results"]["entry"][$i]["subtypeDescription"];
            $issn = $data_0["search-results"]["entry"][$i]["prism:issn"];
            $volume = $data_0["search-results"]["entry"][$i]["prism:volume"];
            $id = $data_0["search-results"]["entry"][$i]["dc:identifier"]; 
            $eid = $data_0["search-results"]["entry"][$i]["eid"];
            $afil = $data_0["search-results"]["entry"][$i]["affiliation"][0]["affilname"];
            $afil = str_replace("'", "\'", $afil);
            $afil_ciudad = $data_0["search-results"]["entry"][$i]["affiliation"][0]["affiliation-city"];
            $afil_ciudad = str_replace("'", "\'", $afil_ciudad);
            $afil_pais = $data_0["search-results"]["entry"][$i]["affiliation"][0]["affiliation-country"];
            $doi = $data_0["search-results"]["entry"][$i]["prism:doi"];
            $enlace_preview = $data_0["search-results"]["entry"][$i]["link"][2]["@href"];
            $enlace_citedby = $data_0["search-results"]["entry"][$i]["link"][3]["@href"];

           $insert = 'INSERT INTO publicaciones(consulta, id, eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby, publi_propia) VALUES (\''.$autor0.'\',\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\',true)'; 
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }





      echo "<p> Almacenamos en la BD </p>";

      for($i = 0; $i < $data["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$data["search-results"]["entry"][$i]["dc:creator"];
            $creador = str_replace("'", "", $creador);
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
            $enlace_preview = $data["search-results"]["entry"][$i]["link"][2]["@href"];
            $enlace_citedby = $data["search-results"]["entry"][$i]["link"][3]["@href"];

           $insert = 'INSERT INTO publicaciones(consulta, id, eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$autor0.'\',\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')'; 
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }



        //$consulta_2_pag = array($data["search-results"]["link"][2]["@href"]);  // link a la segunda pagina de resultados
        $consulta_2_pag = array($json_string,'&start=25&count=25');
        $json_string_2_pag=implode("", $consulta_2_pag); 
        
        echo " <a href='",$json_string_2_pag,"'> URL de la 2ª pagina de resultados </a> <br>";

        $data_2_pag = json_decode(file_get_contents($json_string_2_pag),true);


      echo "<p> Almacenamos la 2 pagina en la BD </p>";

      for($i = 0; $i < $data_2_pag["search-results"]["opensearch:itemsPerPage"]; $i++){
            
            $titulo = $data_2_pag["search-results"]["entry"][$i]["dc:title"];
            $titulo = str_replace("'", "\'", $titulo);
            $creador =$data_2_pag["search-results"]["entry"][$i]["dc:creator"];
            $creador = str_replace("'", "", $creador);
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

           $insert = 'INSERT INTO publicaciones(consulta, id,eid, titulo, creador, nombre_publi, rango_pags,fecha_portada, fecha_portada_0, tipo_publi,subtipo_publi, issn, volumen, afiliacion_nombre, afiliacion_ciudad, afiliacion_pais, doi, enlace_preview, enlace_citedby) VALUES (\''.$autor0.'\',\''.$id.'\',\''.$eid.'\',\''.$titulo.'\',\''.$creador.'\',\''.$publicacion.'\',\''.$rang_pag.'\',\''.$fecha_letra.'\',\''.$fecha.'\',\''.$tipo.'\',\''.$subtipo.'\',\''.$issn.'\',\''.$volume.'\',\''.$afil.'\',\''.$afil_ciudad.'\',\''.$afil_pais.'\',\''.$doi.'\',\''.$enlace_preview.'\',\''.$enlace_citedby.'\')';
                                                                                  
           mysql_query($insert) or die(mysql_error()); 

           //echo "Entrada número ",$i," almacenada<br>";
        }



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
          $muestraenlace=$row['enlace_preview'];
          $muestradoi=$row['doi'];
          $muestracitedby=$row['enlace_citedby'];
          $muestraeid=$row['eid'];

      echo "<div style='border-style: solid; margin-bottom: 2px'>";

          echo "Entrada número ".$i; if($row['publi_propia']){echo "(Propia)";}
          $i++;
          echo " <p> Titulo: $muestratitulo del creador: $muestracreador  </p> <p> Publicado en $muestrapublicacion";
          if($muestravolumen!=0){echo" (volumen $muestravolumen) ";}
          echo "en las paginas $muestrarango y fecha de portada $muestrafecha</p> ";
          echo "";
          echo "<p> $muestratipo: $muestrasubtipo </p>";
          if(strlen($muestraafil)){echo "<p> De la afiliación $muestraafil de $muestraafil_ciudad ($muestraafil_pais) </p>";}
          else{echo " <p> No tiene asociada una afiliación  </p> ";}
          echo"<p><a href='$muestraenlace'> Enlace al PREVIEW de Scopus</a></p>";
          echo" <a href=\"$muestracitedby\"><img src=\"http://api.elsevier.com/content/abstract/citation-count?doi=$muestradoi&httpAccept=image/jpeg&apiKey=$apikey\"></img> </a>";
          echo"<p><a href='http://api.elsevier.com/content/search/scopus?query=refeid%28$muestraeid%29&apiKey=$apikey'> Enlace al CITAS de scopus</a></p>";
      echo "</div>";
      
//http://api.elsevier.com/documentation/AbstractCitationCountAPI.wadl
//http://api.elsevier.com/documentation/metadata/abstractCitationCountMeta.json
//http://www.scopus.com/results/citedbyresults.url?sort=plf-f&cite=2-s2.0-49549114022&src=s&imp=t&sid=EC4E03F932C14A3FE555B99C71AB440B.aXczxbyuHHiXgaIW6Ho7g%3a780&sot=cite&sdt=a&sl=0&origin=inward&editSaveSearch=&txGid=EC4E03F932C14A3FE555B99C71AB440B.aXczxbyuHHiXgaIW6Ho7g%3a77
//http://api.elsevier.com/content/search/scopus?query=refeid%282-s2.0-49549114022%29&apiKey=c0dee35412af407a9c07b4fabc7bc447          


        /*$html = file_get_html($muestraenlace);
        foreach($html->find('hr p.marginB3') as $elemento){
               echo $elemento->plaintext."<br>";           
        } */       


          echo "<br><br>";      
        }



        $phpanios_publi_propia = array(); 
        $consulta_anios_publi_propia= "SELECT fecha_portada_0 FROM publicaciones  WHERE `publi_propia` ORDER BY `fecha_portada_0` ASC";
        $resultados_anios_publi_propia=mysql_query($consulta_anios_publi_propia,$conexion);
        while ($row=mysql_fetch_array($resultados_anios_publi_propia)) {  
          $phpanios_publi_propia[]=$row['fecha_portada_0'];
        }


        $phpanios = array(); 
        $consulta_anios= "SELECT fecha_portada_0 FROM publicaciones ORDER BY `fecha_portada_0` ASC";
        $resultados_anios=mysql_query($consulta_anios,$conexion);
        while ($row=mysql_fetch_array($resultados_anios)) {  
          $phpanios[]=$row['fecha_portada_0'];
        }



    

      $borratodo= "DELETE FROM publicaciones";            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";



      ?>

      </div>


<script>
  var listaAnios_publi_propia = <?php echo json_encode($phpanios_publi_propia); ?>;
  var soloAnios_publi_propia = {};
  var soloAnios_publi_propia = new Array();

  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_publi_propia.length; index++) {
    var ss = listaAnios_publi_propia[index].split("-");
    soloAnios_publi_propia[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_publi_propia = {};
  var counts_publi_propia = new Array();
  for(var i=0;i< soloAnios_publi_propia.length;i++){
    var key = soloAnios_publi_propia[i];
    counts_publi_propia[key] = (counts_publi_propia[key])? counts_publi_propia[key] + 1 : 1 ;       
  }

  // la función "unique" eliminará los elementos repetidos del array
  Array.prototype.unique=function(a){
    return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
  });
  soloAnios_publi_propia=soloAnios_publi_propia.unique()

  //mostramos los años
  document.write("<p>Años y número de publicaciones recientes (PROPIAS): </p>");
  for(index = 0; index < soloAnios_publi_propia.length; index++) {
    document.write("Año "+soloAnios_publi_propia[index]+": "+counts_publi_propia[soloAnios_publi_propia[index]]+" publicaciones<br>");
  }
  document.write("<br><br>");



  var listaAnios = <?php echo json_encode($phpanios); ?>;
  var soloAnios = {};
  var soloAnios = new Array();

  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios.length; index++) {
    var ss = listaAnios[index].split("-");
    soloAnios[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts = {};
  var counts = new Array();
  for(var i=0;i< soloAnios.length;i++){
    var key = soloAnios[i];
    counts[key] = (counts[key])? counts[key] + 1 : 1 ;       
  }

  // la función "unique" eliminará los elementos repetidos del array
  Array.prototype.unique=function(a){
    return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
  });
  soloAnios=soloAnios.unique()

  //mostramos los años
  document.write("<p>Años y número de publicaciones  (en total): </p>");
  for(index = 0; index < soloAnios.length; index++) {
    document.write("Año "+soloAnios[index]+": "+counts[soloAnios[index]]+" publicaciones<br>");
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
            text: 'Número de publicaciones relacionadas'
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            //categories: Highcharts.getOptions().lang.shortMonths
            categories: [soloAnios[0], soloAnios[1], soloAnios[2], soloAnios[3], soloAnios[4], soloAnios[5], soloAnios[6], soloAnios[7], soloAnios[8], soloAnios[9], soloAnios[10], soloAnios[11], soloAnios[12]],
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
            data: [counts[soloAnios[0]], counts[soloAnios[1]], counts[soloAnios[2]], counts[soloAnios[3]], counts[soloAnios[4]], counts[soloAnios[5]], counts[soloAnios[6]], counts[soloAnios[7]], counts[soloAnios[8]], counts[soloAnios[9]], counts[soloAnios[10]], counts[soloAnios[11]], counts[soloAnios[12]]]
            
        }/*,
        {
            name: 'Publicaciones propias',                    
            data: [counts_publi_propia[soloAnios_publi_propia[0]], counts_publi_propia[soloAnios_publi_propia[1]], counts_publi_propia[soloAnios_publi_propia[2]], counts_publi_propia[soloAnios_publi_propia[3]], counts_publi_propia[soloAnios_publi_propia[4]], counts_publi_propia[soloAnios_publi_propia[5]], counts_publi_propia[soloAnios_publi_propia[6]], counts_publi_propia[soloAnios_publi_propia[7]], counts_publi_propia[soloAnios_publi_propia[8]], counts_publi_propia[soloAnios_publi_propia[9]], counts_publi_propia[soloAnios_publi_propia[10]], counts_publi_propia[soloAnios_publi_propia[11]], counts_publi_propia[soloAnios_publi_propia[12]]]
            
        }*/
        ]

    });
});
</script>




<div id="container_columns" style="height: 400px"></div>



    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>



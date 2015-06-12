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


  <script src="js/bubble-chart-utils.js"></script> 
  <script src="js/bubble-chart_lines.js"></script> 
  <script src="js/bubble-chart_central-click.js"></script> 
   <style>
    .bubbleChart {
      min-width: 60px;
      max-width: 100%;
      min-height: 60px;
      max-height: 100%;
      height: 420px;
      margin: 0 auto;
    }
    .bubbleChart svg{
      background: #FFFFFF ;
    }
  </style>



  <script src="js/pace.min.js"></script>
  <link href="css/pace_style.css" rel="stylesheet" />

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

        $autor_limpio = $_POST['busqueda_autor'];
        $autor = $_POST['busqueda_autor'];

        $autor_limpio2 = $_POST['busqueda_autor2'];
        $autor2 = $_POST['busqueda_autor2'];

        $enlace_autor = $_POST['busqueda_autor_enlace'];



        // Formateamos de UTF a ASCII para mostrarlo
        $autor_limpio = str_replace("%20", " ", $autor_limpio);
        $autor_limpio = str_replace("%C3%A1", "á", $autor_limpio);
        $autor_limpio = str_replace("%C3%A9", "é", $autor_limpio);
        $autor_limpio = str_replace("%C3%AD", "í", $autor_limpio);
        $autor_limpio = str_replace("%C3%B3", "ó", $autor_limpio);
        $autor_limpio = str_replace("%C3%BA", "ú", $autor_limpio);
        $autor_limpio = str_replace("%2D", "-", $autor_limpio);


        echo "<h1>Consulta  bibliométrica del autor ".$autor_limpio." ".$autor_limpio2."</h1>";

        echo "enlace a autor en G Escolar: ".$enlace_autor;

        // Formateamos de ASCII a UTF para trabajar con él
        $autor = str_replace(" ", "%20", $autor);
        $autor = str_replace("á", "%C3%A1", $autor);
        $autor = str_replace("é", "%C3%A9", $autor);
        $autor = str_replace("í", "%C3%AD", $autor);
        $autor = str_replace("ó", "%C3%B3", $autor);
        $autor = str_replace("ú", "%C3%BA", $autor);
        $autor = str_replace("-", "%2D", $autor);

        $autor2 = str_replace(" ", "%20", $autor2);
        $autor2 = str_replace("á", "%C3%A1", $autor2);
        $autor2 = str_replace("é", "%C3%A9", $autor2);
        $autor2 = str_replace("í", "%C3%AD", $autor2);
        $autor2 = str_replace("ó", "%C3%B3", $autor2);
        $autor2 = str_replace("ú", "%C3%BA", $autor2);
        $autor2 = str_replace("-", "%2D", $autor2);


?>


     <p>Did not you want to search this? <a href="index.html"> Go home </a> </p>

     <?php
 
        error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP    
        $apikey = "c0dee35412af407a9c07b4fabc7bc447";




        include_once('simple_html_dom.php');           // http://simplehtmldom.sourceforge.net/



        // Create DOM from URL or file
        $html = file_get_html($enlace_autor);

        $nombreGS = "";
        foreach($html->find('#gsc_prf_in') as $element){
               echo '<div style=" float: left;  margin: 2px 2px 2px 2px;"> <b>'.$element->plaintext.'</b><br>';
               $nombreGS = $element->plaintext;
        }


        $foto = "";
        foreach($html->find('img') as $element){
               $foto = array('<img src="http://scholar.google.es',$element->src,'" />');
               $foto=implode("", $foto); 
               echo $foto."<br> </div>";           
        }


        echo '<div style="float: left; margin: 15px 2px 2px 15px;"> Verified email: ';
           foreach($html->find('#gsc_prf_ivh') as $element){
               echo $element."<br>";
        }

        $phpafiliacion= array(); 
        echo "AFILIACION: ";
           foreach($html->find('div.gsc_prf_il') as $element){
               $phpafiliacion[]=$element->plaintext;
        }
        echo $phpafiliacion[0]."</div>";

        echo "<p style='clear: left;'> ------- </p> ";


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



        $coautores= array(); 

        echo '<div class="bubbleChart" style=" border-style: solid; border-width: 3px;  float: left;"> </div> ';

        echo '<div style=" border-style: solid; border-width: 3px;  float: left;">Coautores: <br>';
           foreach($html->find('.gsc_rsb_aa') as $element){

              // "extraigo" de la URL el ID del autor para ver su foto
              $img = substr($element->href, 11, 17);
              echo "<img src='http://scholar.google.es/citations?view_op=view_photo&amp;".$img."&amp;citpid=1'  height='15%' width='15%'> </img>";

              $coautores[]=$element->plaintext;
               
              echo $element->plaintext." y  <a href=\"http://scholar.google.es".$element->href."\"> enlace a GSCHOLAR </a>  ";   

              $element->plaintext = str_replace(" ", "%20", $element->plaintext);
              $element->plaintext = str_replace("á", "%C3%A1", $element->plaintext);
              $element->plaintext = str_replace("é", "%C3%A9", $element->plaintext);
              $element->plaintext = str_replace("í", "%C3%AD", $element->plaintext);
              $element->plaintext = str_replace("ó", "%C3%B3", $element->plaintext);
              $element->plaintext = str_replace("ú", "%C3%BA", $element->plaintext);

               echo " <form> <input type=\"text\" name=\"busqueda_autor\" style =\"visibility: hidden; width:1px; display: inline;\" value =".$element->plaintext."> <input type=\"text\" name=\"busqueda_autor_enlace\" style =\"visibility: hidden; width:1px; display: inline;\" value =http://scholar.google.es".$element->href."> <button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-default\">Info sobre el autor con este buscador</button></form><br>";
        }
        echo "</div>";

if(count($coautores)!=0){
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
            {text: "'.$nombreGS.'", count: "1"},';

          if(count($coautores)>=11){
            for ($i = 0; $i <11; $i++) { //foreach ($coautores as $v) {
                echo '{text: "'.$coautores[$i].'", count: "0"},';
            }
          }
          else{
              for ($i = 0; $i < count($coautores); $i++) { //foreach ($coautores as $v) {
                  echo '{text: "'.$coautores[$i].'", count: "0"},';
              } 
          }

     echo ' ],
          eval: function (item) {return item.count;},
          classed: function (item) {return item.text.split(" ").join("");}
        },
        plugins: [
            {
                name: "central-click",
                options: {
                  style: {
                    "font-size": "12px",
                    "font-style": "italic",
                    "font-family": "Source Sans Pro, sans-serif",
                    //"font-weight": "700",
                    "text-anchor": "middle",
                    "fill": "white"
                  },
                  attr: {dy: "65px"}/*,
                  centralClick: function() {
                    alert("Here is more details!!");
                  }*/
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
                    fill: "black"
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
                  style: {"font-size": "3px"},
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

     ';
}
else{echo "Without coauthors registered";}

echo "<p style='clear: left;'> ----- </p>";

echo '<div id="container_columns" style="height: 400px"></div>';


        echo "<p> ---------- CONSULTA A SCOPUS del autor ".$autor_limpio." ".$autor_limpio2."----------  </p>";
/*
        //$consulta_0 = array('http://api.elsevier.com/content/search/scopus?query=FIRSTAUTH(', $autor, ')&apiKey=',$apikey,'&httpAccept=application/json'); 
        $consulta_0 = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json');     
        //$consulta_0 = array('http://api.elsevier.com/content/search/scopus?query=', $autor, '&apiKey=',$apikey,'&httpAccept=application/json');         
        $json_string_0=implode("", $consulta_0); 
        
        echo " <a href='",$json_string_0,"'> URL de consulta  </a>";

        $data_0 = json_decode(file_get_contents($json_string_0),true);
*/



/*    
        // Consulta añadiendo la afiliacion (demasiado restritiva o la afiliación que proporciona G Scholar no se ajusta bien)
          $phpafiliacion[0] = str_replace(" ", "%20", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("á", "%C3%A1", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("é", "%C3%A9", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("í", "%C3%AD", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("ó", "%C3%B3", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("ú", "%C3%BA", $phpafiliacion[0]);
          $phpafiliacion[0] = str_replace("-", "%2D", $phpafiliacion[0]);

        $consulta = array('http://api.elsevier.com/content/search/scopus?query=affil(',$phpafiliacion[0],')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json');   
*/
        $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 

      include'conexion.php'; 

      include 'almacena_publicaciones.php';   // ALMACENAMOS EN LA BD las publicaciones

      
      echo " Total number of results: " .$entradasTotales,"<br><br>";




      echo "<p> Almacenamos el autor </p>";

           $insert_autor = 'INSERT INTO autores(id,nombre, urlImagen, citas, citas_2010, h,h_2010, h10, h10_2010) VALUES (\''.$autor_limpio.'\',\''.$autor_limpio." ".$autor_limpio2.'\',\''.$foto.'\',\''.$datos[0].'\',\''.$datos[1].'\',\''.$datos[2].'\',\''.$datos[3].'\',\''.$datos[4].'\',\''.$datos[5].'\')'; 
                                                                                  
           mysql_query($insert_autor) or die(mysql_error()); 

      echo "Autor almacenado<br>";




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
          $muestraissn=$row['issn'];

        echo "<div class='entrada'>";

          echo "Entry number ".$i; if($row['publi_propia']){echo "(Propia)";}
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
/*  var listaAnios_publi_propia = <?php echo json_encode($phpanios_publi_propia); ?>;
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
*/


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
  /*document.write("<p>Años y número de publicaciones  (en total): </p>");
  for(index = 0; index < soloAnios.length; index++) {
    document.write("Año "+soloAnios[index]+": "+counts[soloAnios[index]]+" publicaciones<br>");
  }*/



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
            text: 'Publicaciones en los últimos años'
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
            
        }
        ]

    });
});
</script>




<!--  <div id="container_columns" style="height: 400px"></div>  -->



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



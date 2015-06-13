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

      $idConsulta = mt_rand();

      include'conexion.php'; 

      include 'almacena_publicaciones.php';   // ALMACENAMOS EN LA BD las publicaciones


      echo " Total number of results: " .$entradasTotales,"<br><br>";


      echo "<p> ------- </p>";


        $phpaises = array(); 
        $consulta_paises= "SELECT afiliacion_pais FROM publicaciones WHERE id=".$idConsulta;
        $resultados_paises=mysql_query($consulta_paises,$conexion);
        while ($row=mysql_fetch_array($resultados_paises)) {  
          $phpaises[]=$row['afiliacion_pais'];
        }
        

        $phpanios = array(); 
        $consulta_anios= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC";
        $resultados_anios=mysql_query($consulta_anios,$conexion);
        while ($row=mysql_fetch_array($resultados_anios)) {  
          $phpanios[]=$row['fecha_portada_0'];
        }

        $phpautor = array(); 
        $consulta_autor= "SELECT nombre_publi FROM publicaciones WHERE id=".$idConsulta;
        $resultados_autor=mysql_query($consulta_autor,$conexion);
        while ($row=mysql_fetch_array($resultados_autor)) {  
          $phpautor[]=$row['nombre_publi'];
        }


?>


<script>
  var hay_entradas = <?php echo json_encode($hay_entradas); ?>;
     
  if(hay_entradas){ 
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

        //mostramos los paises
        document.write('<div style="width: 20%; margin: 100px 0px 0px 0px; float: left;"><p>Paises y número de publicaciones: </p>');
        for(index = 0; index < listaPaises.length; index++) {

            document.write(""+listaPaises[index]+": "+counts[listaPaises[index]]+"<br>");

        }
        document.write('</div>');


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
    
}// fin if(hay_entradas)


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
/*
    //mostramos los años
    document.write("<p>Años y número de publicaciones : </p>");
    for(index = 0; index < soloAnios.length; index++) {
      document.write("Año "+soloAnios[index]+": "+counts_anios[soloAnios[index]]+" publicaciones<br>");
    }
*/
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

}

</script>


<?php

      if($hay_entradas){ 

         echo'<div id="donutchart" style="width: 80%; height: 500px; float: left;"></div> ';

         echo'<div id="regions_div" style="clear: left; max-width:100%; height: 500px; margin: 10px 0px 60px 0px;"></div>';

         echo'<div id="container_columns" style="height: 400px;"></div><br>';

      }  

        //include('simple_html_dom.php');

        echo "<p> Mostramos de la BD </p>";

        $i=1;
        $consulta= "SELECT * FROM publicaciones WHERE id=".$idConsulta;
                    
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

        echo "<div class='entrada'>";

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


      $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";

?>


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



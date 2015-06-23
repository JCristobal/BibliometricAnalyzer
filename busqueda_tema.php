<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Consulta por tema">
    <meta name="author" content="JCristobal">
    

    <title>BibliometricAnalyzer: topics analysis</title>

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

      
        error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP      
        
        include'generaApiKey.php';

        include_once('funciones.php');


        $tema = $_POST['busqueda_tema'];
        $palabra = $_POST['busqueda_basica'];
        $titulo = $_POST['busqueda_titulo'];
        $fecha0 = $_POST['busqueda_fecha0'];
        $fecha1 = $_POST['busqueda_fecha1'];

        $hay_tema=false;
        $hay_palabra=false;
        $hay_titulo=false;
        $hay_fecha0=false;
        $hay_fecha1=false;

        echo "<h1> Bibliometric analysis";

        if(strlen($palabra)){ echo " about '".$palabra."'"; $hay_palabra=true;}
        if(strlen($tema)){ echo " with topic ".$tema; $hay_tema=true;}
        if(strlen($titulo)){ echo " with '".$titulo."' in the title"; $hay_titulo=true;}
        if(strlen($fecha0)){ echo " since ".$fecha0; $hay_fecha0=true;}
        if(strlen($fecha1)){ echo " to ".$fecha1; $hay_fecha1=true;}
        echo ".</h1>";

        // Se ajustan las fechas  para que coincidan con las introducidas. Si no se han introducido toman valores predefinidos
        if($hay_fecha0==false){$fecha0=1800;}else{$fecha0--;} // La fecha no incluye la fecha de comienzo (es restrictivo), restándole uno hacemos que aparezcan publicaciones publicadas desde el año que se indica
        if($hay_fecha1==false){$fecha1=2050;}else{$fecha1++;}


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

        $palabra = iso2utf($palabra);
        $titulo = iso2utf($titulo);


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
        $consulta_autor= "SELECT enlace_coautores FROM publicaciones WHERE id=".$idConsulta;
        $resultados_autor=mysql_query($consulta_autor,$conexion);
        while ($row=mysql_fetch_array($resultados_autor)) {  
          $phpautor[]=$row['enlace_coautores'];
        }

        $aux = implode("",$phpautor);  // Si no estamos conectados a una red de Scopus la variable estará vacia. Trabajaremos con sólo el campo "creator", aunque sea menos preciso
        if($aux == ""){
          $phpautor = array(); 
          $consulta_autor= "SELECT creador FROM publicaciones WHERE id=".$idConsulta;
          $resultados_autor=mysql_query($consulta_autor,$conexion);
          while ($row=mysql_fetch_array($resultados_autor)) {  
            $phpautor[]=$row['creador'];
          }

        }

?>


<script>
  var hay_entradas = <?php echo json_encode($hay_entradas); ?>;
     
  if(hay_entradas){ 



    var listaAutores = <?php echo json_encode($phpautor); ?>;
    var soloAutores = {};
    var soloAutores = new Array();
    var contador_autores=0;
    // De cada entrada cogemos tódos los autores, separados por comas
    for(index = 0; index < listaAutores.length; index++) {
      var ss = listaAutores[index].split(",");
      if(ss[0]!= ""){soloAutores[contador_autores]=ss[0]; contador_autores++;}
      for(aux=1; aux< ss.length; aux++){
        soloAutores[contador_autores]=ss[aux];
        contador_autores++;
      }
    }

    //Contamos las veces que se repite cada año
    var counts_Autores = {};
    var counts_Autores = new Array();
    for(var i=0;i< soloAutores.length;i++){
      var key = soloAutores[i];
      counts_Autores[key] = (counts_Autores[key])? counts_Autores[key] + 1 : 1 ;       
    }

    // la función "unique" eliminará los elementos repetidos del array
    Array.prototype.unique=function(a){
      return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });
    soloAutores=soloAutores.unique()





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
        /*Array.prototype.unique=function(a){
          return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
        });*/
        listaPaises=listaPaises.unique()




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


        if(soloAnios.length == 1){
          document.write(counts_anios[soloAnios[0]]+" publications in the year "+soloAnios[0]+'<hr>');}
        else{
          // Pintamos el gráfico por años primero
          document.write('<div id="container_columns" style="height: 400px;"></div> <hr> ');
        }
        //mostramos los paises
        document.write(' <div style="width: 20%; margin: 60px 0px 0px 0px; float: left;"><p>Paises y número de publicaciones: </p>');
        for(index = 0; index < listaPaises.length; index++) {
          if(listaPaises[index]!= ""){
            document.write(""+listaPaises[index]+": "+counts[listaPaises[index]]+"<br>");
          }

        }
        document.write('</div>');


    
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
        
        var chart_regions = new google.visualization.GeoChart(document.getElementById('regions_div')); // Para pintar
        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        // Wait for the chart to finish drawing before calling the getImageURI() method.   // Para pintar
        google.visualization.events.addListener(chart_regions, 'ready', function () {
          png_regions.innerHTML = '<a href="' + chart.getImageURI() + '">Link to .png version</a>';
        });

        chart.draw(data, options);
        chart_regions.draw(data, options);    // Para pintar

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

        var chart_donut = new google.visualization.PieChart(document.getElementById('donutchart'));  // Para pintar
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

        // Wait for the chart to finish drawing before calling the getImageURI() method.   // Para pintar
        google.visualization.events.addListener(chart_donut, 'ready', function () {
          png_donut.innerHTML = '<img src="' + chart.getImageURI() + '">';
        });


        chart.draw(data, options);
        chart_donut.draw(data, options);    // Para pintar
        document.getElementById('png_donut').outerHTML = '<a href="' + chart_donut.getImageURI() + '">Link to .png version</a>';  // Para pintar

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
                type: 'bar',
                margin: 75,
                zoomType: 'x', 
                /*options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }*/
            },
            title: {
                text: 'Number of publications each year'
            },
            subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in an area to zoom in' :
                    ''
            },
            plotOptions: {
                column: {
                    //depth: 25
                    //color: "#00FF00"
                }
            },
            xAxis: {
                //categories: Highcharts.getOptions().lang.shortMonths
                categories: [soloAnios[0], soloAnios[1], soloAnios[2], soloAnios[3], soloAnios[4], soloAnios[5], soloAnios[6], soloAnios[7], soloAnios[8], soloAnios[9], soloAnios[10], soloAnios[11], soloAnios[12], soloAnios[13], soloAnios[14], soloAnios[15], soloAnios[16], soloAnios[17], soloAnios[18], soloAnios[19], soloAnios[20], soloAnios[21], soloAnios[22], soloAnios[23], soloAnios[24], soloAnios[25] ],
                title: {
                    text: 'Years'
                }

            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Publications'
                }
            },
            series: [{
                //type: 'area',
                name: 'Number of publications',
                data: [counts_anios[soloAnios[0]], counts_anios[soloAnios[1]], counts_anios[soloAnios[2]], counts_anios[soloAnios[3]], counts_anios[soloAnios[4]], counts_anios[soloAnios[5]], counts_anios[soloAnios[6]], counts_anios[soloAnios[7]], counts_anios[soloAnios[8]], counts_anios[soloAnios[9]], counts_anios[soloAnios[10]], counts_anios[soloAnios[11]], counts_anios[soloAnios[12]], counts_anios[soloAnios[13]], counts_anios[soloAnios[14]], counts_anios[soloAnios[15]], counts_anios[soloAnios[16]], counts_anios[soloAnios[17]], counts_anios[soloAnios[18]], counts_anios[soloAnios[19]], counts_anios[soloAnios[20]], counts_anios[soloAnios[21]], counts_anios[soloAnios[22]], counts_anios[soloAnios[23]], counts_anios[soloAnios[24]], counts_anios[soloAnios[25]]]
                
            }
            ]

        });



    $('#container_autores').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        title: {
            text: 'Number of last publications per author'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in an area to zoom in' :
                    ''
        },
         xAxis: {
            categories: [soloAutores[0], soloAutores[1], soloAutores[2], soloAutores[3], soloAutores[4], soloAutores[5], soloAutores[6], soloAutores[7], soloAutores[8], soloAutores[9], soloAutores[10], soloAutores[11], soloAutores[12], soloAutores[13], soloAutores[14], soloAutores[15], soloAutores[16], soloAutores[17], soloAutores[18], soloAutores[19], soloAutores[20], soloAutores[21], soloAutores[22], soloAutores[23], soloAutores[24], soloAutores[25], soloAutores[26], soloAutores[27], soloAutores[28], soloAutores[29]],
            title: {
                text: 'Publications'
            }

        },

        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: 'Author'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'with <b>{point.y}</b> publications'
        },
        series: [{
            name: 'Numer of publications',
                data: [counts_Autores[soloAutores[0]], counts_Autores[soloAutores[1]], counts_Autores[soloAutores[2]], counts_Autores[soloAutores[3]], counts_Autores[soloAutores[4]], counts_Autores[soloAutores[5]], counts_Autores[soloAutores[6]], counts_Autores[soloAutores[7]], counts_Autores[soloAutores[8]], counts_Autores[soloAutores[9]], counts_Autores[soloAutores[10]], counts_Autores[soloAutores[11]], counts_Autores[soloAutores[12]], counts_Autores[soloAutores[13]], counts_Autores[soloAutores[14]], counts_Autores[soloAutores[15]], counts_Autores[soloAutores[16]], counts_Autores[soloAutores[17]], counts_Autores[soloAutores[18]], counts_Autores[soloAutores[19]], counts_Autores[soloAutores[20]], counts_Autores[soloAutores[21]], counts_Autores[soloAutores[22]], counts_Autores[soloAutores[23]], counts_Autores[soloAutores[24]], counts_Autores[soloAutores[25]], counts_Autores[soloAutores[26]], counts_Autores[soloAutores[27]], counts_Autores[soloAutores[28]], counts_Autores[soloAutores[29]]],
   
            dataLabels: {
                enabled: true,
                color: '#FFFFFF',
                align: 'right',
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });





    }); // fin function

}

</script>


<?php

      if($hay_entradas){ 

          if($entradasTotales>1){
            echo' <div id="donutchart" style="width: 80%; height: 500px; float: left;"></div> ';
            echo"<div id='png_donut'></div>";
          }
          else{echo' <p  style="width: 80%; margin: 60px 0px 0px 0px; float: left;"> 100% in '.$phpaises[0].'</p>';}

         echo'<hr style="clear: left;"> <div id="regions_div" style="max-width:100%; height: 500px; margin: 10px 0px 60px 0px;"></div>';
         echo"<div id='png_regions'></div>";

         echo'<hr> <div id="container_autores" style="min-width: 300px; height: 400px; margin: 0 auto"></div>';


      }  

        if($entradasTotales<15){
          echo '<p id="cabecera_publicaciones"> <b>'.$entradasTotales.' latests publications: </b></p>'; 
        }
        else{
          echo '<p id="cabecera_publicaciones"><b> 15 latests publications: </b></p>';   
        }

      include 'muestra_publicaciones.php';   // MOSTRAMOS las publicaciones

        if($entradasTotales>15){
          echo'<p style="text-align: center; margin: 15px 0px 10px 0px""><a id="enlace_publicaciones" href="todas_publicaciones.php?consulta='.$idConsulta.'&cantidad='.$entradasTotales.'"> See all publications </a> </p>';   
        }
        echo '<hr>';

/*
      $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";
*/

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



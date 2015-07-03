<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Consulta por tema">
    <meta name="author" content="JCristobal">
    <link rel="icon" href="BibliometricAnalyzer_icon.png"> 

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


    <!-- Alertas personalizadas "SweetAlert"-->
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">

    <script language=JavaScript>
      function espera() {
        swal({
          title: "Analyzing publications",
          text: "Please, wait the alert ",
          imageUrl: "img/BibliometricAnalyzer.png",
          showConfirmButton: false, 
          timer:5000
        }); 
      }
      function cargada() {
        swal({
          type: "success",
          title: "",
          text: "Bibliometric analysis is finished ",
          confirmButtonColor: "#8FBC8F",
          confirmButtonText: "See the results"
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
          <a class="navbar-brand" href="#">BibliometricAnalyzer by JCristobal</a>
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


        echo "<h1> <p class='text-center'> Bibliometric analysis";
          if(strlen($palabra)){ echo " about '".$palabra."'"; $hay_palabra=true;}
          if(strlen($tema)){ echo " with topic ".$tema; $hay_tema=true;}
          if(strlen($titulo)){ echo " with '".$titulo."' in the title"; $hay_titulo=true;}
          if(strlen($fecha0)){ echo " since ".$fecha0; $hay_fecha0=true;}
          if(strlen($fecha1)){ echo " to ".$fecha1; $hay_fecha1=true;}
        echo ". </p></h1>";


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
      


        $palabra = iso2utf($palabra);
        $titulo = iso2utf($titulo);
        $titulo_aux = $titulo;

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




        if($hay_entradas){
          echo " <p id='cabecera'> Total number of results: " .$entradasTotales."</p>";
        }else{
          echo " <p id='cabecera'>  Your search did not match any entries. </p> <p class='text-center'><a href='index.html'>Go back</a></p>";     
        }



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

        $phpcreador = array(); 
        $phpcitas = array(); 
        $consulta_citas= "SELECT creador,veces_citado FROM publicaciones WHERE id=".$idConsulta;
        $resultados_citas=mysql_query($consulta_citas,$conexion);
        while ($row=mysql_fetch_array($resultados_citas)) {  
          $phpcreador[]=$row['creador'];
          $phpcitas[]=$row['veces_citado'];
        }


?>


<script>
  var hay_entradas = <?php echo json_encode($hay_entradas); ?>;
     
  if(hay_entradas){ 

var listaCreadores = <?php echo json_encode($phpcreador); ?>;
var listaCitas = <?php echo json_encode($phpcitas); ?>;
// Sumamos todas las citas de un autor
var citas=new Array();
var autor_cita=new Array();
for(index = 0; index < listaCreadores.length; index++) {
  autor_cita[index] = listaCreadores[index]; 
  citas[index] = listaCitas[index]; 
  for(i = 0; i < listaCreadores.length; i++) {
    if(i != index){  // para que no coincida con el mismo, si no se repite
      if(listaCreadores[i]==listaCreadores[index]){  
        var aux =  parseInt(citas[index]) +  parseInt(listaCitas[i]);
        citas[index]=aux;  
      }
    }
  }
}


    var listado_aux=new Array();
    for(var i=0;i< autor_cita.length;i++){
      // lo ponemos en este formato para poder ordenarlo
      listado_aux[i]= citas[i]+":"+autor_cita[i] ; 
    }


    // la función "unique" eliminará los elementos repetidos del array
    Array.prototype.unique=function(a){
      return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });
    listado_aux=listado_aux.unique();

    // Separamos según ":" 
    var listado_citas=new Array();
    for(var i=0;i< autor_cita.length;i++){
      if( typeof listado_aux[i]=="undefined"){listado_aux[i]="";}
      var a =0;
      a = listado_aux[i].indexOf(":");
      a = a+1;
      var numero = listado_aux[i].substring(0,(a-1));
      var autor = listado_aux[i].substring(a);
      listado_citas[i]= [ numero , autor ];
    }

    //Y ordenamos de mayor a menor según el número de veces citado
    listado_citas.sort(function(a,b){
    return parseInt(a[0]) < parseInt(b[0]); 
    });

/*
    for(var i=0;i< listado_citas.length;i++){
       document.write("--> <b>"+listado_citas[i][0]+" "+listado_citas[i][1]+"</b> <br>");
    }
*/




    var listaAutores = <?php echo json_encode($phpautor); ?>;
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

    //Contamos las veces que se repite cada autor y guardamos ambos datos en tuplas
    var counts_Autores = new Array();

    for(var i=0;i< soloAutores.length;i++){
      var key = soloAutores[i];
      counts_Autores[key] = (counts_Autores[key])? counts_Autores[key] + 1 : 1 ;     

    }

    var listado_autores_aux=new Array();
    for(var i=0;i< soloAutores.length;i++){
      // lo ponemos en este formato para poder ordenarlo
      listado_autores_aux[i]= counts_Autores[soloAutores[i]]+":"+soloAutores[i] ; 
    }

    // la función "unique" eliminará los elementos repetidos del array
    listado_autores_aux=listado_autores_aux.unique();

    // Separamos según ":" 
    var listado_aut=new Array();
    for(var i=0;i< soloAutores.length;i++){
      if( typeof listado_autores_aux[i]=="undefined"){listado_autores_aux[i]="";}
      var a =0;
      a = listado_autores_aux[i].indexOf(":");
      a = a+1;
      var numero = listado_autores_aux[i].substring(0,(a-1));
      var autor = listado_autores_aux[i].substring(a);
      listado_aut[i]= [ numero , autor ];
    }

    //Y ordenamos de mayor a menor según el número de veces citado
    listado_aut.sort(function(a,b){
    return parseInt(a[0]) < parseInt(b[0]); 
    });







        //Copiamos el vector de paises que hemos calculado con php
        var listaPaises = <?php echo json_encode($phpaises); ?>; 

        //Contamos las veces que se repite cada país
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
    var soloAnios = new Array();

    //Cogemos sólo el año de la fecha
    for(index = 0; index < listaAnios.length; index++) {
      var ss = listaAnios[index].split("-");
      soloAnios[index]=ss[0];
    }
    //Contamos las veces que se repite cada año
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
          document.write("<p class='text-center'>"+counts_anios[soloAnios[0]]+" publications in the year <b>"+soloAnios[0]+'</b></p><hr>');}
        else{
          // Pintamos el gráfico por años primero
          document.write('<div id="container_columns" ></div> <hr> ');
        }
        //mostramos los paises
        document.write(' <div id="listado_paises" >');
        document.write('<table id="paises"> <caption>Countries and his number or publications</caption>');
        for(index = 0; index < listaPaises.length; index++) {
          if(listaPaises[index]!= ""){
            document.write("<tr> <td>"+listaPaises[index]+"</td> <td>"+counts[listaPaises[index]]+"</td> </tr>");
          }

        }
        document.write(' </table> </div>');


    
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
          png_regions.innerHTML = '<a href="' + chart.getImageURI() + '"><img src="img/print_button.png"></img> Print map</a>';
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
          title: 'Contributions by countries',
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
        document.getElementById('png_donut').outerHTML = '<p class="boton_impresion"> <a href="' + chart_donut.getImageURI() + '"><img src="img/print_button.png"></img> Print chart</a></p>';  // Para pintar

      }


if(hay_entradas){ 


var anios_publiaciones=[];
var cuenta_publiaciones=[];
var contador_anios=0;
for (var i = 0; i < soloAnios.length; i++) { 
  if ( (typeof soloAnios[i]!="undefined")&&(soloAnios[i]!="")&&(contador_anios<100)) {
    anios_publiaciones.push(soloAnios[i]);
    cuenta_publiaciones.push(parseInt(counts_anios[soloAnios[i]]));
    contador_anios++;
  }
}
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
            credits: {
              enabled: false
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
                bar: {
                    colorByPoint: true
                }
            },
            colors: [
              '#8FBC8F'
            ],
            xAxis: {
                categories: anios_publiaciones,
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
                data: cuenta_publiaciones,                
            }],

            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            exporting: {
              filename: 'publications/year',
                buttons: {
                    contextButton: {
                        text: 'Print chart',
                        symbol: 'url(img/print_button.png)',
                        //symbol: 'circle',
                        menuItems: null,
                        onclick: function () {
                            this.exportChart();
                        }
                    }
                }
            }



        });


var publi_autores=[];
var cuenta_autores=[];
for (var i = 0; i < listado_aut.length; i++) { 
  if ( (typeof listado_aut[i][1]!="undefined")&&(listado_aut[i][1]!="")) {
    publi_autores.push(listado_aut[i][1]);
    cuenta_autores.push(parseInt(listado_aut[i][0]));
  }
}

    $('#container_autores').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        credits: {
            enabled: false
        },
        title: {
            text: 'Number of publications per author'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in an area to zoom in' :
                    ''
        },
        plotOptions: {
                column: {
                    colorByPoint: true
                }
        },
        colors: [
              '#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'
        ],
        xAxis: {
            categories: publi_autores,
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
                data:cuenta_autores,
                //data: [counts_Autores[soloAutores[0]], counts_Autores[soloAutores[1]], counts_Autores[soloAutores[2]], counts_Autores[soloAutores[3]], counts_Autores[soloAutores[4]], counts_Autores[soloAutores[5]], counts_Autores[soloAutores[6]], counts_Autores[soloAutores[7]], counts_Autores[soloAutores[8]], counts_Autores[soloAutores[9]], counts_Autores[soloAutores[10]], counts_Autores[soloAutores[11]], counts_Autores[soloAutores[12]], counts_Autores[soloAutores[13]], counts_Autores[soloAutores[14]], counts_Autores[soloAutores[15]], counts_Autores[soloAutores[16]], counts_Autores[soloAutores[17]], counts_Autores[soloAutores[18]], counts_Autores[soloAutores[19]], counts_Autores[soloAutores[20]], counts_Autores[soloAutores[21]], counts_Autores[soloAutores[22]], counts_Autores[soloAutores[23]], counts_Autores[soloAutores[24]], counts_Autores[soloAutores[25]], counts_Autores[soloAutores[26]], counts_Autores[soloAutores[27]], counts_Autores[soloAutores[28]], counts_Autores[soloAutores[29]]],
   
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
        }],

            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            exporting: {
                filename: 'publications/author about the topic',
                buttons: {
                    contextButton: {
                        text: 'Print chart',
                        symbol: 'url(img/print_button.png)',
                        //symbol: 'circle',
                        menuItems: null,
                        onclick: function () {
                            this.exportChart();
                        }
                    }
                }
            }

    });


var autores_citados=[];
var numero_citas=[];
var contador_citas=0;
for (var i in listado_citas) {
  if ( (typeof listado_citas[i][1]!="undefined")&&(listado_citas[i][1]!="")&&(contador_citas<30)) {
    autores_citados.push(listado_citas[i][1]);
    numero_citas.push(parseInt(listado_citas[i][0]));
    contador_citas++;
  }
}

   $('#container_citas').highcharts({
        chart: {
            type: 'bar',
            zoomType: 'x'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            bar: {
                colorByPoint: true
            }
        },
        colors: [
          '#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'
        ],

        title: {
            text: 'Most cited authors '
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in an area to zoom in' :
                    ''
        },
         xAxis: {
            categories: autores_citados,
            title: {
                text: 'Author'
            }

        },

        yAxis: {
            min: 0,
            allowDecimals: false,
            title: {
                text: 'citations'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'receibed <b>{point.y}</b> citations'
        },
        series: [{
            name: 'Number of citations',
                data: numero_citas,
   
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
        }],

            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            exporting: {
                filename: 'citations/author in the publications',
                buttons: {
                    contextButton: {
                        text: 'Print chart',
                        symbol: 'url(img/print_button.png)',
                        //symbol: 'circle',
                        menuItems: null,
                        onclick: function () {
                            this.exportChart();
                        }
                    }
                }
            }

    });


    }); // fin function

}

</script>


<?php

      if($hay_entradas){ 

          if($entradasTotales>1){
            echo' <div id="donutchart" ></div> ';
            echo"<div style='clear: left;'></div>  <div id='png_donut'  ></div> <br>";
          }
          else{echo' <p  style="width: 80%; margin: 60px auto; "> (All the publications in '.$phpaises[0].')</p>';}

         echo'<hr style="clear: left;"> <div id="regions_div" ></div>';
         echo"<div id='png_regions' class='boton_impresion'></div> <br>";

         echo'<hr> <div id="container_autores" ></div>';


      }  

      if($hay_entradas){ 
        if($entradasTotales<15){
          echo '<p id="cabecera"> <b>'.$entradasTotales.' latests publications: </b></p>'; 
        }
        else{
          echo '<p id="cabecera"><b> 15 latests publications: </b></p>';   
        }

      include 'muestra_publicaciones.php';   // MOSTRAMOS las publicaciones

        if($entradasTotales>15){
          echo'<p style="text-align: center; margin: 15px 0px 10px 0px;"><a id="enlace_publicaciones" href="todas_publicaciones.php?consultaT1='.$tema.'&consultaT2='.$palabra.'&consultaT3='.$titulo_aux.'&consultaT4='.$fecha0.'&consultaT5='.$fecha1.'" onclick="espera()"> See all publications </a> </p>';   
        }

        echo'<hr> <div id="container_citas" ></div>';

      }

      //Borramos los datos de la consulta
      $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
      mysql_query($borratodo) or die(mysql_error()); 




?>


      </div>

  <p class="footer"> JCristobal </p>

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



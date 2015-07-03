<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    <link rel="icon" href="BibliometricAnalyzer_icon.png"> 

    <title>BibliometricAnalyzer: author analysis</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/estilo.css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Gráficos Highcharts-->
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/highcharts-3d.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <!-- Gráficos Charts de Google-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- Arbor -->
    <script language="javascript" type="text/javascript" src="js/arbor.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-tween.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-graphics.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-renderer.js"></script>
    <!-- Alertas personalizadas "SweetAlert"-->
    <script src="js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">

    <script language=JavaScript>
      function cargada() {
        swal({
          type: "success",
          title: "",
          text: "Bibliometric analysis is finished ",
          confirmButtonColor: "#8FBC8F",
          confirmButtonText: "See the results",
        }); 
      }
      function espera() {
        swal({
          title: "Analyzing publications",
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
        // Recibimos los datos
        $autor_limpio = $_POST['busqueda_autor'];
        $autor = $_POST['busqueda_autor'];
        $autor_limpio2 = $_POST['busqueda_autor2'];
        $autor2 = $_POST['busqueda_autor2'];
        $enlace_autor = $_POST['busqueda_autor_enlace'];

        $autor_directo = $_POST['busqueda_directa'];
        $busqueda_coautor = $_POST['busqueda_coautor'];
        $enlace_aux = $enlace_autor;
        $nombre_aux = $autor_directo; 

        include_once('simple_html_dom.php');     
        include_once('funciones.php');


        if(strlen($autor_directo)){

          $enlace_autor = $autor_directo;
          $enlace_autor = iso2utf($enlace_autor);

          $enlace_autor = array('https://scholar.google.es/citations?hl=en&oe=ASCII&view_op=search_authors&mauthors=',$enlace_autor);
          $enlace_autor=implode("", $enlace_autor); 
       
          $aux= array(); 
          $html = file_get_html($enlace_autor);
          foreach($html->find('div.gsc_1usr_text h3 a') as $elemento){
                 $aux[]= $elemento->href;          
          }

          $enlace_autor= array('http://scholar.google.com',$aux[0]);
          $enlace_autor=implode("", $enlace_autor); 

          $pos = strripos($autor_directo, " ");
          $autor = substr($autor_directo, $pos);
          $autor2 = substr($autor_directo,0, $pos);

          $autor_limpio = $autor;
          $autor_limpio2 = $autor2;
        }

        if($busqueda_coautor){

          $enlace_autor = $enlace_aux; // Recuperamos el enlace del autor
          $autor_directo = $nombre_aux ; // y el nombre
          
          $autor_directo = utf2iso($autor_directo);
             
          //Asigno valores a $autor y $autor2 a partír de $autor_directo para buscar con Scopus

          $pos_punto = strrpos($autor_directo, ".");
          if ($pos_punto === false) { 
              //Si no tiene ningún punto no podemos distinguir entre su nombre y apellido, por lo que tomamos nombre la primera palabra (y de ella su inicial) y apellidos el resto
              $name = split (" ", $autor_directo);
              $autor=$name[0][0];

              $autor2="";
              for ($i = 1; $i < count($name); $i++) { 
                  $autor2= $autor2." ".$name[$i];
              }
          }
          else{
            // Si el string tiene un punto quiere decir que el autor coge su primer nombre y el resto pone sólo su inicial con un punto.
            $nombre = strstr($autor_directo, '.', true); 
            $name = split (" ", $nombre);
            $autor="";
            for ($i = 0; $i < count($name); $i++) { 
                $autor= $autor.$name[$i][0].". ";   // Almacenamos la iniciales, en caso de que tenga varios nombres
            }

            $autor2 = strstr($autor_directo, '.');
            $autor2 = str_replace(".","", $autor2); //Quita el punto

          }

          $autor_limpio = $autor;
          $autor_limpio2 = $autor2;
        }


        $autor = iso2utf($autor);
        $autor2 = iso2utf($autor2);


        $autor_limpio = utf2iso($autor_limpio);
        $autor_limpio = strtoupper($autor_limpio);
        $autor_limpio2 = utf2iso($autor_limpio2);


        // Creamos el DOM de la URL
        $html = file_get_html($enlace_autor);

        $nombreGS = "";
        foreach($html->find('#gsc_prf_in') as $element){
               $nombreGS = $element->plaintext;
        }

        $foto = "";
        foreach($html->find('img') as $element){
               $foto = array('<img src="http://scholar.google.es',$element->src,'"/>');
               $foto=implode("", $foto); 
        }

        $email = "";
        foreach($html->find('#gsc_prf_ivh') as $element){
               $email = $element;
        }

        $phpafiliacion= array(); 
        foreach($html->find('div.gsc_prf_il') as $element){
               $phpafiliacion[]=$element->plaintext;
        }

        $datos = array(); 
        foreach($html->find('td.gsc_rsb_std') as $element){
               $datos[]=$element->plaintext;
        }

        $coautores= array();
        $img_coautores=array();
        $enlace_coautores=array();

        foreach($html->find('.gsc_rsb_aa') as $element){
          $coautores[]=$element->plaintext;
          $img_coautores[] = substr($element->href, 11, 17); // "extraigo" de la URL el ID del autor para ver su foto
          $enlace_coautores[] = $element->href;
        }

        
        if($nombreGS==""){
          echo "<h1><p class='text-center'> Bibliometric analysis of the author ".$autor_limpio." ".$autor_limpio2."</p></h1>";

          echo '<div id="datos_autor" style="width:100%; margin: 0px;"> <p><b>'.$autor_limpio.' '.$autor_limpio2.'</b></p><img src="img/user.jpg" height="150" width="150"/><br>'; 

          echo '<p> No mail or affiliation verified </p> </div>';


        }else{

          echo "<h1><p class='text-center'> Bibliometric analysis of the author ".$nombreGS."</p></h1>";

          if($foto=='<img src="http://scholar.google.es/citations/images/avatar_scholar_150.jpg"/>'){
            $foto='<img src="img/user.jpg" height="150" width="150"/>';
          }

          echo '<div id="datos_autor" > <p><b>'.$nombreGS.'</b></p> '.$foto.'<br> '; 

          echo '<p>'.$email.'</p> <p>Afiliation: '.$phpafiliacion[0].'</p> </div>';


         

          // Cargamos la tabla de datos con los valores bibliométricos del autor
    echo "
    <script>
          google.load('visualization', '1', {packages:['table']});
          google.setOnLoadCallback(drawTable);

          var cssClassNames = {
            'headerRow': 'italic-color-font  celda-datos',
            'tableRow': 'celda-datos',
            'oddTableRow': 'celda-datos',
            'selectedTableRow': 'large-font celda-datos',
            'hoverTableRow': 'celda-datos',
            'headerCell': 'celda-datos',
            'tableCell': 'celda-datos',
            'rowNumberCell': ' celda-datos'
          };

          var options = {'allowHtml': true, 'cssClassNames': cssClassNames, keepAspectRatio: 'true', width: '250px'};

          function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', '');
            data.addColumn('number', 'All');
            data.addColumn('number', 'Since 2010');
            data.addRows([
              ['Citations',  ".$datos[0].", ".$datos[1]."],
              ['h-index',   ".$datos[2].",  ".$datos[3]."],
              ['i10-index', ".$datos[4].", ".$datos[5]."]
            ]);

            var table = new google.visualization.Table(document.getElementById('tabla_datos'));

            table.draw(data, options);

          }
    </script>
    <style>
      .celda-datos {
        text-align: center;
        border-bottom-color: #334433;
        border-bottom-style: solid;
        border-width: 1px;
        margin: 0px auto;
      }
    </style>

    <div id='tabla_datos'></div>";


        }
    echo "<p style='clear: left;'>  </p> ";

//Si hay coautores muestro el arbol
if(count($coautores)!=0){
    echo "<p id='cabecera'> Authors relations tree </p>";
    echo "<canvas id='arbol_autores' width='800' height='600' ></canvas>

    <script language='javascript' type='text/javascript'>

        var sys = arbor.ParticleSystem(100, 400,0.5);
        sys.parameters({gravity:false});
        sys.renderer = Renderer('#arbol_autores') ;

        var data = {
          nodes:{
            autor_principal:{'color':'#003322','shape':'rectangle','label':'".$nombreGS."'},";

          $muestra_2_nivel= array();

          $tamanio_aux=0;         
          if(count($coautores)>=11){ //Si hay más de 11 coautores muestro los 11 primeros, así se representa claramente
            for ($i = 0; $i <11; $i++) { 
                echo "autor".$i.":{'color':'#334433 ','label':'".$coautores[$i]."'},";
                $tamanio_aux++;

              $coautores_2_nivel= array();          
              $enlace_autor_relacionado= array('http://scholar.google.com',$enlace_coautores[$i]);
              $enlace_autor_relacionado=implode("", $enlace_autor_relacionado);

              $html = file_get_html($enlace_autor_relacionado);
              foreach($html->find('.gsc_rsb_aa') as $element){
                $coautores_2_nivel[]=$element->plaintext;
              }

              // Mostramos sólo los 3 primeros autores relacionados (a 2º nivel)
              if(($coautores_2_nivel[0] != "")&&($coautores_2_nivel[0] != $nombreGS)){echo "autor0_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[0]."'},"; }
              if(($coautores_2_nivel[1] != "")&&($coautores_2_nivel[1] !=$nombreGS)){echo "autor1_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[1]."'},"; }
              if(($coautores_2_nivel[2] != "")&&($coautores_2_nivel[2] !=$nombreGS)){echo "autor2_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[2]."'},"; }

              $muestra_2_nivel[]=array($coautores_2_nivel[0],$coautores_2_nivel[1],$coautores_2_nivel[2]); // Registramos el autor (a segundo nivel) para después mostrarlo o no mostrar un nodo vacío

            } // fin for
          }
          else{ //si hay menos de 11 coautores los muestrso todos
              for ($i = 0; $i < count($coautores); $i++) { 
                echo "autor".$i.":{'color':'#334433 ','label':'".$coautores[$i]."'},";
                $tamanio_aux++;

              $coautores_2_nivel= array();          
              $enlace_autor_relacionado= array('http://scholar.google.com',$enlace_coautores[$i]);
              $enlace_autor_relacionado=implode("", $enlace_autor_relacionado);

              $html = file_get_html($enlace_autor_relacionado);
              foreach($html->find('.gsc_rsb_aa') as $element){
                $coautores_2_nivel[]=$element->plaintext;
              }

              // Mostramos sólo los 3 primeros autores relacionados (a 2º nivel)
              if(($coautores_2_nivel[0] != "")&&($coautores_2_nivel[0] != $nombreGS)){echo "autor0_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[0]."'},"; }
              if(($coautores_2_nivel[1] != "")&&($coautores_2_nivel[1] !=$nombreGS)){echo "autor1_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[1]."'},"; }
              if(($coautores_2_nivel[2] != "")&&($coautores_2_nivel[2] !=$nombreGS)){echo "autor2_".$i.":{'color':'#8FBC8F','label':'".$coautores_2_nivel[2]."'},"; }

              $muestra_2_nivel[]=array($coautores_2_nivel[0],$coautores_2_nivel[1],$coautores_2_nivel[2]); // Registramos el autor (a segundo nivel) para después mostrarlo o no mostrar un nodo vacío
              } //fin for
          } //fin else

 echo"     
          },
          edges:{
            autor_principal:{  ";
              // Añadimos los nodos de autores relacionados a primer nivel
              for ($i = 0; $i < $tamanio_aux; $i++) { 
                  echo "autor".$i.":{}, ";
              } 

 echo "     }, ";                                             
              // Completamos cada nodo de autores relacionado (a primer nivel) con  hasta 3 autores relacionados con este
              for ($i = 0; $i < $tamanio_aux; $i++) { 
                  echo "autor".$i.":{ ";
                  if(($muestra_2_nivel[$i][0]!="")&&($muestra_2_nivel[$i][0]!=$nombreGS)){ echo "autor0_".$i.":{}, ";}
                  if(($muestra_2_nivel[$i][1]!="")&&($muestra_2_nivel[$i][1]!=$nombreGS)){ echo "autor1_".$i.":{}, ";}
                  if(($muestra_2_nivel[$i][2]!="")&&($muestra_2_nivel[$i][2]!=$nombreGS)){ echo "autor2_".$i.":{}  ";}
                  echo "}, ";   
              } 

 echo"   }
        };

        sys.graft(data);

        window.onload = function() {
          var canvas = document.getElementById('arbol_autores');
          var img    = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');;

          img_grafo.innerHTML = '<p class=\"boton_impresion\"> <a href=\"'+img+'\"> <img src=\"img/print_button.png\"></img> Print tree </a></p>';

        }

      if(window.innerWidth < 800){
        htmlCanvas = document.getElementById('arbol_autores'),
        htmlCanvas.width = window.innerWidth - 100;
      }


    </script>   

    <div id='img_grafo'></div> ";

    // Dibujamos ahora la lista de coautores con: imagen de perfil, nombre y enlace a buscador
        echo '<div id="lista_coautores" ><p style="font-weight:bold; text-align:center;"> Co-authors: </p>';
            for ($i = 0; $i < count($coautores); $i++) { 

            if(($i%2)==0){echo "<div class='content-section-a' >";} // Alternamos la clase según las entradas
            else{echo"<div class='content-section-b' >";}

              echo "<img style='float: left; margin: 10px 0;' src='http://scholar.google.es/citations?view_op=view_photo&amp;".$img_coautores[$i]."&amp;citpid=1'  height='70px' width='70px'> </img>";          
              
              echo "<div style='float: left; max-width: 85%; margin: 10px 0px 0px 10px;'> <p style='float: left;'>".$coautores[$i]."</p>" ;

               $coautores[$i] = iso2utf($coautores[$i]);

               echo " <form> <input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =".$coautores[$i]."> <input type=\"text\" name=\"busqueda_autor_enlace\" style =\"visibility: hidden; width:1px; display: inline;\" value =http://scholar.google.es".$enlace_coautores[$i]."> <input type=\"text\" name=\"busqueda_coautor\" style =\"visibility: hidden; width:1px; display: inline;\" value =true> <button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\" onclick=\"espera()\"> Analysis of the author </button></form><br>";
               echo "</div> <p style='clear: left;'>  </p>";
            echo "</div>";  // fin .content-section-a/b  
            } 
        echo "</div>";  // fin #lista_coautores


}
else{
  echo "<p class='text-center'> Without coauthors registered</p>";
}


echo "<p style='clear: left;'></p>";

// dibujamos ahora el gráfico de pie chart con los autores que publican junto al autor
echo' <div id="container_autores" ></div> ';
echo" <div id='png_autores'></div> <br> <hr>";



/*    
        // Consulta añadiendo la afiliacion (demasiado restritiva o la afiliación que proporciona G Scholar no se ajusta bien)
          $phpafiliacion[0] = iso2utf($phpafiliacion[0]);
        $consulta = array('http://api.elsevier.com/content/search/scopus?query=affil(',$phpafiliacion[0],')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json');   
*/

        $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 


        $idConsulta = mt_rand();

      include'conexion.php'; 

      include 'almacena_publicaciones.php';   // ALMACENAMOS EN LA BD las publicaciones

      if($hay_entradas){
        echo "<p id='cabecera'> Data collected from the author ".$autor_limpio." ".$autor_limpio2." (".$entradasTotales." entries)</p>";
      }else{
         echo "<p id='cabecera'> No entries found from the author ".$autor_limpio." ".$autor_limpio2." </p>";     
      }

        //// Almacenamos los autores con los que trabaja el autor
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


        ////Almacenamos los años de sus publicaciones ordenados
        $phpanios = array(); 
        $consulta_anios= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
        $resultados_anios=mysql_query($consulta_anios,$conexion);
        while ($row=mysql_fetch_array($resultados_anios)) {  
          $phpanios[]=$row['fecha_portada_0'];
        }
        // Guardamos los valores de la consulta principal para que no los pisen los de las siguientes consultas
        $aux_aleatorio = $idConsulta;
        $aux_entradas = $hay_entradas;
        $aux_totales = $entradasTotales;



        //// Comprobamos y almacenamos los temas con los que trabaja el autor
        $tema="";
        $temas="";
        $muestra_temas_asociados=false;
        $tema_aux ="";  // Guardaremos estas variable "auxiliares" con el mismo valor para trabajar con ella una vez modificada para trabajar
        $temas_aux = array("");

        if($phpafiliacion[1]!=""){      // Si tiene temas asociados:

          $pos_coma = strrpos($phpafiliacion[1], ",");
          if ($pos_coma === false) { // Hay almacenado sólo un tema
            $tema = $phpafiliacion[1];
            $tema_aux=$tema;
            $tema = iso2utf($tema);
          }else{                  // Hay almacenados varios temas
           
            $temas = $phpafiliacion[1];
            $temas = split (",", $phpafiliacion[1]);
            for ($i = 0; $i < count($temas); $i++) { 
                  $temas_aux[$i] = $temas[$i]; 
                  $temas[$i] = iso2utf($temas[$i]);
            } 
          }

          $phpanios_tema = array("");
          $phpanios_tema0 = array(""); 
          $phpanios_tema1 = array("");
          $phpanios_tema2 = array("");
          $phpanios_tema3 = array("");
          $numero_publi_tema = array("");

          if($tema!=""){  
              // Hacemos la consulta para el tema
              $consulta = array('http://api.elsevier.com/content/search/scopus?query=KEY(',$tema,')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 

              $idConsulta = mt_rand();
              include 'almacena_publicaciones.php';   

              $consulta_anios_tema= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
              $resultados_anios_tema=mysql_query($consulta_anios_tema,$conexion);
              while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                $phpanios_tema[]=$row['fecha_portada_0'];
              }
              if($hay_entradas){ 
                $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
                mysql_query($borratodo) or die(mysql_error()); 
              }

          }
          else{   // Si hay varios consultamos hasta 4
            $tope=4;  
            if(count($temas)<4){$tope=count($temas);}
            for ($indice = 0; $indice < $tope; $indice++) { 

              $consulta = array('http://api.elsevier.com/content/search/scopus?query=KEY(',$temas[$indice],')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 
              
              $idConsulta = mt_rand();
              include 'almacena_publicaciones.php'; 

              $numero_publi_tema[$indice] =  $entradasTotales; 

              $consulta_anios_tema= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
              $resultados_anios_tema=mysql_query($consulta_anios_tema,$conexion);

              //Almacenamos las fechas de los distintos años
              if($indice==0){
                while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                  $phpanios_tema0[]=$row['fecha_portada_0'];
                }
              }
                
              if($indice==1){
                while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                  $phpanios_tema1[]=$row['fecha_portada_0'];
                }
              }
              
              if($indice==2){
                while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                  $phpanios_tema2[]=$row['fecha_portada_0'];
                }
              }
              if($indice==3){
                while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                  $phpanios_tema3[]=$row['fecha_portada_0'];
                }
              }

              $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
              mysql_query($borratodo) or die(mysql_error()); 
          
            } // fin for
            
          }// fin else

        $muestra_temas_asociados=true;

        }
      


      ?>

      </div>



<script>


    //// Trabajamos con los años para el gráfico de barras de publicaciones/año
    var listaAnios = <?php echo json_encode($phpanios); ?>;
    var soloAnios = new Array();

    //Cogemos sólo el año de la fecha
    for(index = 0; index < listaAnios.length; index++) {
      var ss = listaAnios[index].split("-");
      soloAnios[index]=ss[0];
    }
    //Contamos las veces que se repite cada año
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

    var anios_publiaciones=[];
    var cuenta_publiaciones=[];
    var contador_anios=0;
    for (var i = 0; i < soloAnios.length; i++) { 
      if ( (typeof soloAnios[i]!="undefined")&&(soloAnios[i]!="")&&(contador_anios<100)) {
        anios_publiaciones.push(soloAnios[i]);
        cuenta_publiaciones.push(parseInt(counts[soloAnios[i]]));
        contador_anios++;
      }
    }



    //// Trabajamos con los autores que han escrito publicaciones con el autor
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
      listado_autores_aux[i]= counts_Autores[soloAutores[i]]+":"+soloAutores[i].toLowerCase() ; 
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
      listado_aut[i]= [ autor, numero ];
    }

    //Y ordenamos de mayor a menor según el número de veces citado
    listado_aut.sort(function(a,b){
    return parseInt(a[1]) < parseInt(b[1]); 
    });

    var nombre_autor = <?php echo json_encode($autor_limpio); ?>;
    var apellidos_autor = <?php echo json_encode($autor_limpio2); ?>;

    var autor_almacenado=[]; // Contendrá los autores que no se deben mostrar en el gráfico: el propio autor y autores repetidos
    // Vemos el apellido del autor y lo formateamos de manera que podamos compararlo
    var apellidos_autor_aux = apellidos_autor.toLowerCase();
    var apellido_aux = apellidos_autor_aux.replace(" ", "");
    apellido_aux = apellido_aux.replace("á", "a");
    apellido_aux = apellido_aux.replace("é", "e");
    apellido_aux = apellido_aux.replace("í", "i");
    apellido_aux = apellido_aux.replace("ó", "o");
    apellido_aux = apellido_aux.replace("ú", "ú");
    apellido_aux = apellido_aux.replace("-", "");
    var re = / /g;
    apellido_aux = apellido_aux.replace(re, "");
    // Buscamos en la lista de autores que trabajan con él para eliminar autoreferencias
    for (var i = 0; i < listado_aut.length; i++) { 
        var apellido = listado_aut[i][0].substring(0,listado_aut[i][0].indexOf(" "))
        apellido = apellido.replace(re, "");
        apellido = apellido.replace("á", "a");
        apellido = apellido.replace("é", "e");
        apellido = apellido.replace("í", "i");
        apellido = apellido.replace("ó", "o");
        apellido = apellido.replace("ú", "ú");
        apellido = apellido.replace("-", "");
        if(apellido == apellido_aux){
          autor_almacenado.push(listado_aut[i][0]);   //lo almacenamos para no mostrarlo
        }
    }

    var publi_autores=[];
    var cuenta_autores=[];

    for (var i = 0; i < listado_aut.length; i++) { 
      if ( (typeof listado_aut[i][0]!="undefined")&&(listado_aut[i][0]!="")&&(autor_almacenado.indexOf(listado_aut[i][0])==-1)) {

        autor_almacenado.push(listado_aut[i][0]);   //lo almacenamos para no repetirlo

        // La primera letra y la inicial de su nombre en mayúscula
        listado_aut[i][0] = listado_aut[i][0].charAt(0).toUpperCase() + listado_aut[i][0].substring(1,listado_aut[i][0].length-2) + listado_aut[i][0].charAt(listado_aut[i][0].length-2).toUpperCase() +".";

        publi_autores.push(listado_aut[i][0]);
        cuenta_autores.push(parseInt(listado_aut[i][1]));
      }
    }


      // Generamos el gráfico de pie chart (o "donut")
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Publicaciones'],
          [ publi_autores[0] , cuenta_autores[0] ],
          [ publi_autores[1] , cuenta_autores[1] ],
          [ publi_autores[2] , cuenta_autores[2] ],
          [ publi_autores[3] , cuenta_autores[3] ],
          [ publi_autores[4] , cuenta_autores[4] ],
          [ publi_autores[5] , cuenta_autores[5] ],
          [ publi_autores[6] , cuenta_autores[6] ],
          [ publi_autores[7] , cuenta_autores[7] ],
          [ publi_autores[8] , cuenta_autores[8] ],
          [ publi_autores[9] , cuenta_autores[9] ],
          [ publi_autores[10] , cuenta_autores[10] ],
          [ publi_autores[11] , cuenta_autores[11] ],
          [ publi_autores[12] , cuenta_autores[12] ],
          [ publi_autores[13] , cuenta_autores[13] ],
          [ publi_autores[14] , cuenta_autores[14] ],
          [ publi_autores[15] , cuenta_autores[15] ],
          [ publi_autores[16] , cuenta_autores[16] ],
          [ publi_autores[17] , cuenta_autores[17] ],
          [ publi_autores[18] , cuenta_autores[18] ],
          [ publi_autores[19] , cuenta_autores[19] ],
          [ publi_autores[20] , cuenta_autores[20] ],
          [ publi_autores[21] , cuenta_autores[21] ],
          [ publi_autores[22] , cuenta_autores[22] ],
          [ publi_autores[23] , cuenta_autores[23] ],
          [ publi_autores[24] , cuenta_autores[24] ],
          [ publi_autores[25] , cuenta_autores[25] ],
          [ publi_autores[26] , cuenta_autores[26] ],
          [ publi_autores[27] , cuenta_autores[27] ],
          [ publi_autores[28] , cuenta_autores[28] ],
          [ publi_autores[29] , cuenta_autores[29] ]

        ]);

        var titulo = 'Publications and contribuition of other authors with '.concat(nombre_autor,apellidos_autor);
        var options = {
          title: titulo,
          pieHole: 0.3,
          keepAspectRatio: 'true', width: '100%'
        };

        var chart_donut = new google.visualization.PieChart(document.getElementById('container_autores'));  // Para pintar
        var chart = new google.visualization.PieChart(document.getElementById('container_autores'));

        // Wait for the chart to finish drawing before calling the getImageURI() method.   // Para pintar
        google.visualization.events.addListener(chart_donut, 'ready', function () {
          png_autores.innerHTML = '<img src="' + chart.getImageURI() + '">';
        });


        chart.draw(data, options);
        chart_donut.draw(data, options);    // Para pintar
        document.getElementById('png_autores').outerHTML = '<p class="boton_impresion"> <a href="' + chart_donut.getImageURI() + '"><img src="img/print_button.png"></img> Print chart</a></p>';  // Para pintar

      }


$(function () {

    // Generamos el gráfico de publicaciones/año y su título
    var titulo = 'Publications in the last years of ';
    titulo = titulo.concat(nombre_autor,apellidos_autor);

    $('#container_columns').highcharts({
        chart: {
            type: 'bar',
            margin: 75,
            zoomType: 'x' // Para ampliar al pinchar y arrastrar en el área
        },
        credits: {
            enabled: false
        },
        title: {
            text: titulo
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
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
            //type: 'area',   // Barras pasan a tener forma de area
            name: 'Number of publications',
            data: cuenta_publiaciones,         
        }],

            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            exporting: {
                filename: titulo,
                buttons: {
                    contextButton: {
                        text: 'Print chart',
                        symbol: 'url(img/print_button.png)',
                        menuItems: null,
                        onclick: function () {
                            this.exportChart();
                        }
                    }
                }
            }



    }); // acaba #container_columns





  //Calculamos los años y apariciones de un tema (SOLO HAY UN TEMA)
  var listaAnios_tema = <?php echo json_encode($phpanios_tema); ?>;
  var soloAnios_tema = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema.length; index++) {
    var ss = listaAnios_tema[index].split("-");
    soloAnios_tema[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema = new Array();
  for(var i=0;i< soloAnios_tema.length;i++){
    var key = soloAnios_tema[i];
    counts_tema[key] = (counts_tema[key])? counts_tema[key] + 1 : 1 ;       
  }

  // la función "unique" eliminará los elementos repetidos del array
  soloAnios_tema=soloAnios_tema.unique()


  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL PRIMER TEMA)
  var listaAnios_tema0 = <?php echo json_encode($phpanios_tema0); ?>;
  var soloAnios_tema0 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema0.length; index++) {
    var ss = listaAnios_tema0[index].split("-");
    soloAnios_tema0[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema0 = new Array();
  for(var i=0;i< soloAnios_tema0.length;i++){
    var key = soloAnios_tema0[i];
    counts_tema0[key] = (counts_tema0[key])? counts_tema0[key] + 1 : 1 ;       
  }


  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL SEGUNDO)
  var listaAnios_tema1 = <?php echo json_encode($phpanios_tema1); ?>;
  var soloAnios_tema1 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema1.length; index++) {
    var ss = listaAnios_tema1[index].split("-");
    soloAnios_tema1[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema1 = new Array();
  for(var i=0;i< soloAnios_tema1.length;i++){
    var key = soloAnios_tema1[i];
    counts_tema1[key] = (counts_tema1[key])? counts_tema1[key] + 1 : 1 ;       
  }


  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL TERCERO)
  var listaAnios_tema2 = <?php echo json_encode($phpanios_tema2); ?>;
  var soloAnios_tema2 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema2.length; index++) {
    var ss = listaAnios_tema2[index].split("-");
    soloAnios_tema2[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema2 = new Array();
  for(var i=0;i< soloAnios_tema2.length;i++){
    var key = soloAnios_tema2[i];
    counts_tema2[key] = (counts_tema2[key])? counts_tema2[key] + 1 : 1 ;       
  }


  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL CUARTO)
  var listaAnios_tema3 = <?php echo json_encode($phpanios_tema3); ?>;
  var soloAnios_tema3 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema3.length; index++) {
    var ss = listaAnios_tema3[index].split("-");
    soloAnios_tema3[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema3 = new Array();
  for(var i=0;i< soloAnios_tema3.length;i++){
    var key = soloAnios_tema3[i];
    counts_tema3[key] = (counts_tema3[key])? counts_tema3[key] + 1 : 1 ;       
  }

  // Para evitar fallos en los gráficos, evitamos añadirles variables indefinidas
  for(var aux =2003; aux <=2015; aux++){
    if( typeof counts_tema0[aux]=="undefined"){counts_tema0[aux]=0;}
    if( typeof counts_tema1[aux]=="undefined"){counts_tema1[aux]=0;}
    if( typeof counts_tema2[aux]=="undefined"){counts_tema2[aux]=0;}
    if( typeof counts_tema3[aux]=="undefined"){counts_tema3[aux]=0;}
  }


  //Rellenamos las variables de los gráficos con los datos 
  var anios =[];
  var publications=[];
  var series_temas ="";
  var title_temas ="Publications about ";
  var tema_autor = <?php echo json_encode($tema_aux); ?>;
  var lista_temas_autor = <?php echo json_encode($temas_aux); ?>;

  if(tema_autor != ""){

      title_temas = title_temas.concat(tema_autor,' of the author ',nombre_autor,apellidos_autor);     

      for (var i = 0; i < soloAnios_tema.length; i++) { 
        if ( (typeof soloAnios_tema[i]!="undefined")&&(soloAnios_tema[i]!="")) {
          publications.push(parseInt(counts_tema[soloAnios_tema[i]]));
          anios.push(parseInt(soloAnios_tema[i]));
        }
      }
      series_temas = [{
        name: tema_autor,
        data: publications }];
  }
  else{  
    //En caso de varios temas no podemos automatizarlo, ya que no coinciden los años entre varios temas: escogemos el rango de años de 2003 a 2015
      if(lista_temas_autor.length == 2){
        series_temas =[
            {
                name: lista_temas_autor[0],
                data: [counts_tema0[2003], counts_tema0[2004], counts_tema0[2005], counts_tema0[2006], counts_tema0[2007], counts_tema0[2008], counts_tema0[2009], counts_tema0[2010], counts_tema0[2011], counts_tema0[2012], counts_tema0[2013], counts_tema0[2014], counts_tema0[2015]]
            }, {
                name: lista_temas_autor[1],
                data: [counts_tema1[2003], counts_tema1[2004], counts_tema1[2005], counts_tema1[2006], counts_tema1[2007], counts_tema1[2008], counts_tema1[2009], counts_tema1[2010], counts_tema1[2011], counts_tema1[2012], counts_tema1[2013], counts_tema1[2014], counts_tema1[2015]]
            }];
        title_temas = title_temas.concat(lista_temas_autor[0],' and ',lista_temas_autor[1],' of ',nombre_autor,apellidos_autor);  
        anios = [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015] ;
      }
      else{ 
        if(lista_temas_autor.length == 3){
          series_temas =[
              {
                  name: lista_temas_autor[0],
                  data: [counts_tema0[2003], counts_tema0[2004], counts_tema0[2005], counts_tema0[2006], counts_tema0[2007], counts_tema0[2008], counts_tema0[2009], counts_tema0[2010], counts_tema0[2011], counts_tema0[2012], counts_tema0[2013], counts_tema0[2014], counts_tema0[2015]]
              }, {
                  name: lista_temas_autor[1],
                  data: [counts_tema1[2003], counts_tema1[2004], counts_tema1[2005], counts_tema1[2006], counts_tema1[2007], counts_tema1[2008], counts_tema1[2009], counts_tema1[2010], counts_tema1[2011], counts_tema1[2012], counts_tema1[2013], counts_tema1[2014], counts_tema1[2015]]
              }, {
                  name: lista_temas_autor[2],
                  data: [counts_tema2[2003], counts_tema2[2004], counts_tema2[2005], counts_tema2[2006], counts_tema2[2007], counts_tema2[2008], counts_tema2[2009], counts_tema2[2010], counts_tema2[2011], counts_tema2[2012], counts_tema2[2013], counts_tema2[2014], counts_tema2[2015]]
              }];
          title_temas = title_temas.concat(lista_temas_autor[0],', ',lista_temas_autor[1],' and ',lista_temas_autor[2],' of ',nombre_autor,apellidos_autor); 
          anios = [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015] ;
        } 
        else{ 

          series_temas =[
              {
                  name: lista_temas_autor[0],
                  data: [counts_tema0[2003], counts_tema0[2004], counts_tema0[2005], counts_tema0[2006], counts_tema0[2007], counts_tema0[2008], counts_tema0[2009], counts_tema0[2010], counts_tema0[2011], counts_tema0[2012], counts_tema0[2013], counts_tema0[2014], counts_tema0[2015]]
              }, {
                  name: lista_temas_autor[1],
                  data: [counts_tema1[2003], counts_tema1[2004], counts_tema1[2005], counts_tema1[2006], counts_tema1[2007], counts_tema1[2008], counts_tema1[2009], counts_tema1[2010], counts_tema1[2011], counts_tema1[2012], counts_tema1[2013], counts_tema1[2014], counts_tema1[2015]]
              }, {
                  name: lista_temas_autor[2],
                  data: [counts_tema2[2003], counts_tema2[2004], counts_tema2[2005], counts_tema2[2006], counts_tema2[2007], counts_tema2[2008], counts_tema2[2009], counts_tema2[2010], counts_tema2[2011], counts_tema2[2012], counts_tema2[2013], counts_tema2[2014], counts_tema2[2015]]
              }, {
                  name: lista_temas_autor[3],
                  data: [counts_tema3[2003], counts_tema3[2004], counts_tema3[2005], counts_tema3[2006], counts_tema3[2007], counts_tema3[2008], counts_tema3[2009], counts_tema3[2010], counts_tema3[2011], counts_tema3[2012], counts_tema3[2013], counts_tema3[2014], counts_tema3[2015]]
              }];
          title_temas = title_temas.concat(lista_temas_autor[0],', ',lista_temas_autor[1],', ',lista_temas_autor[2],' and ',lista_temas_autor[3],' of ',nombre_autor,apellidos_autor);
          anios = [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015] ;

        }    
      }         
  }//fin else


    // Generamos el gráfico con los temas del autor
    $('#container_varios').highcharts({

        chart: {
            type: 'column',
            zoomType: 'x'
        },
        credits: {
            enabled: false
        },
        title: {
            text: title_temas 
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    ''
        },
        xAxis: {
            categories: anios
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of publications'
            }
        },
        series: series_temas,

            navigation: {
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            exporting: {
                filename: title_temas,
                buttons: {
                    contextButton: {
                        text: 'Print chart',
                        symbol: 'url(img/print_button.png)',
                        menuItems: null,
                        onclick: function () {
                            this.exportChart();
                        }
                    }
                }
            }


    }); // acaba #container_varios



});// fin function

</script>

<?php

      $hay_entradas = $aux_entradas; // recuperamos el valor, ya que al consultar con los distintos temas del autor se a machacado

      if($hay_entradas){ 

        $idConsulta = $aux_aleatorio;
        $entradasTotales = $aux_totales;


        echo '<div id="container_columns" ></div><br>';

        if($entradasTotales<15){
          echo '<p id="cabecera"> <b>'.$entradasTotales.' latests publications: </b></p>'; 
        }
        else{
          echo '<p id="cabecera"><b> 15 latests publications: </b></p>';   
        }

        include 'muestra_publicaciones.php';   // MOSTRAMOS las publicaciones
        
        if($entradasTotales>15){
          echo'<p style="text-align: center; margin: 15px 0px 10px 0px""><a id="enlace_publicaciones" href="todas_publicaciones.php?consultaA1='.$autor.'&consultaA2='.$autor2.'" onclick="espera()"> See all publications </a> </p> ';   
        }
        echo '<hr>';

        //Borramos los datos de la consulta
        $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
        mysql_query($borratodo) or die(mysql_error()); 


      }
  


  if($muestra_temas_asociados){

    echo '<p id="cabecera" style="margin:40px 0"><b> Author subtopics</b> </p>'; 

    $tiene_entradas=true;

    if($tema!=""){
        echo "The author works with the subtopic: <b>".$tema_aux."</b> with ".$entradasTotales." entries. ";
        if($entradasTotales==0){$tiene_entradas=false;}
    }else{
        $contador_aux=0;;
        echo "The author works with the subtopics: ";
                for ($i = 0; $i < count($temas); $i++) { 
                      if($numero_publi_tema[$i] == 0){
                        echo "<b>".$temas_aux[$i]."</b> (without entries registred with this subtopic), ";
                      }
                      else{
                        echo "<b>".$temas_aux[$i]."</b> with ".$numero_publi_tema[$i]." entries, ";
                        $contador_aux=$contador_aux+$numero_publi_tema[$i];
                      }

                }
                if($contador_aux==0){$tiene_entradas=false;}

    }


    if($tiene_entradas){echo '<div id="container_varios" ></div>';}

  }else{
    echo "<p> <p class='text-center'> Author subtopics aren't registered </p></p>";  
  }
   



?>


  <p class="footer"> JCristobal </p>


    </div><!-- /.container -->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster  -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>



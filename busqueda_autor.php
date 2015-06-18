<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    

    <title>BibliometricAnalyzer: author analysis</title>

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

    <script language="javascript" type="text/javascript" src="js/arbor.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-tween.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-graphics.js"></script>
    <script language="javascript" type="text/javascript" src="js/arbor-renderer.js"></script>

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

        $autor_limpio = $_POST['busqueda_autor'];
        $autor = $_POST['busqueda_autor'];

        $autor_limpio2 = $_POST['busqueda_autor2'];
        $autor2 = $_POST['busqueda_autor2'];

        $enlace_autor = $_POST['busqueda_autor_enlace'];


        include_once('simple_html_dom.php');


        $autor_directo = $_POST['busqueda_directa'];
        $busqueda_coautor = $_POST['busqueda_coautor'];
        $enlace_aux = $enlace_autor;
        $nombre_aux = $autor_directo;  
        
        include_once('funciones.php');


        if(strlen($autor_directo)){

          //echo "DIRECTA";

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

          //echo  $busqueda_coautor;

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



        echo '<p>Did not you want to search this? <a href="index.html"> Go home </a> </p>';


        //include_once('simple_html_dom.php');           // http://simplehtmldom.sourceforge.net/

        // Create DOM from URL or file
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
          echo "<h1> Bibliometric analysis of the author ".$autor_limpio." ".$autor_limpio2."</h1>";


          echo '<div style=" float: left;  margin: 2px 2px 2px 2px;"> <b>'.$autor_limpio.' '.$autor_limpio2.'</b><br><img src="img/user.jpg" height="150" width="150"/><br> </div>'; 

          echo '<div style="float: left; margin: 15px 2px 2px 15px;"> No mail or affiliation verified </div>';

          echo "<p style='clear: left;'> ------- </p> ";

        }else{

          echo "<h1> Bibliometric analysis of the author ".$nombreGS."</h1>";

          echo "<p>enlace a autor en G Escolar: ".$enlace_autor."</p>";


          if($foto=='<img src="http://scholar.google.es/citations/images/avatar_scholar_150.jpg"/>'){
            $foto='<img src="img/user.jpg" height="150" width="150"/>';
          }

          echo '<div style=" float: left;  margin: 2px 2px 2px 2px;"> <b>'.$nombreGS.'</b><br>'.$foto.'<br> </div>'; 

          echo '<div style="float: left; margin: 15px 2px 2px 15px;">'.$email;
          echo "AFILIATION: ".$phpafiliacion[0]."</div>";

          echo "<p style='clear: left;'> ------- </p> ";


echo "
<script>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);

      var cssClassNames = {
        'headerRow': 'italic-darkblue-font large-font celda-datos',
        'tableRow': 'celda-datos',
        'oddTableRow': 'celda-datos',
        'selectedTableRow': 'large-font celda-datos',
        'hoverTableRow': 'celda-datos',
        'headerCell': 'celda-datos',
        'tableCell': 'celda-datos',
        'rowNumberCell': ' celda-datos'
      };

      var options = {'allowHtml': true, 'cssClassNames': cssClassNames, keepAspectRatio: 'true', width: '80%'};

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
    border-bottom-color: #008000;
    border-bottom-style: solid;
    border-width: 1px;
  }
</style>
";

          echo '<div id="tabla_datos"></div>';


        }
        echo "<p> ------- </p> ";


if(count($coautores)!=0){

    echo "<canvas id='grafo_autores' style='float: left; border-style: solid; border-width: 1px;' width='800' height='600'></canvas>

    <script language='javascript' type='text/javascript'>

        var sys = arbor.ParticleSystem(100, 400,0.5);
        sys.parameters({gravity:false});
        sys.renderer = Renderer('#grafo_autores') ;

        var data = {
          nodes:{
            autor_principal:{'color':'#000000','shape':'rectangle','label':'".$nombreGS."'},";

          $autores_vacios= array();

          $tamanio_aux=0;         
          if(count($coautores)>=11){
            for ($i = 0; $i <11; $i++) { 
                echo "autor".$i.":{'color':'#707070 ','label':'".$coautores[$i]."'},";
                $tamanio_aux++;

              $coautores_2_nivel= array();          
              $enlace_autor_relacionado= array('http://scholar.google.com',$enlace_coautores[$i]);
              $enlace_autor_relacionado=implode("", $enlace_autor_relacionado);

              $html = file_get_html($enlace_autor_relacionado);
              foreach($html->find('.gsc_rsb_aa') as $element){
                $coautores_2_nivel[]=$element->plaintext;
              }

              $vacio0=false;  $vacio1=false; $vacio2=false;

              // Mostramos sólo los 3 primeros autores relacionados (a 2º nivel)
              if($coautores_2_nivel[0] != ""){echo "autor0_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[0]."'},"; $vacio0=true;}
              if($coautores_2_nivel[1] != ""){echo "autor1_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[1]."'},"; $vacio1=true;}
              if($coautores_2_nivel[2] != ""){echo "autor2_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[2]."'},"; $vacio2=true;}

              $autores_vacios[]=array($vacio0,$vacio1,$vacio2); // Registramos si a encontrado algún autor (a segundo nivel) para después no mostrar un nodo vacío

            } // fin for
          }
          else{
              for ($i = 0; $i < count($coautores); $i++) { 
                echo "autor".$i.":{'color':'#707070 ','label':'".$coautores[$i]."'},";
                $tamanio_aux++;

              $coautores_2_nivel= array();          
              $enlace_autor_relacionado= array('http://scholar.google.com',$enlace_coautores[$i]);
              $enlace_autor_relacionado=implode("", $enlace_autor_relacionado);

              $html = file_get_html($enlace_autor_relacionado);
              foreach($html->find('.gsc_rsb_aa') as $element){
                $coautores_2_nivel[]=$element->plaintext;
              }

              $vacio0=false;  $vacio1=false; $vacio2=false;

              // Mostramos sólo los 3 primeros autores relacionados (a 2º nivel)
              if($coautores_2_nivel[0] != ""){echo "autor0_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[0]."'},"; $vacio0=true;}
              if($coautores_2_nivel[1] != ""){echo "autor1_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[1]."'},"; $vacio1=true;}
              if($coautores_2_nivel[2] != ""){echo "autor2_".$i.":{'color':'#B8B8B8','label':'".$coautores_2_nivel[2]."'},"; $vacio2=true;}

              $autores_vacios[]=array($vacio0,$vacio1,$vacio2); // Registramos si no ha encontrado algún autor (a segundo nivel) para después no mostrar un nodo vacío


              } 
          }


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
                  if($autores_vacios[$i][0]){ echo "autor0_".$i.":{}, ";}
                  if($autores_vacios[$i][1]){ echo "autor1_".$i.":{}, ";}
                  if($autores_vacios[$i][2]){ echo "autor2_".$i.":{}  ";}
                  echo "}, ";   
              } 

 echo"   }
        };

        sys.graft(data);

    </script> ";


        echo '<div id="lista_coautores" style=" border-style: solid; border-width: 1px;  float: left;">Coautores: <br>';
            for ($i = 0; $i < count($coautores); $i++) { 

              echo "<img style='float: left;' src='http://scholar.google.es/citations?view_op=view_photo&amp;".$img_coautores[$i]."&amp;citpid=1'  height='15%' width='15%'> </img>";          
              
              echo "<div style='float: left; max-width: 85%;' >".$coautores[$i]." y  <a href=\"http://scholar.google.es".$enlace_coautores[$i]."\"> enlace a GSCHOLAR </a>  "; 

               $coautores[$i] = iso2utf($coautores[$i]);

               echo " <form> <input type=\"text\" name=\"busqueda_directa\" style =\"visibility: hidden; width:1px; display: inline;\" value =".$coautores[$i]."> <input type=\"text\" name=\"busqueda_autor_enlace\" style =\"visibility: hidden; width:1px; display: inline;\" value =http://scholar.google.es".$enlace_coautores[$i]."> <input type=\"text\" name=\"busqueda_coautor\" style =\"visibility: hidden; width:1px; display: inline;\" value =true> <button type=\"submit\" formmethod=\"post\" formaction=\"busqueda_autor.php\" class=\"btn btn-link\">Info sobre el autor con este buscador</button></form><br>";
               echo "</div> <p style='clear: left;'>  </p>";
            } 
        echo "</div>";  // fin #lista_coautores


}
else{echo "Without coauthors registered";}

echo "<p style='clear: left;'> ----- </p>";




        echo "<p> ---------- CONSULTA A SCOPUS con ".$autor_limpio." ".$autor_limpio2."----------  </p>";


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
          $phpafiliacion[0] = iso2utf($phpafiliacion[0]);
          

        $consulta = array('http://api.elsevier.com/content/search/scopus?query=affil(',$phpafiliacion[0],')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json');   
*/
        $consulta = array('http://api.elsevier.com/content/search/scopus?query=AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 


        $idConsulta = mt_rand();

      include'conexion.php'; 

      include 'almacena_publicaciones.php';   // ALMACENAMOS EN LA BD las publicaciones

      
      echo " Total number of results: " .$entradasTotales,"<br><br>";

      if($hay_entradas){ 

        echo '<div id="container_columns" style="height: 400px"></div><br>';
              
      }

           $autor_limpio2 = str_replace("'", "\'", $autor_limpio2);

           $insert_autor = 'INSERT INTO autores(id,nombre, urlImagen, citas, citas_2010, h,h_2010, h10, h10_2010) VALUES (\''.$idConsulta.'\',\''.$autor_limpio.$autor_limpio2.'\',\''.$foto.'\',\''.$datos[0].'\',\''.$datos[1].'\',\''.$datos[2].'\',\''.$datos[3].'\',\''.$datos[4].'\',\''.$datos[5].'\')'; 
                                                                                  
           mysql_query($insert_autor) or die(mysql_error()); 
           echo "Autor almacenado<br>";

      if($hay_entradas){ 

        include 'muestra_publicaciones.php';   // MOSTRAMOS las publicaciones
      }
   

        $phpanios = array(); 
        $consulta_anios= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
        $resultados_anios=mysql_query($consulta_anios,$conexion);
        while ($row=mysql_fetch_array($resultados_anios)) {  
          $phpanios[]=$row['fecha_portada_0'];
        }



      $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD </p>";


      $tema="";
      $temas="";
      $muestra_temas_asociados=false;
      $tema_aux ="";  // Guardaremos estas variable "auxiliares" con el mismo valor para trabajar con ella una vez modificada para trabajar
      $temas_aux = array("");

      if($phpafiliacion[1]!=""){      // Si tiene temas asociados:

          $pos_coma = strrpos($phpafiliacion[1], ",");
          if ($pos_coma === false) { 
            //$tema_aux = $phpafiliacion[1];
            $tema = $phpafiliacion[1];
            $tema_aux=$tema; //echo "The author works with the subtopic: ".$tema;

            $tema = iso2utf($tema);


          } else {
         
            $temas = $phpafiliacion[1];
            $temas = split (",", $phpafiliacion[1]);

            //$clave_aleatoria = array_rand($temas, 1); // hay mas de un tema, escogemos uno al azar
            //$tema = $temas[$clave_aleatoria];
            //$tema = $temas[0]; // hay mas de un tema, escogemos el primero

            //echo "The author works with the subtopics: ";
            for ($i = 0; $i < count($temas); $i++) { 
                  $temas_aux[$i] = $temas[$i]; //echo $temas[$i].", ";

                  $temas[$i] = iso2utf($temas[$i]);

            } 
          }

//        echo "<p> And some publications of the subtopic <b>".$tema."</b>: </p>";



        $phpanios_tema = array("");
        $phpanios_tema0 = array(""); 
        $phpanios_tema1 = array("");
        $phpanios_tema2 = array("");
        $phpanios_tema3 = array("");
        $numero_publi_tema = array("");

        if($tema!=""){

            $consulta = array('http://api.elsevier.com/content/search/scopus?query=KEY(',$tema,')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 

            $idConsulta = mt_rand();
            include 'almacena_publicaciones.php';   


            //$phpanios_tema = array(); 
            $consulta_anios_tema= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
            $resultados_anios_tema=mysql_query($consulta_anios_tema,$conexion);
            while ($row=mysql_fetch_array($resultados_anios_tema)) {  
              $phpanios_tema[]=$row['fecha_portada_0'];
            }

            if($hay_entradas){ 

              $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
              mysql_query($borratodo) or die(mysql_error()); 
              echo "<p> Borrados los datos de la BD </p>";
            }

        }
        else{
          $tope=4;
          if(count($temas)<4){$tope=count($temas);}
          for ($indice = 0; $indice < $tope; $indice++) { 
            $consulta = array('http://api.elsevier.com/content/search/scopus?query=KEY(',$temas[$indice],')%20and%20AUTHOR-NAME(',$autor2,',',$autor,')&apiKey=',$apikey,'&httpAccept=application/json'); 
            $idConsulta = mt_rand();
            include 'almacena_publicaciones.php'; 
            $numero_publi_tema[$indice] =  $entradasTotales; 

            $consulta_anios_tema= "SELECT fecha_portada_0 FROM publicaciones WHERE id=".$idConsulta." ORDER BY `fecha_portada_0` ASC ";
            $resultados_anios_tema=mysql_query($consulta_anios_tema,$conexion);

            if($indice==0){
              //$phpanios_tema0 = array(); 
              while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                $phpanios_tema0[]=$row['fecha_portada_0'];
              }
            }
              
            if($indice==1){
              //$phpanios_tema1 = array(); 
              while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                $phpanios_tema1[]=$row['fecha_portada_0'];
              }
            }
            
            if($indice==2){
              //$phpanios_tema2 = array(); 
              while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                $phpanios_tema2[]=$row['fecha_portada_0'];
              }
            }
            if($indice==3){
              //$phpanios_tema3 = array(); 
              while ($row=mysql_fetch_array($resultados_anios_tema)) {  
                $phpanios_tema3[]=$row['fecha_portada_0'];
              }
            }

            $borratodo= "DELETE FROM publicaciones WHERE id=".$idConsulta;            
            mysql_query($borratodo) or die(mysql_error()); 
            echo "<p> Borrados los datos de la BD </p>";
        
          } // fin for
          
        }// fin else

      $muestra_temas_asociados=true;

      }
      


      ?>

      </div>



<script>



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
            /*options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            },*/
            zoomType: 'x' // Para ampliar al pinchar y arrastrar en el área
        },
        title: {
            text: 'Publications in the last years'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    ''
        },
        plotOptions: {
            column: {
                //depth: 25
            }
        },
        xAxis: {
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
            //type: 'area',   // Barras pasan a tener forma de area
            name: 'Number of publications',
            data: [counts[soloAnios[0]], counts[soloAnios[1]], counts[soloAnios[2]], counts[soloAnios[3]], counts[soloAnios[4]], counts[soloAnios[5]], counts[soloAnios[6]], counts[soloAnios[7]], counts[soloAnios[8]], counts[soloAnios[9]], counts[soloAnios[10]], counts[soloAnios[11]], counts[soloAnios[12]], counts[soloAnios[13]], counts[soloAnios[14]], counts[soloAnios[15]], counts[soloAnios[16]], counts[soloAnios[17]], counts[soloAnios[18]], counts[soloAnios[19]], counts[soloAnios[20]], counts[soloAnios[21]], counts[soloAnios[22]], counts[soloAnios[23]], counts[soloAnios[24]], counts[soloAnios[25]]]
            
        }
        ]

    }); // acaba #container_columns


  //Calculamos los años y apariciones de un tema (SOLO HAY UN TEMA)
  var listaAnios_tema = <?php echo json_encode($phpanios_tema); ?>;
  var soloAnios_tema = {};
  var soloAnios_tema = new Array();

  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema.length; index++) {
    var ss = listaAnios_tema[index].split("-");
    soloAnios_tema[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema = {};
  var counts_tema = new Array();
  for(var i=0;i< soloAnios_tema.length;i++){
    var key = soloAnios_tema[i];
    counts_tema[key] = (counts_tema[key])? counts_tema[key] + 1 : 1 ;       
  }

  // la función "unique" eliminará los elementos repetidos del array
  //soloAnios_tema=soloAnios_tema.unique()


  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL 1)
  var listaAnios_tema0 = <?php echo json_encode($phpanios_tema0); ?>;
  var soloAnios_tema0 = {};
  var soloAnios_tema0 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema0.length; index++) {
    var ss = listaAnios_tema0[index].split("-");
    soloAnios_tema0[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema0 = {};
  var counts_tema0 = new Array();
  for(var i=0;i< soloAnios_tema0.length;i++){
    var key = soloAnios_tema0[i];
    counts_tema0[key] = (counts_tema0[key])? counts_tema0[key] + 1 : 1 ;       
  }
  // la función "unique" eliminará los elementos repetidos del array
  //soloAnios_tema0=soloAnios_tema0.unique()
  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL 2)
  var listaAnios_tema1 = <?php echo json_encode($phpanios_tema1); ?>;
  var soloAnios_tema1 = {};
  var soloAnios_tema1 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema1.length; index++) {
    var ss = listaAnios_tema1[index].split("-");
    soloAnios_tema1[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema1 = {};
  var counts_tema1 = new Array();
  for(var i=0;i< soloAnios_tema1.length;i++){
    var key = soloAnios_tema1[i];
    counts_tema1[key] = (counts_tema1[key])? counts_tema1[key] + 1 : 1 ;       
  }
  // la función "unique" eliminará los elementos repetidos del array
  //soloAnios_tema1=soloAnios_tema1.unique()
  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL 3)
  var listaAnios_tema2 = <?php echo json_encode($phpanios_tema2); ?>;
  var soloAnios_tema2 = {};
  var soloAnios_tema2 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema2.length; index++) {
    var ss = listaAnios_tema2[index].split("-");
    soloAnios_tema2[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema2 = {};
  var counts_tema2 = new Array();
  for(var i=0;i< soloAnios_tema2.length;i++){
    var key = soloAnios_tema2[i];
    counts_tema2[key] = (counts_tema2[key])? counts_tema2[key] + 1 : 1 ;       
  }
  // la función "unique" eliminará los elementos repetidos del array
  //soloAnios_tema2=soloAnios_tema2.unique()
  //Calculamos los años y apariciones de un tema (CUANDO HAY VARIOS, DEL 4)
  var listaAnios_tema3 = <?php echo json_encode($phpanios_tema3); ?>;
  var soloAnios_tema3 = {};
  var soloAnios_tema3 = new Array();
  //Cogemos sólo el año de la fecha
  for(index = 0; index < listaAnios_tema3.length; index++) {
    var ss = listaAnios_tema3[index].split("-");
    soloAnios_tema3[index]=ss[0];
  }
  //Contamos las veces que se repite cada año
  var counts_tema3 = {};
  var counts_tema3 = new Array();
  for(var i=0;i< soloAnios_tema3.length;i++){
    var key = soloAnios_tema3[i];
    counts_tema3[key] = (counts_tema3[key])? counts_tema3[key] + 1 : 1 ;       
  }
  // la función "unique" eliminará los elementos repetidos del array
  //soloAnios_tema3=soloAnios_tema3.unique()



  for(var aux =2003; aux <=2015; aux++){
    if( typeof counts_tema0[aux]=="undefined"){counts_tema0[aux]=0;}
    if( typeof counts_tema1[aux]=="undefined"){counts_tema1[aux]=0;}
    if( typeof counts_tema2[aux]=="undefined"){counts_tema2[aux]=0;}
    if( typeof counts_tema3[aux]=="undefined"){counts_tema3[aux]=0;}
  }



  var series_temas ="";
  var title_temas ="Publications about ";
  var tema_autor = <?php echo json_encode($tema_aux); ?>;
  var lista_temas_autor = <?php echo json_encode($temas_aux); ?>;

  var nombre_autor = <?php echo json_encode($autor_limpio); ?>;
  var apellidos_autor = <?php echo json_encode($autor_limpio2); ?>;

  if(tema_autor != ""){
      series_temas = [{
                  name: tema_autor,
                  data: [counts_tema[2003], counts_tema[2004], counts_tema[2005], counts_tema[2006], counts_tema[2007], counts_tema[2008], counts_tema[2009], counts_tema[2010], counts_tema[2011], counts_tema[2012], counts_tema[2013], counts_tema[2014], counts_tema[2015]]
              }];
      title_temas = title_temas.concat(tema_autor,' of the author ',nombre_autor,apellidos_autor);      
  }
  else{  
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

        }    
      }         
  }//fin else



    $('#container_varios').highcharts({

        chart: {
            type: 'column',
            zoomType: 'x'
        },

        title: {
            text: title_temas //'Publications in the different (since 4) subtopics of the author'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    ''
        },
        xAxis: {
            categories: [2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Number of publications'
            }
        },
        series: series_temas

    }); // acaba #container_varios



});// fin function

</script>

<?php
  if($muestra_temas_asociados){

    if($tema!=""){
        echo "The author works with the subtopic: <b>".$tema_aux."</b> with ".$entradasTotales." entries. ";
    }else{
        echo "The author works with the subtopics: ";
                for ($i = 0; $i < count($temas); $i++) { 
                      if($numero_publi_tema[$i] == 0){
                        echo "<b>".$temas_aux[$i]."</b> (without entries registred with this subtopic), ";
                      }
                      else{
                        echo "<b>".$temas_aux[$i]."</b> with ".$numero_publi_tema[$i]." entries, ";
                      }

        }

    }


    echo '<div id="container_varios" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';

  }else{
    echo "<p>Topics aren't registered </p>";  
  }
   
?>
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



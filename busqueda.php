<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="consultas basicas">
    <meta name="author" content="JCristobal">
    <link rel="icon" href="BibliometricAnalyzer_icon.png"> 

    <title>BibliometricAnalyzer: authors</title>

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
    </script>
  </head>

  <body>

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

        $autor_limpio = $_POST['busqueda_basica_autor'];
        $autor2_limpio = $_POST['busqueda_basica_autor2'];

        $autor = $_POST['busqueda_basica_autor'];
        $autor2 = $_POST['busqueda_basica_autor2'];


        ///echo "<h1> Looking for authors ".$autor." ".$autor2."</h1>";

        include_once('simple_html_dom.php');           // simple_html_dom  http://simplehtmldom.sourceforge.net/


        $autor = str_replace(" ", "%20", $autor);
        $autor2 = str_replace(" ", "%20", $autor2);



 
        error_reporting( error_reporting() & ~E_NOTICE ); // Desactiva errores PHP    



        ///echo "<p> ---------- CONSULTA A GOOGLE ACADEM.----------  </p>";


                                                                                  //  &mauthors=autor:', $autor, '&hl=es&oi=ao');
        /*if($hay_nombre){
          $consulta2 = array('http://scholar.google.es/citations?view_op=search_authors&mauthors=', $autor, '&hl=en&oi=ao');     
        }
        if($hay_nombre2){
          $consulta2 = array('http://scholar.google.es/citations?view_op=search_authors&mauthors=', $autor2, '&hl=en&oi=ao');     
        }*/
        //if($hay_nombre && $hay_nombre2){
          $consulta2 = array('http://scholar.google.es/citations?view_op=search_authors&mauthors=', $autor,'%20',$autor2,'&hl=en&oi=ao');     
        //}

        $string2=implode("", $consulta2); 
        
        ///echo "( <a href='",$string2,"'> URL de consulta  </a> )";

        // Create DOM from URL or file
        $html = file_get_html($string2);


        $listaFotos = array();
        foreach($html->find('img') as $element){
               $foto = array('<img src="http://scholar.google.es',$element->src,'"</img>');
               $foto=implode("", $foto); 
               //echo $foto."<br>";
               $listaFotos[]= $foto ;
               
        }
        //
        $listaAutores = array(); 
        foreach($html->find('div.gsc_1usr_text h3 a') as $elemento){
               $author = array('http://scholar.google.es',$elemento->href);
               $author=implode("", $author); 
               $listaAutores[]= $author;
               
        }

        $listaNombres = array(); 
        foreach($html->find('div.gsc_1usr_text h3 a') as $elemento){
               ///echo $elemento->plaintext."<br>";
               $listaNombres[]= $elemento->plaintext;
               
        }


        $listaAfiliaciones = array(); 
        foreach($html->find('div.gsc_1usr_aff') as $elemento){
               $listaAfiliaciones[]= $elemento->plaintext;
               
        }
            

      ?>
    <h1> <p class='text-center'>Authors that match whith that name </p></h1>

    <script>
      //Copiamos los vectores  que hemos calculado con php
      var listaAut = <?php echo json_encode($listaAutores); ?>; 
      var listaFot = <?php echo json_encode($listaFotos); ?>; 
      var listaNom = <?php echo json_encode($listaNombres); ?>; 
      var listaAfil = <?php echo json_encode($listaAfiliaciones); ?>; 

//      var hay_nombre = <?php echo json_encode($hay_nombre); ?>;
//      var hay_nombre2 = <?php echo json_encode($hay_nombre2); ?>; 



      for(index = 0; index < listaAut.length; index++) {

          var autor = <?php echo json_encode($autor_limpio); ?>;
          var autor2 = <?php echo json_encode($autor2_limpio); ?>;

          if((index%2)==0){document.write("<div class='content-section-a'>");} // Alternamos la clase según las entradas
          else{document.write("<div class='content-section-b'>");}  

          document.write("<div class='entrada'>");

          if(listaFot[index]=='<img src="http://scholar.google.es/citations/images/avatar_scholar_150.jpg"</img>'){
            listaFot[index]='<img src="img/user.jpg" height="150" width="150"/>';
          }

          document.write("<div class='img_portada'>"+listaFot[index]+"</div>");
          document.write("<div class='cuerpo_entrada'> <b>"+listaNom[index]+"</b> <br>");
          document.write("Affiliation: "+listaAfil[index]+"<br>");
          
          var nombreCompleto = listaNom[index].split(" ");
          var inicial ="";

//          if(hay_nombre && hay_nombre2){
            autor = autor.split(" ");
            for(i = 0; i < autor.length; i++) {       // Tomamos la iniciales orientandonos en el nombre introducido
              inicial = inicial + autor[i].substring(0, 1)  + ".";
            }
            nombreCompleto.splice(0,autor.length);    // borramos solo el nombre orientandonos en el nombre introducido
            nombreCompleto = nombreCompleto.join(" ");
            ///document.write("(buscaremos por: "+inicial+" "+nombreCompleto+")");
/*          }else{
            if(hay_nombre){
              autor = autor.split(" ");
              for(i = 0; i < autor.length; i++) {      // Tomamos la iniciales orientandonos en el nombre introducido
                inicial = inicial + autor[i].substring(0, 1)  + ".";
              }
              nombreCompleto.splice(0,autor.length);  // borramos solo el nombre orientandonos en el nombre introducido
              nombreCompleto = nombreCompleto.join(" ");
              document.write("<b> buscaremos por: "+inicial+" "+nombreCompleto+"</b>");
            }
            else{                  // solo se ha introducido el apellido
              inicial = nombreCompleto[0].substring(0, 1)  + ".";
              nombreCompleto.splice(0,1);             // borramos la primera palabra, ya hemos cogido su inicial
              nombreCompleto = nombreCompleto.join(" ");
              document.write("<b> buscaremos por: "+inicial+" "+nombreCompleto+"</b>");
            }
          }
*/
          //document.write('<form> <input type="text" name="busqueda_autor_afil" style ="visibility: hidden; display: inline;" value ="'+listaAfil[index]+'"> <input type="text" name="busqueda_autor2" style ="visibility: hidden; display: inline;" value ="'+nombreCompleto+'">  <input type="text" name="busqueda_autor" style ="visibility: hidden; display: inline;" value ="'+inicial+'"> <input type="text" name="busqueda_autor_enlace" style ="visibility: hidden; display: inline;" value ="'+listaAut[index]+'"> <br> <button type="submit" formmethod="post" formaction="busqueda_autor.php" class="btn btn-default">Info sobre el autor </button></form>');
          document.write('<form> <input type="text" name="busqueda_autor2" style ="visibility: hidden; display: inline;" value ="'+nombreCompleto+'">  <input type="text" name="busqueda_autor" style ="visibility: hidden; display: inline;" value ="'+inicial+'"> <input type="text" name="busqueda_autor_enlace" style ="visibility: hidden; display: inline;" value ="'+listaAut[index]+'"> <br> <button type="submit" formmethod="post" formaction="busqueda_autor.php" class="btn btn-default" onclick="espera()"> Analysis of the author </button></form>');
          //document.write("<p> <a href='"+listaAut[index]+"'> Enlace (a G Scholar) del autor </a></p>");         
          document.write('</div> <div style="clear: left"> </div> ')          

          document.write("</div>"); // acaba .entrada
          document.write("</div>"); // acaba .content-section-a o .content-section-b
      }  

    </script>
      </div>

  <p class="footer"> JCristobal </p>
  
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



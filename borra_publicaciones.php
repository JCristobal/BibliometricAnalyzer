        <?php

      include'conexion.php';

      $borratodo= "DELETE FROM publicaciones";            
      mysql_query($borratodo) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD de publicaciones </p>";


      $borra= "DELETE FROM autores";            
      mysql_query($borra) or die(mysql_error()); 
      echo "<p> Borrados los datos de la BD de autores </p>";


            ?>

<form>
    <input type="submit" value="Atras" formaction="index.html">
</form>
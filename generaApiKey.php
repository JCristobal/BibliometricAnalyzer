<?php

    // Generaremos una apiKey aleatoriamente de una lista de válidas, ya que cada una tiene 20.000 peticiones como tope para algunas funcionalidades

	$listakey = array("f9d951921db393096886b2d49fd502a2", "fd2afde2e17f32ae0cb4e2ee24f54b44","38c9eb30742f13e6dec52dc324bc2377", "3e4a6a7418e11764249c10a0febb9e83");

    $clave_aleatoria = array_rand($listakey, 1);
    $apikey = $listakey[$clave_aleatoria];

?>

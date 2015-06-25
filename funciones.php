<?php

  function utf2iso($string){

        $string = str_replace("%20", " ", $string);
        $string = str_replace("%C3%A1", "á", $string);
        $string = str_replace("%C3%A9", "é", $string);
        $string = str_replace("%C3%AD", "í", $string);
        $string = str_replace("%C3%B3", "ó", $string);
        $string = str_replace("%C3%BA", "ú", $string);
        $string = str_replace("%2D", "-", $string);
        $string = str_replace("%27", "'", $string);
        $string = str_replace("%C3%A4","ä", $string);
        $string = str_replace("%C3%AB","ë", $string);
        $string = str_replace("%C3%AF","ï", $string);
        $string = str_replace("%C3%B6","ö", $string);
        $string = str_replace("%C3%BC","ü", $string);
        $string = str_replace("%C3%A5","å", $string);
        $string = str_replace("%C3%A0","à", $string);
		$string = str_replace("%C3%A8","è", $string);
		$string = str_replace("%C3%AC","ì", $string);
		$string = str_replace("%C3%B2","ò", $string);
		$string = str_replace("%C3%B9","ù", $string);


  	return $string;

  }


  function iso2utf($string){

        $string = str_replace(" ", "%20", $string);
        $string = str_replace("á", "%C3%A1", $string);
        $string = str_replace("é", "%C3%A9", $string);
        $string = str_replace("í", "%C3%AD", $string);
        $string = str_replace("ó", "%C3%B3", $string);
        $string = str_replace("ú", "%C3%BA", $string);
        $string = str_replace("-", "%2D", $string);
        $string = str_replace("'", "%27", $string);
        $string = str_replace("ä", "%C3%A4", $string);
        $string = str_replace("ë", "%C3%AB", $string);
        $string = str_replace("ï", "%C3%AF", $string);
        $string = str_replace("ö", "%C3%B6", $string);
        $string = str_replace("ü", "%C3%BC", $string);
        $string = str_replace("å", "%C3%A5", $string);
        $string = str_replace("à", "%C3%A0", $string);
		$string = str_replace("è", "%C3%A8", $string);
		$string = str_replace("ì", "%C3%AC", $string);
		$string = str_replace("ò", "%C3%B2", $string);
		$string = str_replace("ù", "%C3%B9", $string);

  	return $string;

  }


?>


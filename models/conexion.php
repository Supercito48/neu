<?php
  

class Conexion
{

	static public function conectar()
	{

		 $link = new PDO(
			"mysql:host=localhost;dbname=zanahori_pos",
			"root",
			""
        );  

		/* $link = new PDO(
			"mysql:host=localhost;dbname=system_pos",
			"root",
			""
        );  */
		
        
		$link->exec("set names utf8"); 

		return $link;

	}


}
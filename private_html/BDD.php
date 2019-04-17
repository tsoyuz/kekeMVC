<?php

	class BDD
	{

		//Connexion mysqli
		private $_mysqli;
		
		//Constructeur
		public function __construct()
		{
			$host = "localhost";
			$user = "bdd";
			$pwd = "motDePasse;
			$db = "keke";
			
			//Se connecte à la base s'il peut, sinon renvoi l'erreur
			$this->_mysqli = new mysqli($host,$user,$pwd,$db);
			if ($this->_mysqli->connect_errno)
				echo "Echec lors de la connexion à MySQL : " . $this->_mysqli->connect_error;
		}
		
		//Fermer la connexion
		public function fermer()
		{
			$this->_mysqli->close();
		}
		
		//Faire une requete
		public function requete($query)
		{
			return $this->_mysqli->query($query);
		}
	
	}
	

?>

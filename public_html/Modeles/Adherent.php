<?php

	require_once "Modele.php";

	//Modèle
	class Adherent extends Modele
	{
		//Variable
		private $_pseudo;
		private $_mail;
		private $_mdpHash;
		private $_estAdmin;
		
		//Constructeur
		public function __construct()
		{
			//Appelle le constructeur de la classe mère
			parent::__construct();
			
			//Initialise les variables
			$this->_pseudo = "UnPseudo";
			$this->_mail = "Pseudo@mail.com";
			$this->_mdpHash = "mdp";
			$this->_estAdmin = 0;
			
		}
		
		//Modifie les variables de l'adherent
		public function set($pseudo,$mail,$mdpHash,$estAdmin)
		{
			$this->_pseudo = $pseudo;
			$this->_mail = $mail;
			$this->_mdpHash = $mdpHash;
			$this->_estAdmin = $estAdmin;
		}
		
		//Créer la table
		public function bddTable()
		{
			$this->getBDD()->requete("
			CREATE TABLE IF NOT EXISTS `Adherent` (
			`Pseudo` varchar(32) NOT NULL,
			`Mail` varchar(64) NOT NULL,
			`MotDePasse` varchar(64) NOT NULL,
			`EstAdmin` int(1) NOT NULL,
			PRIMARY KEY (`Pseudo`) );");
		}
		
		//Selectionne un adhérent avec son pseudo et le hash du mot de passe
		public function bddSelect()
		{
			$req = $this->getBDD()->requete("SELECT * FROM Adherent WHERE Pseudo='" .$this->_pseudo  ."';");
			if($req->num_rows == 1)
			{
				$adh = mysqli_fetch_assoc($req);

				//Vérifie le mot de passe avec son hash
				if(password_verify($this->_mdpHash,$adh["MotDePasse"]) == true )
				{
					//Selection réussi
					set($adh["Pseudo"],$adh["Mail"],$adh["MotDePasse"],$adh["EstAdmin"]);
					return true;
				}
				else
					return false;
			}
			else
				return false;
		}
		
		//Insert un adhérent
		public function bddInsert()
		{
			$this->getBDD()->requete("INSERT INTO Adherent VALUES ('" .$this->_pseudo ."','" .$this->_mail ."','" .$this->_mdpHash ."'," .$this->_estAdmin .");");
		}

		//Modifie un adhérent
		public function bddUpdate($key)
		{
			$this->getBDD()->requete("UPDATE Adherent SET ('" .$this->_pseudo ."','" .$this->_mail ."','" .$this->_mdpHash ."'," .$this->_estAdmin .")
								WHERE Pseudo='" .$key ."';");
		}
		
		//Chargement du modèle par le controleur
		public function ctrlLoad()
		{
			//Inclue la vue
			require_once "Vues/Adherent.html";
		}
		
		
		//
	}
	
	////////////////////////////Code a exécuter lors de l'importation
	
	//Créer un objet adhérent
	$adh = new Adherent();
	$adh->bddTable();
	
	//Chargement par le modèle
	if(isset($_GET["modele"]) && $_GET["modele"] == "Adherent")
		$adh->ctrlLoad();	
	

?>

<?php
class Chat {
	private $prenom;
	private $age;
	private $couleur;
	private $sexe;
    private $race;
    
    // On définit une constante pour le sexe
    const SEXE_POSSIBLE = ['male', 'femelle'];
    
	public function __construct($prenom, $age, $couleur, $sexe, $race){
		$this->setPrenom($prenom);
		$this->setAge($age);
		$this->setCouleur($couleur);
		$this->setSexe($sexe);
		$this->setRace($race);
    }

	/**
	 * Get the value of prenom
	 */ 
	public function getPrenom()
	{
		return $this->prenom;
	}

	/**
	 * Set the value of prenom
	 *
	 * @return  self
	 */ 
	public function setPrenom($prenom)
	{
		if(is_string($prenom) && strlen($prenom) >= 3 && strlen($prenom) <= 20){
			$this->prenom = $prenom;
			return $this;
		}
		else {
			trigger_error("Le prénom n'est pas valide", E_USER_WARNING);
			return false;
		}
	}

	/**
	 * Get the value of age
	 */ 
	public function getAge()
	{
		return $this->age;
	}

	/**
	 * Set the value of age
	 *
	 * @return  self
	 */ 
	public function setAge($age)
	{
		if(is_int($age)){
			$this->age = $age;
			return $this;
		}
		else {
			trigger_error("L'âge n'est pas valide", E_USER_WARNING);
			return false;
		}
	}

	/**
	 * Get the value of couleur
	 */ 
	public function getCouleur()
	{
		return $this->couleur;
	}

	/**
	 * Set the value of couleur
	 *
	 * @return  self
	 */ 
	public function setCouleur($couleur)
	{
		if(is_string($couleur) && strlen($couleur) >= 3 && strlen($couleur) <= 10){
			$this->couleur = $couleur;
			return $this;
		}
		else {
			trigger_error("La couleur n'est pas valide", E_USER_WARNING);
			return false;
		}
	}

	/**
	 * Get the value of sexe
	 */ 
	public function getSexe()
	{
		return $this->sexe;
	}

	/**
	 * Set the value of sexe
	 *
	 * @return  self
	 */ 
	public function setSexe($sexe)
	{
		if(in_array($sexe, self::SEXE_POSSIBLE)){
			$this->sexe = $sexe;
			return $this;
		}
		else {
			trigger_error("Le sexe n'est pas valide", E_USER_WARNING);
			return false;
		}
	}

    /**
     * Get the value of race
     */ 
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Set the value of race
     *
     * @return  self
     */ 
    public function setRace($race)
    {
        if(is_string($race) && (strlen($race) >= 3 && strlen($race) <= 20)){
			$this->race = $race;
			return $this;
		}
		else {
			trigger_error("La race n'est pas valide", E_USER_WARNING);
			return false;
		}
	}
	
	/**
	 * Méthode pour retourner la totalité des propriétés sous forme de tableau
	 * @return array
	 */
	public function getInfos(){
		$infos = [
			'prenom' => $this->getPrenom(),
			'age'	 => $this->getAge(),
			'couleur'=> $this->getCouleur(),
			'sexe'=> $this->getSexe(),
			'race'	 => $this->getRace()
		];
		return $infos;
	}
}
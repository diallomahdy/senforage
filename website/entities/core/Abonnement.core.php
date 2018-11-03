<?php

/**
 * Class Abonnement_core
 * Entity class for object oriented management of the MySQL table abonnement
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Abonnement_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table abonnement
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idClient defined as int(10) unsigned
     *
     * @var int $idClient
     */
    protected $idClient;

    /**
     * Class attribute for mapping table field idCompteur defined as int(10) unsigned
     *
     * @var int $idCompteur
     */
    protected $idCompteur;

    /**
     * Class attribute for mapping table field numero defined as char(10)
     *
     * @var string $numero
     */
    protected $numero;

    /**
     * Class attribute for mapping table field date defined as string|date
     *
     * @var string $date
     */
    protected $date;

    /**
     * Class attribute for mapping table field description defined as text
     *
     * @var string $description
     */
    protected $description;

    /**
     * setId Sets the class attribute id with a given value
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * setIdClient Sets the class attribute idClient with a given value
     *
     * @param int $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = (int)$idClient;
    }

    /**
     * setIdCompteur Sets the class attribute idCompteur with a given value
     *
     * @param int $idCompteur
     */
    public function setIdCompteur($idCompteur)
    {
        $this->idCompteur = (int)$idCompteur;
    }

    /**
     * setNumero Sets the class attribute numero with a given value
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = (string)$numero;
    }

    /**
     * setDate Sets the class attribute date with a given value
     *
     * @param string $date
     */
    public function setDate($date)
    {
        $this->date = (string)$date;
    }

    /**
     * setDescription Sets the class attribute description with a given value
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;
    }

    /**
     * getId gets the class attribute id value
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * getIdClient gets the class attribute idClient value
     *
     * @return int $idClient
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * getIdCompteur gets the class attribute idCompteur value
     *
     * @return int $idCompteur
     */
    public function getIdCompteur()
    {
        return $this->idCompteur;
    }

    /**
     * getNumero gets the class attribute numero value
     *
     * @return string $numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * getDate gets the class attribute date value
     *
     * @return string $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * getDescription gets the class attribute description value
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

}
?>

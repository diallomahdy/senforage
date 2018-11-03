<?php

/**
 * Class Compteur_core
 * Entity class for object oriented management of the MySQL table compteur
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Compteur_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table compteur
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idEtatCompteur defined as tinyint(1) unsigned
     *
     * @var int $idEtatCompteur
     */
    protected $idEtatCompteur;

    /**
     * Class attribute for mapping table field numero defined as char(10)
     *
     * @var string $numero
     */
    protected $numero;

    /**
     * Class attribute for mapping table field pointeur defined as int(10) unsigned
     *
     * @var int $pointeur
     */
    protected $pointeur;

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
     * setIdEtatCompteur Sets the class attribute idEtatCompteur with a given value
     *
     * @param int $idEtatCompteur
     */
    public function setIdEtatCompteur($idEtatCompteur)
    {
        $this->idEtatCompteur = (int)$idEtatCompteur;
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
     * setPointeur Sets the class attribute pointeur with a given value
     *
     * @param int $pointeur
     */
    public function setPointeur($pointeur)
    {
        $this->pointeur = (int)$pointeur;
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
     * getIdEtatCompteur gets the class attribute idEtatCompteur value
     *
     * @return int $idEtatCompteur
     */
    public function getIdEtatCompteur()
    {
        return $this->idEtatCompteur;
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
     * getPointeur gets the class attribute pointeur value
     *
     * @return int $pointeur
     */
    public function getPointeur()
    {
        return $this->pointeur;
    }

}
?>

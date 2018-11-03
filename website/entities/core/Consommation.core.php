<?php

/**
 * Class Consommation_core
 * Entity class for object oriented management of the MySQL table consommation
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Consommation_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table consommation
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idCompteur defined as int(10) unsigned
     *
     * @var int $idCompteur
     */
    protected $idCompteur;

    /**
     * Class attribute for mapping table field idTarif defined as smallint(5) unsigned
     *
     * @var int $idTarif
     */
    protected $idTarif;

    /**
     * Class attribute for mapping table field quantiteChiffre defined as mediumint(8) unsigned
     *
     * @var int $quantiteChiffre
     */
    protected $quantiteChiffre;

    /**
     * Class attribute for mapping table field quantiteLettre defined as varchar(100)
     *
     * @var string $quantiteLettre
     */
    protected $quantiteLettre;

    /**
     * Class attribute for mapping table field date defined as string|date
     *
     * @var string $date
     */
    protected $date;

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
     * setIdCompteur Sets the class attribute idCompteur with a given value
     *
     * @param int $idCompteur
     */
    public function setIdCompteur($idCompteur)
    {
        $this->idCompteur = (int)$idCompteur;
    }

    /**
     * setIdTarif Sets the class attribute idTarif with a given value
     *
     * @param int $idTarif
     */
    public function setIdTarif($idTarif)
    {
        $this->idTarif = (int)$idTarif;
    }

    /**
     * setQuantiteChiffre Sets the class attribute quantiteChiffre with a given value
     *
     * @param int $quantiteChiffre
     */
    public function setQuantiteChiffre($quantiteChiffre)
    {
        $this->quantiteChiffre = (int)$quantiteChiffre;
    }

    /**
     * setQuantiteLettre Sets the class attribute quantiteLettre with a given value
     *
     * @param string $quantiteLettre
     */
    public function setQuantiteLettre($quantiteLettre)
    {
        $this->quantiteLettre = (string)$quantiteLettre;
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
     * getId gets the class attribute id value
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
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
     * getIdTarif gets the class attribute idTarif value
     *
     * @return int $idTarif
     */
    public function getIdTarif()
    {
        return $this->idTarif;
    }

    /**
     * getQuantiteChiffre gets the class attribute quantiteChiffre value
     *
     * @return int $quantiteChiffre
     */
    public function getQuantiteChiffre()
    {
        return $this->quantiteChiffre;
    }

    /**
     * getQuantiteLettre gets the class attribute quantiteLettre value
     *
     * @return string $quantiteLettre
     */
    public function getQuantiteLettre()
    {
        return $this->quantiteLettre;
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

}
?>

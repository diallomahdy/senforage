<?php

/**
 * Class Client_core
 * Entity class for object oriented management of the MySQL table client
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Client_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table client
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idChef defined as int(10) unsigned
     *
     * @var int $idChef
     */
    protected $idChef;

    /**
     * Class attribute for mapping table field idVillage defined as int(10) unsigned
     *
     * @var int $idVillage
     */
    protected $idVillage;

    /**
     * Class attribute for mapping table field nomFamille defined as varchar(50)
     *
     * @var string $nomFamille
     */
    protected $nomFamille;

    /**
     * Class attribute for mapping table field telephone defined as char(10)
     *
     * @var string $telephone
     */
    protected $telephone;

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
     * setIdChef Sets the class attribute idChef with a given value
     *
     * @param int $idChef
     */
    public function setIdChef($idChef)
    {
        $this->idChef = (int)$idChef;
    }

    /**
     * setIdVillage Sets the class attribute idVillage with a given value
     *
     * @param int $idVillage
     */
    public function setIdVillage($idVillage)
    {
        $this->idVillage = (int)$idVillage;
    }

    /**
     * setNomFamille Sets the class attribute nomFamille with a given value
     *
     * @param string $nomFamille
     */
    public function setNomFamille($nomFamille)
    {
        $this->nomFamille = (string)$nomFamille;
    }

    /**
     * setTelephone Sets the class attribute telephone with a given value
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = (string)$telephone;
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
     * getIdChef gets the class attribute idChef value
     *
     * @return int $idChef
     */
    public function getIdChef()
    {
        return $this->idChef;
    }

    /**
     * getIdVillage gets the class attribute idVillage value
     *
     * @return int $idVillage
     */
    public function getIdVillage()
    {
        return $this->idVillage;
    }

    /**
     * getNomFamille gets the class attribute nomFamille value
     *
     * @return string $nomFamille
     */
    public function getNomFamille()
    {
        return $this->nomFamille;
    }

    /**
     * getTelephone gets the class attribute telephone value
     *
     * @return string $telephone
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

}
?>

<?php

/**
 * Class Chef_core
 * Entity class for object oriented management of the MySQL table Chef
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Chef_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table Chef
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idVillage defined as int(10) unsigned
     *
     * @var int $idVillage
     */
    protected $idVillage;

    /**
     * Class attribute for mapping table field prenom defined as varchar(100)
     *
     * @var string $prenom
     */
    protected $prenom;

    /**
     * Class attribute for mapping table field nom defined as varchar(50)
     *
     * @var string $nom
     */
    protected $nom;

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
     * setIdVillage Sets the class attribute idVillage with a given value
     *
     * @param int $idVillage
     */
    public function setIdVillage($idVillage)
    {
        $this->idVillage = (int)$idVillage;
    }

    /**
     * setPrenom Sets the class attribute prenom with a given value
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = (string)$prenom;
    }

    /**
     * setNom Sets the class attribute nom with a given value
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = (string)$nom;
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
     * getIdVillage gets the class attribute idVillage value
     *
     * @return int $idVillage
     */
    public function getIdVillage()
    {
        return $this->idVillage;
    }

    /**
     * getPrenom gets the class attribute prenom value
     *
     * @return string $prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * getNom gets the class attribute nom value
     *
     * @return string $nom
     */
    public function getNom()
    {
        return $this->nom;
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

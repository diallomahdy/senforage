<?php

/**
 * Class Village_core
 * Entity class for object oriented management of the MySQL table village
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Village_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table village
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field nom defined as varchar(100)
     *
     * @var string $nom
     */
    protected $nom;

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
     * setNom Sets the class attribute nom with a given value
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = (string)$nom;
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
     * getNom gets the class attribute nom value
     *
     * @return string $nom
     */
    public function getNom()
    {
        return $this->nom;
    }

}
?>

<?php

/**
 * Class EtatCompteur_core
 * Entity class for object oriented management of the MySQL table etatCompteur
 *
 * @extends EntityCore
 * @category Entity Class
*/

class EtatCompteur_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table etatCompteur
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field label defined as varchar(20)
     *
     * @var string $label
     */
    protected $label;

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
     * setLabel Sets the class attribute label with a given value
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = (string)$label;
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
     * getLabel gets the class attribute label value
     *
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

}
?>

<?php

/**
 * Class Tarif_core
 * Entity class for object oriented management of the MySQL table tarif
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Tarif_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table tarif
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field prixLitre defined as float unsigned
     *
     * @var float $prixLitre
     */
    protected $prixLitre;

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
     * setPrixLitre Sets the class attribute prixLitre with a given value
     *
     * @param float $prixLitre
     */
    public function setPrixLitre($prixLitre)
    {
        $this->prixLitre = (float)$prixLitre;
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
     * getPrixLitre gets the class attribute prixLitre value
     *
     * @return float $prixLitre
     */
    public function getPrixLitre()
    {
        return $this->prixLitre;
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

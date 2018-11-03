<?php

/**
 * Class Reglement_core
 * Entity class for object oriented management of the MySQL table reglement
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Reglement_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table reglement
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idFacture defined as int(10) unsigned
     *
     * @var int $idFacture
     */
    protected $idFacture;

    /**
     * Class attribute for mapping table field datePaiement defined as string|date
     *
     * @var string $datePaiement
     */
    protected $datePaiement;

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
     * setIdFacture Sets the class attribute idFacture with a given value
     *
     * @param int $idFacture
     */
    public function setIdFacture($idFacture)
    {
        $this->idFacture = (int)$idFacture;
    }

    /**
     * setDatePaiement Sets the class attribute datePaiement with a given value
     *
     * @param string $datePaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = (string)$datePaiement;
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
     * getIdFacture gets the class attribute idFacture value
     *
     * @return int $idFacture
     */
    public function getIdFacture()
    {
        return $this->idFacture;
    }

    /**
     * getDatePaiement gets the class attribute datePaiement value
     *
     * @return string $datePaiement
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

}
?>

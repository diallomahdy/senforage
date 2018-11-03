<?php

/**
 * Class Facture_core
 * Entity class for object oriented management of the MySQL table facture
 *
 * @extends EntityCore
 * @category Entity Class
*/

class Facture_core extends EntityCore
{

    /**
     * Class attribute for mapping the primary key id of table facture
     *
     * Comment for field id: Not specified<br>
     * @var int $id
     */
    protected $id;

    /**
     * Class attribute for mapping table field idConsommation defined as int(10) unsigned
     *
     * @var int $idConsommation
     */
    protected $idConsommation;

    /**
     * Class attribute for mapping table field numero defined as char(10)
     *
     * @var string $numero
     */
    protected $numero;

    /**
     * Class attribute for mapping table field montant defined as int(10) unsigned
     *
     * @var int $montant
     */
    protected $montant;

    /**
     * Class attribute for mapping table field dateFacturation defined as string|date
     *
     * @var string $dateFacturation
     */
    protected $dateFacturation;

    /**
     * Class attribute for mapping table field dateLimitePaiement defined as string|date
     *
     * @var string $dateLimitePaiement
     */
    protected $dateLimitePaiement;

    /**
     * Class attribute for mapping table field paye defined as tinyint(1)
     *
     * @var int $paye
     */
    protected $paye;

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
     * setIdConsommation Sets the class attribute idConsommation with a given value
     *
     * @param int $idConsommation
     */
    public function setIdConsommation($idConsommation)
    {
        $this->idConsommation = (int)$idConsommation;
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
     * setMontant Sets the class attribute montant with a given value
     *
     * @param int $montant
     */
    public function setMontant($montant)
    {
        $this->montant = (int)$montant;
    }

    /**
     * setDateFacturation Sets the class attribute dateFacturation with a given value
     *
     * @param string $dateFacturation
     */
    public function setDateFacturation($dateFacturation)
    {
        $this->dateFacturation = (string)$dateFacturation;
    }

    /**
     * setDateLimitePaiement Sets the class attribute dateLimitePaiement with a given value
     *
     * @param string $dateLimitePaiement
     */
    public function setDateLimitePaiement($dateLimitePaiement)
    {
        $this->dateLimitePaiement = (string)$dateLimitePaiement;
    }

    /**
     * setPaye Sets the class attribute paye with a given value
     *
     * @param int $paye
     */
    public function setPaye($paye)
    {
        $this->paye = (int)$paye;
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
     * getIdConsommation gets the class attribute idConsommation value
     *
     * @return int $idConsommation
     */
    public function getIdConsommation()
    {
        return $this->idConsommation;
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
     * getMontant gets the class attribute montant value
     *
     * @return int $montant
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * getDateFacturation gets the class attribute dateFacturation value
     *
     * @return string $dateFacturation
     */
    public function getDateFacturation()
    {
        return $this->dateFacturation;
    }

    /**
     * getDateLimitePaiement gets the class attribute dateLimitePaiement value
     *
     * @return string $dateLimitePaiement
     */
    public function getDateLimitePaiement()
    {
        return $this->dateLimitePaiement;
    }

    /**
     * getPaye gets the class attribute paye value
     *
     * @return int $paye
     */
    public function getPaye()
    {
        return $this->paye;
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

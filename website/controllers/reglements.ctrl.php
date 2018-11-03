<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reglements extends Controller {

    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité village => inclure le fichier /entities/Village.entity.php 
        $this->loadEntity('reglement');
        $this->loadEntity('facture');
        $this->loadEntity('tarif');
        $this->loadEntity('compteur');
        $this->loadEntity('consommation');
    }

    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        if (isset($this->post->facture)) {
            $this->detail(0);
        } elseif (isset($this->post->compteur)) {
            $this->detail(1);
        } elseif (isset($this->post->generateFacture)) {
            $this->generateFacture();
        } elseif (isset($this->post->payFacture)) {
            $this->payFacture();
        } elseif (isset($this->post->couperCompteur)) {
            $this->couperCompteur();
        } else {
            $this->liste();
        }
    }
    
    public function facture($id) {
        if (isset($this->post->payFacture)) {
            $this->payFacture();
        } else {
            $this->post->facture = $id;
            $this->detail(0);
        }
    }

    // Charger la vue lister
    public function liste() {
        // Charger la vue liste compteur
        $this->loadView('liste', 'content');
        // Lire les compteurs à partir de la bd et formater
        //$reglements = $this->em->selectAll('reglement');
        //$reglements = $this->em->getRefined($reglements);
        $liste = $this->em->selectAll('facture');
        $html = '';
        foreach ($liste as $key => $entity) {
            $state = 'impayée';
            if ($entity->getPaye()) {
                $state = 'payée';
            }
            $consommation = $this->em->selectById('consommation', $entity->getId());
            $compteur = $this->em->selectById('compteur', $consommation->getIdCompteur());
            $html .= '<tr>';
            $html .= '<td>' . $entity->getId() . '</td>';
            $html .= '<td><a href="reglements/facture/' . $entity->getNumero() . '">' . $entity->getNumero() . '</a></td>';
            $html .= '<td>' . $compteur->getNumero() . '</td>';
            $html .= '<td>' . $consommation->getQuantiteChiffre() . ' litres</td>';
            $html .= '<td>' . $entity->getMontant() . ' FCFA</td>';
            $html .= '<td>' . $state . '</td>';
            $html .= '</tr>';
        }
        // Ajouter les compteurs à la vue
        $this->loadHtml($html, 'list');
    }

    // Charger la vue detail    
    public function detail($context) {
        if (isset($this->post->compteur)) {
            $arrCompteur = $this->em->selectByAttr('compteur', 'numero', $this->post->compteur);
            $back_btn = '<div class="align-content-center"><a href="reglements" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Retour </a></div>';
            if (empty($arrCompteur)) {
                $this->handleStatus('Compteur introuvable.');
                $this->loadHtml($back_btn, 'content');
                return;
            }
            $compteur = $arrCompteur[0];
            $arrConso = $this->em->selectByAttr('consommation', 'idCompteur', $compteur->getId());
            if (empty($arrConso)) {
                $this->handleStatus('Aucune consommation pour ce compteur.');
                $this->loadHtml($back_btn, 'content');
                return;
            }
            $conso = $arrConso[0];
            //$facture = $this->em->selectById('facture', $conso->getId());
            $condition = 'cs.idCompteur=' . $compteur->getId() . ' AND f.idConsommation=cs.id AND f.paye=0';
            $this->em->entityName = 'facture';
            $arrFacture = $this->em->select('f.*')->from('facture f, consommation cs')->where($condition)->queryExcec();
            //var_dump($arrFacture); exit;
            if (empty($arrFacture)) {
                $facture = $this->em->selectById('facture', $conso->getId());
                if (empty($facture)) {
                    $this->handleStatus('Facture non éditée.');
                } else {
                    $this->handleStatus('Aucune facture à payer.');
                }
                $this->loadHtml($back_btn, 'content');
                return;
            }
        } elseif (isset($this->post->facture)) {
            $arrFacture = $this->em->selectByAttr('facture', 'numero', $this->post->facture);
            $back_btn = '<div class="align-content-center"><a href="reglements" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Retour </a></div>';
            if (empty($arrFacture)) {
                $this->handleStatus('Facture introuvable.');
                $this->loadHtml($back_btn, 'content');
                return;
            } else {
                $conso = $this->em->selectById('consommation', $arrFacture[0]->getId());
            }
        }
        $facture = $arrFacture[0];
        $this->loadView('detail', 'content');
        $this->dom->getElementById('facture')->innertext = $facture->getNumero();
        $this->dom->getElementById('consommation')->innertext = $conso->getQuantiteChiffre() . ' Litres';
        $this->dom->getElementById('montant')->innertext = $facture->getMontant() . ' FCFA';
        $this->dom->getElementById('dateConso')->innertext = Helper::getDate($conso->getDate());
        $this->dom->getElementById('dateFacturation')->innertext = Helper::getDate($facture->getDateFacturation());
        $this->dom->getElementById('dateLimitePaiement')->innertext = Helper::getDate($facture->getDateLimitePaiement());
        if ($facture->getPaye()) {
            $montant = 'Déja payée';
        } else {
            $montant = $facture->getMontant();
            if ($this->date > $facture->getDateLimitePaiement()) {
                $montant += $montant * 0.05;
            }
            $montant .= ' FCFA';
            $form = '<form method="POST" class="margin-20px clearfix align-content-center">';
            $form .= '<button type="submit" name="payFacture" id="payFacture" value="' . $facture->getId() . '" class="btn btn-primary"><i class="glyphicon glyphicon-play"></i> Payer </button>';
            $form .= '</form>';
            $this->dom->getElementById('payForm')->innertext = $form;
        }
        $this->dom->getElementById('montant2')->innertext = $montant;
    }

    public function generateFacture() {
        $arrConso = $this->em->selectAll('consommation');
        $facture = new Facture();
        foreach ($arrConso as $consommation) {
            if (empty($this->em->selectById('facture', $consommation->getId()))) {
                $facture->setId($consommation->getId());
                $facture->setIdConsommation($consommation->getId());
                $numero = strtoupper(base_convert(rand(100000000, 999999999), 10, 36));
                $facture->setNumero(str_pad($consommation->getId(), 4, '0', STR_PAD_LEFT) . $numero);
                $tarif = $this->em->selectById('tarif', $consommation->getIdTarif());
                $montant = $consommation->getQuantiteChiffre() * $tarif->getPrixLitre();
                $facture->setMontant($montant);
                $facture->setDateFacturation($this->date);
                $time = strtotime($this->date);
                $dateLimit = date("Y-m-5", strtotime("+1 month", $time));
                $facture->setDateLimitePaiement($dateLimit);
                $this->em->replace($facture);
            }
        }
        $this->liste();
        $this->handleStatus('Factures générées pour toutes les consommations.');
    }

    public function payFacture() {
        /*$reglement = new Reglement();
        $reglement->setId($this->post->payFacture);
        $reglement->setIdFacture($this->post->payFacture);
        $reglement->setDatePaiement($this->date);
        $this->em->replace($reglement);*/
        $facture = $this->em->selectById('facture', $this->post->payFacture);
        $facture->setPaye(1);
        $facture->setDatePaiement($this->date);
        $this->em->update($facture);
        // Remettre le compteur en marche si coupé
        $conso = $this->em->selectById('consommation', $facture->getId()); 
        $compteur = $this->em->selectById('compteur', $conso->getIdCompteur()); 
        if($compteur->getIdEtatCompteur()!=1){
            $compteur->setIdEtatCompteur(1);
            $this->em->update($compteur);
        }
        $this->liste();
        $this->handleStatus('Paiement effectué avec succès.');
    }

    public function couperCompteur() {
        $arrFacture = $this->em->selectByAttr('facture', array('paye' => 0));
        $count = 0;
        $listeCompteur = '';
        if (!empty($arrFacture)) {
            foreach ($arrFacture as $key => $facture) {
                if ($this->date > $facture->getDateLimitePaiement()) {
                    $conso = $this->em->selectById('consommation', $facture->getId());
                    $compteur = $this->em->selectById('compteur', $conso->getIdCompteur());
                    $compteur->setIdEtatCompteur(2);
                    $this->em->update($compteur);
                    $count++;
                    if ($listeCompteur != '') {
                        $listeCompteur .= ', ';
                    }
                    $listeCompteur .= $compteur->getNumero();
                }
            }
        }
        $this->liste();
        if ($count) {
            $this->handleStatus('Compteur(s) ' . $listeCompteur . ' coupé(s). En tout ' . $count . ' compteur(s) coupé(s).');
        } else {
            $this->handleStatus('Aucun compteur à couper.');
        }
    }

}

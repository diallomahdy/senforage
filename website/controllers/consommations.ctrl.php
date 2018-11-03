<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Consommations extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité client => inclure le fichier /entities/Client.entity.php 
        $this->loadEntity('consommation');
        $this->loadEntity('compteur');
        $this->loadEntity('tarif');
        $this->loadEntity('facture');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        $arr = $this->em->selectAll('compteur');
        $optionsCompteur = '';
        foreach ($arr as $entity) {
            $optionsCompteur .= '<option value="' . $entity->getId() . '">' . $entity->getNumero() . '</option>';
        }
        $this->loadHtml($optionsCompteur, 'compteurs');
        if(isset($this->post->quantiteChiffre)){
            $consommation = new Consommation($this->post);
            $tarif = $this->em->selectAll('tarif')[0];
            $consommation->setIdTarif($tarif->getId());
            $this->em->save($consommation);
            // Incrémenter pointeur compteur
            $compteur = $this->em->selectById('compteur', $this->post->idCompteur);
            $compteur->setPointeur($compteur->getPointeur() + $this->post->quantiteChiffre);
            $this->em->update($compteur);
            $this->handleStatus('Consommation ajoutée avec succès.');
        }
    }
    
    // Charger la vue liste
    public function liste() {
        // Suppression
        if(isset($this->post->liste)){
            //$entity = new Consommation();
            $facture = new Facture();
            foreach ($this->post->liste as $id) {
                // Mettre à jour pointeur compteur
                $consommation = $this->em->selectById('consommation', $id);
                $compteur = $this->em->selectById('compteur', $consommation->getIdCompteur());
                $compteur->setPointeur($compteur->getPointeur() - $consommation->getQuantiteChiffre());
                $this->em->update($compteur);
                //$entity->setId($id);
                $facture->setId($id);
                $this->em->delete($facture);
                $this->em->delete($consommation);
            }
            $this->handleStatus('Consommation(s) ' . implode(',', $this->post->liste) . ' supprimée(s)');
        }
        // Générer facture
        if(isset($this->post->facture)){
            $facture = new Facture();
            foreach ($this->post->facture as $id) {
                $consommation = $this->em->selectById('consommation', $id);
                $facture->setId($id);
                $facture->setIdConsommation($id);
                $numero = strtoupper(base_convert(rand(100000000, 999999999), 10, 36));
                $facture->setNumero(str_pad($id, 4, '0', STR_PAD_LEFT) . $numero);
                $tarif = $this->em->selectById('tarif', $consommation->getIdTarif());
                $montant = $consommation->getQuantiteChiffre() * $tarif->getPrixLitre();
                $facture->setMontant($montant);
                $facture->setDateFacturation($this->date);
                $date = $consommation->getDate();
                $facture->setDateLimitePaiement($date);
                $this->em->replace($facture);
            }
            $this->handleStatus('Facture(s) générée(s) pour la/les consommation(s) ' . implode(',', $this->post->facture));
        }
        // Charger la vue liste
        $this->loadView('liste', 'content');
        // Lire les données à partir de la bd et formater
        $arr = $this->em->selectAll('compteur');
        $arrCompteur = $this->em->getRefined($arr);
        $liste = $this->em->selectAll('consommation');
        $html = '';
        foreach ($liste as $key => $entity) {
            $compteur = $arrCompteur[$entity->getIdCompteur()];
            $id = $entity->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            //$html .= '<td> <a href="abonnements/detail/' . $id . '" title="Détails">' . $entity->getNumero() . '</a> </td>';
            $html .= '<td>' . $entity->getQuantiteChiffre() . ' litres</td>';
            $html .= '<td><a href="compteurs/detail/' . $compteur->id . '">' . $compteur->numero . '</a></td>';
            $html .= '<td>' . Helper::getDate($entity->getDate()) . '</td>';
            $html .= '<td><a href="consommations/modifier/' . $id . '"> Modifier </a></td>';
            $html .= '<td><input type="checkbox" name="facture[]" value="' . $id . '"></td>';
            $html .= '<td><input type="checkbox" name="liste[]" value="' . $id . '"></td>';
            //$html .= '<td><form type="POST" action="compteurs/liste"><button type="submit" name="id" value="' . $id . '">Supprimer</button></form></td>';
            $html .= '</tr>';
        }
        // Ajouter les compteurs à la vue
        $this->loadHtml($html, 'list');
    }
    
    // Charger la vue detail
    public function detail() {
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('detail', 'content');
        $client = $this->em->selectById('client', $id);
        $village = $this->em->selectById('village', $client->getIdVillage());
        $this->loadHtml($client->getId(), 'id');
        $this->loadHtml($client->getNomFamille(), 'nomFamille');
        $this->loadHtml($village->getNom(), 'village');
        $this->loadHtml($client->getTelephone(), 'telephone');
        $this->dom->getElementById('lien_client')->href .= $id;
    }
    
    // Charger la vue modifier
    public function modifier() {
        if(isset($this->post->quantiteChiffre)){
            $quantiteEauNew = $this->post->quantiteChiffre;
            unset($this->post->quantiteChiffre);
            $consommation = new Consommation($this->post);
            $quantiteEauOld = $consommation->getQuantiteChiffre();
            $consommation->setQuantiteChiffre($quantiteEauNew);
            $this->em->update($consommation);
            // Mettre à jour pointeur compteur
            $compteur = $this->em->selectById('compteur', $consommation->getIdCompteur());
            $compteur->setPointeur($compteur->getPointeur() - $quantiteEauOld + $quantiteEauNew);
            $this->em->update($compteur);
            $this->handleStatus('Consommation modifiée avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $consommation = $this->em->selectById('consommation', $id); //var_dump($abonnement); exit;
        $this->dom->getElementById('id')->value = $consommation->getId();
        $this->dom->getElementById('quantiteChiffre')->value = $consommation->getQuantiteChiffre();
        $this->dom->getElementById('quantiteLettre')->value = $consommation->getQuantiteLettre();
        $this->dom->getElementById('date')->value = $consommation->getDate();
    }
    
}
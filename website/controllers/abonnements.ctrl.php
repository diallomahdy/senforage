<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Abonnements extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité client => inclure le fichier /entities/Client.entity.php 
        $this->loadEntity('abonnement');
        $this->loadEntity('client');
        $this->loadEntity('compteur');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        $arr = $this->em->selectAll('client');
        $optionsClient = '';
        foreach ($arr as $entity) {
            $optionsClient .= '<option value="' . $entity->getId() . '">' . $entity->getNomFamille() . '</option>';
        }
        $this->loadHtml($optionsClient, 'clients');
        $arr = $this->em->selectAll('compteur');
        $optionsCompteur = '';
        foreach ($arr as $entity) {
            $optionsCompteur .= '<option value="' . $entity->getId() . '">' . $entity->getNumero() . '</option>';
        }
        $this->loadHtml($optionsCompteur, 'compteurs');
        if(isset($this->post->numero)){
            $abonnement = new Abonnement($this->post);
            $this->em->save($abonnement);
            $this->handleStatus('Abonnement ajouté avec succès.');
        }
    }
    
    // Charger la vue liste
    public function liste() {
        if(isset($this->post->liste)){
            $entity = new Abonnement();
            foreach ($this->post->liste as $id) {
                $entity->setId($id);
                $this->em->delete($entity);
            }
            $this->handleStatus('Abonnement(s) ' . implode(',', $this->post->liste) . ' supprimé(s)');
        }
        // Charger la vue liste
        $this->loadView('liste', 'content');
        // Lire les données à partir de la bd et formater
        $arr = $this->em->selectAll('client');
        $arrClient = $this->em->getRefined($arr);
        $arr = $this->em->selectAll('compteur');
        $arrCompteur = $this->em->getRefined($arr);
        $liste = $this->em->selectAll('abonnement');
        $html = '';
        foreach ($liste as $key => $entity) {
            $client = $arrClient[$entity->getIdClient()];
            $compteur = $arrCompteur[$entity->getIdCompteur()];
            $id = $entity->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            //$html .= '<td> <a href="abonnements/detail/' . $id . '" title="Détails">' . $entity->getNumero() . '</a> </td>';
            $html .= '<td>' . $entity->getNumero() . '</td>';
            $html .= '<td><a href="clients/detail/' . $client->id . '">' . $client->nomFamille . '</a></td>';
            $html .= '<td><a href="compteurs/detail/' . $compteur->id . '">' . $compteur->numero . '</a></td>';
            $html .= '<td><a href="abonnements/modifier/' . $id . '"> Modifier </a></td>';
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
        if(isset($this->post->numero)){
            $abonnement = new Abonnement($this->post);
            $this->em->update($abonnement);
            $this->handleStatus('Abonnement modifié avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $abonnement = $this->em->selectById('abonnement', $id); //var_dump($abonnement); exit;
        $this->dom->getElementById('id')->value = $abonnement->getId();
        $this->dom->getElementById('numero')->value = $abonnement->getNumero();
        $this->dom->getElementById('date')->value = $abonnement->getDate();
        $this->dom->getElementById('description')->innertext = $abonnement->getDescription();
        
        
        $arrClient = $this->em->selectAll('client');
        $optionsClient = '';
        foreach ($arrClient as $entity) {
            if($entity->getId()==$abonnement->getIdClient()){
                $selected = 'selected';
            }
            else{
                $selected = '';
            }
            $optionsClient .= '<option value="' . $entity->getId() . '" ' . $selected . '>' . $entity->getNomFamille() . '</option>';
        }
        $this->loadHtml($optionsClient, 'clients');
        
        $arrCompteur = $this->em->selectAll('compteur');
        $optionsCompteur = '';
        foreach ($arrCompteur as $entity) {
            if($entity->getId()==$abonnement->getIdCompteur()){
                $selected = 'selected';
            }
            else{
                $selected = '';
            }
            $optionsCompteur .= '<option value="' . $entity->getId() . '" ' . $selected . '>' . $entity->getNumero() . '</option>';
        }
        $this->loadHtml($optionsCompteur, 'compteurs');
    }
    
}
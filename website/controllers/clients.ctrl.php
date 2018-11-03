<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Clients extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité client => inclure le fichier /entities/Client.entity.php 
        $this->loadEntity('client');
        $this->loadEntity('village');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        $arr = $this->em->selectAll('village');
        $options = '';
        foreach ($arr as $entity) {
            $options .= '<option value="' . $entity->getId() . '">' . $entity->getNom() . '</option>';
        }
        $this->loadHtml($options, 'idVillage');
        if(isset($this->post->nomFamille)){
            $this->loadEntity('chef');
            $chef = $this->em->selectByAttr('chef', 'idVillage', $this->post->idVillage)[0];
            $client = new Client($this->post);
            $client->setIdChef($chef->getId());
            $this->em->save($client);
            $this->handleStatus('Client ajouté avec succès.');
        }
    }
    
    // Charger la vue liste
    public function liste() {
        // Supprimer un compteur en cas d'envoie de formulaire
        if(isset($this->post->liste)){
            $client = new Client();
            foreach ($this->post->liste as $id) {
                $client->setId($id);
                $this->em->delete($client);
            }
            $this->handleStatus('Client(s) ' . implode(',', $this->post->liste) . ' supprimé(s)');
        }
        // Charger la vue liste
        $this->loadView('liste', 'content');
        // Lire les données à partir de la bd et formater
        $arr_villages = $this->em->selectAll('village');
        $arr_villages = $this->em->getRefined($arr_villages);
        $liste = $this->em->selectAll('client');
        $html = '';
        foreach ($liste as $key => $entity) {
            $village = $arr_villages[$entity->getIdVillage()];
            $id = $entity->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            $html .= '<td> <a href="clients/detail/' . $id . '" title="Détails">' . $entity->getNomFamille() . '</a> </td>';
            $html .= '<td>' . $entity->getTelephone() . '</td>';
            $html .= '<td><a href="villages/detail/' . $village->id . '">' . $village->nom . '</a></td>';
            $html .= '<td><a href="clients/modifier/' . $id . '"> Modifier </a></td>';
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
        if(isset($this->post->nomFamille)){
            $client = new Client($this->post);
            $this->em->update($client);
            $this->handleStatus('Client modifié avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $client = $this->em->selectById('client', $id);
        $this->dom->getElementById('id')->value = $client->getId();
        $this->dom->getElementById('nomFamille')->value = $client->getNomFamille();
        $this->dom->getElementById('telephone')->value = $client->getTelephone();
        $arr = $this->em->selectAll('village');
        $options = '';
        foreach ($arr as $entity) {
            if($entity->getId()==$client->getIdVillage()){
                $selected = 'selected';
            }
            else{
                $selected = '';
            }
            $options .= '<option value="' . $entity->getId() . '" ' . $selected . '>' . $entity->getNom() . '</option>';
        }
        $this->loadHtml($options, 'idVillage');
    }
    
}
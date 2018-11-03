<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tarification extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité village => inclure le fichier /entities/Village.entity.php 
        $this->loadEntity('tarif');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        if(isset($this->post->prixLitre)){
            $tarif = new Tarif($this->post);
            $this->em->save($tarif);
            $this->handleStatus('Tarif ajouté avec succès.');
        }
    }
    
    // Charger la vue lister
    public function liste() {
        // Ajouter tarif
        if(isset($this->post->prixLitre)){
            $tarif = new Tarif($this->post);
            $tarif->setDate($this->date);
            $this->em->save($tarif);
            $this->handleStatus('Tarif ajouté avec succès.');
        }
        // Charger la vue liste compteur
        $this->loadView('liste', 'content');
        // Lire les compteurs à partir de la bd et formater
        $liste = $this->em->selectAll('tarif');
        $html = '';
        foreach ($liste as $key => $entity) {
            $html .= '<tr>';
            $html .= '<td>' . $entity->getId() . '</td>';
            $html .= '<td>' . $entity->getPrixLitre() . 'FCFA/Litre</td>';
            $html .= '<td>' . Helper::getDate($entity->getDate()) . '</td>';
            $html .= '</tr>';
        }
        // Ajouter les compteurs à la vue
        $this->loadHtml($html, 'list');
    $this->dom->getElementById('prixLitre')->value = $liste[0]->getPrixLitre();
    }
    
    // Charger la vue detail
    public function detail() {
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('detail', 'content');
        $village = $this->em->selectById('village', $id);
        $this->loadHtml($village->getId(), 'id_village');
        $this->loadHtml($village->getNom(), 'nom_village');
        $this->dom->getElementById('lien_village')->href .= $id;
    }
    
    // Charger la vue modifier
    public function modifier() {
        if(isset($this->post->nom)){
            $village = new Village($this->post);
            $this->em->update($village);
            $this->handleStatus('Village modifié avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $village = $this->em->selectById('village', $id);
        $this->dom->getElementById('id')->value = $village->getId();
        $this->dom->getElementById('nom')->value = $village->getNom();
    }
    
}
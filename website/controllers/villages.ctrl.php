<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Villages extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité village => inclure le fichier /entities/Village.entity.php 
        $this->loadEntity('village');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        if(isset($this->post->nom)){
            $village = new Village($this->post);
            $this->em->save($village);
            $this->handleStatus('Village ajouté avec succès.');
        }
    }
    
    // Charger la vue lister
    public function liste() {
        // Supprimer un compteur en cas d'envoie de formulaire
        if(isset($this->post->liste)){
            $village = new Village();
            foreach ($this->post->liste as $id) {
                $village->setId($id);
                $this->em->delete($village);
            }
            $this->handleStatus('Village(s) ' . implode(',', $this->post->liste) . ' supprimé(s)');
        }
        // Charger la vue liste compteur
        $this->loadView('liste', 'content');
        // Lire les compteurs à partir de la bd et formater
        $liste = $this->em->selectAll('village');
        $html = '';
        foreach ($liste as $key => $entity) {
            $id = $entity->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            $html .= '<td> <a href="villages/detail/' . $id . '" title="Détails">' . $entity->getNom() . '</a> </td>';
            $html .= '<td><a href="villages/modifier/' . $id . '"> Modifier </a></td>';
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
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Compteurs extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité compteur => inclure le fichier /entities/Compteur.entity.php 
        $this->loadEntity('compteur');
        $this->loadEntity('etatCompteur');
    }
    
    // La méthode par défaut => Pour charger la vue par défaut
    public function index() {
        $this->liste();
    }
    
    // Charger la vue ajouter
    public function ajouter() {
        $this->loadView('ajouter', 'content');
        $arr = $this->em->selectAll('etatCompteur');
        $options = '';
        foreach ($arr as $entity) {
            $options .= '<option value="' . $entity->getId() . '">' . $entity->getLabel() . '</option>';
        }
        $this->loadHtml($options, 'etatCompteur');
        if(isset($this->post->numero)){
            $compteur = new Compteur($this->post);
            $this->em->save($compteur);
            $this->handleStatus('Compteur ajouté avec succès.');
        }
    }
    
    // Charger la vue lister
    public function liste() {
        // Supprimer un compteur en cas d'envoie de formulaire
        if(isset($this->post->liste)){
            //$url = explode('/', $_GET['url']);
            //$id = $url[2];
            $compteur = new Compteur();
            foreach ($this->post->liste as $id) {
                $compteur->setId($id);
                $this->em->delete($compteur);
            }
            $this->handleStatus('Compteur(s) ' . implode(',', $this->post->liste) . ' supprimé(s)');
        }
        // Charger la vue liste compteur
        $this->loadView('liste', 'content');
        // Lire les compteurs à partir de la bd et formater
        $etatCompteur = $this->em->selectAll('etatCompteur');
        $etatCompteur = $this->em->getRefined($etatCompteur);
        $liste_compteur = $this->em->selectAll('compteur');
        $html = '';
        foreach ($liste_compteur as $key => $compteur) {
            $id = $compteur->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            $html .= '<td> <a href="compteurs/detail/' . $id . '" title="Détails">' . $compteur->getNumero() . '</a> </td>';
            $html .= '<td>' . $compteur->getPointeur() . 'L</td>';
            $html .= '<td>' . $etatCompteur[$compteur->getIdEtatCompteur()]->label . '</td>';
            $html .= '<td><a href="compteurs/modifier/' . $id . '"> Modifier </a></td>';
            $html .= '<td><input type="checkbox" name="liste[]" value="' . $id . '"></td>';
            //$html .= '<td><form type="POST" action="compteurs/liste"><button type="submit" name="id" value="' . $id . '">Supprimer</button></form></td>';
            $html .= '</tr>';
        }
        // Ajouter les compteurs à la vue
        $this->loadHtml($html, 'list_compteur');
    }
    
    // Charger la vue detail
    public function detail() {
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('detail', 'content');
        $compteur = $this->em->selectById('compteur', $id);
        $etatCompteur = $this->em->selectAll('etatCompteur');
        $etatCompteur = $this->em->getRefined($etatCompteur);
        $this->loadHtml($compteur->getId(), 'id_compteur');
        $this->loadHtml($compteur->getNumero(), 'num_compteur');
        $this->loadHtml($compteur->getPointeur() . 'L', 'pointeur');
        $this->loadHtml($etatCompteur[$compteur->getIdEtatCompteur()]->label, 'etatCompteur');
        $this->dom->getElementById('lien_compteur')->href .= $id;
    }
    
    // Charger la vue modifier
    public function modifier() {
        if(isset($this->post->numero)){
            $compteur = new Compteur($this->post);
            $this->em->update($compteur);
            $this->handleStatus('Compteur modifié avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $arr = $this->em->selectAll('etatCompteur');
        $options = '';
        foreach ($arr as $entity) {
            $options .= '<option value="' . $entity->getId() . '">' . $entity->getLabel() . '</option>';
        }
        $this->loadHtml($options, 'etatCompteur');
        $compteur = $this->em->selectById('compteur', $id);
        $this->dom->getElementById('id')->value = $compteur->getId();
        $this->dom->getElementById('numero')->value = $compteur->getNumero();
        $this->dom->getElementById('etatCompteur')->value = $compteur->getIdEtatCompteur();
        $this->dom->getElementById('pointeur')->value = $compteur->getPointeur();
    }
    
}


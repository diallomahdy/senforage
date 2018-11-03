<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Chefs extends Controller{
    
    // Constructeur
    public function __construct() {
        // Appel du constructeur parent
        parent::__construct();
        // Charger l'entité chef => inclure le fichier /entities/chef.entity.php 
        $this->loadEntity('chef');
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
        if(isset($this->post->prenom)){
            $chef = new chef($this->post);
            $this->em->save($chef);
            $this->handleStatus('Chef de village ajouté avec succès.');
        }
    }
    
    // Charger la vue liste
    public function liste() {
        // Supprimer un compteur en cas d'envoie de formulaire
        if(isset($this->post->liste)){
            $chef = new chef();
            foreach ($this->post->liste as $id) {
                $chef->setId($id);
                $this->em->delete($chef);
            }
            $this->handleStatus('Chef(s) de village ' . implode(',', $this->post->liste) . ' supprimé(s)');
        }
        // Charger la vue liste
        $this->loadView('liste', 'content');
        // Lire les données à partir de la bd et formater
        $arr_villages = $this->em->selectAll('village');
        $arr_villages = $this->em->getRefined($arr_villages);
        $liste = $this->em->selectAll('chef');
        $html = '';
        foreach ($liste as $key => $entity) {
            $village = $arr_villages[$entity->getIdVillage()];
            $id = $entity->getId();
            $html .= '<tr>';
            $html .= '<td>' . $id . '</td>';
            $html .= '<td> <a href="chefs/detail/' . $id . '" title="Détails">' . $entity->getPrenom() . '</a> </td>';
            $html .= '<td>' . $entity->getNom() . '</td>';
            $html .= '<td><a href="villages/detail/' . $village->id . '">' . $village->nom . '</a></td>';
            $html .= '<td><a href="chefs/modifier/' . $id . '"> Modifier </a></td>';
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
        $chef = $this->em->selectById('chef', $id);
        $village = $this->em->selectById('village', $chef->getIdVillage());
        $this->loadHtml($chef->getId(), 'id');
        $this->loadHtml($chef->getNom(), 'nom');
        $this->loadHtml($chef->getPrenom(), 'prenom');
        $this->loadHtml($village->getNom(), 'village');
        $this->loadHtml($chef->getTelephone(), 'telephone');
        $this->dom->getElementById('lien_chef')->href .= $id;
    }
    
    // Charger la vue modifier
    public function modifier() {
        if(isset($this->post->prenom)){
            $chef = new chef($this->post);
            $this->em->update($chef);
            $this->handleStatus('Chef de village modifié avec succès.');
        }
        $url = explode('/', $_GET['url']);
        $id = $url[2];
        $this->loadView('modifier', 'content');
        $chef = $this->em->selectById('chef', $id);
        $this->dom->getElementById('id')->value = $chef->getId();
        $this->dom->getElementById('nom')->value = $chef->getNom();
        $this->dom->getElementById('prenom')->value = $chef->getPrenom();
        $this->dom->getElementById('telephone')->value = $chef->getTelephone();
        $arr = $this->em->selectAll('village');
        $options = '';
        foreach ($arr as $entity) {
            if($entity->getId()==$chef->getIdVillage()){
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
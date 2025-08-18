<?php
/**
 * Controlador Base
 * Analítica Soluções - Sistema MVC
 */

namespace App\Controllers;

class HomeController extends BaseController {
    
    /**
     * Página inicial
     */
    public function index() {
        //$this->render('pages/home');
        $this->render('layouts/main');
    }
    
    /**
     * Seção Soluções
     */
    public function solucoes() {
        $this->render('pages/home', [
            'focusSection' => 'solucoes',
            'scrollTo' => 'solucoes'
        ]);
    }
    
    /**
     * Seção Sobre
     */
    public function sobre() {
        $this->render('pages/home', [
            'focusSection' => 'sobre',
            'scrollTo' => 'sobre'
        ]);
    }
    
    /**
     * Seção Avaliações
     */
    public function avaliacoes() {
        $this->render('pages/home', [
            'focusSection' => 'avaliacoes',
            'scrollTo' => 'avaliacoes'
        ]);
    }
    
    /**
     * Seção Portfólio
     */
    public function portifolio() {
        $this->render('pages/home', [
            'focusSection' => 'portifolio',
            'scrollTo' => 'portifolio'
        ]);
    }
    
    /**
     * Seção Contato
     */
    public function contato() {
        $csrfToken = $this->generateCSRF();
        
        $this->render('pages/home', [
            'focusSection' => 'contato',
            'scrollTo' => 'contato',
            'csrfToken' => $csrfToken
        ]);
    }
}
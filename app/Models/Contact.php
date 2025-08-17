<?php
/**
 * Modelo de Contato
 * Analítica Soluções - Sistema MVC
 */

namespace App\Models;

use App\Models\BaseModel;
use Exception;

class Contact extends BaseModel {
    protected $table = 'contacts';
    
    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
        'ip',
        'user_agent',
        'created_at'
    ];
    
    /**
     * Validar dados do contato
     */
    public function validate() {
        $errors = [];
        
        // Validar nome
        if (empty($this->nome) || strlen($this->nome) < 2) {
            $errors['nome'] = 'Nome deve ter pelo menos 2 caracteres';
        }
        
        // Validar email
        if (empty($this->email)) {
            $errors['email'] = 'Email é obrigatório';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email deve ser válido';
        }
        
        // Validar mensagem
        if (empty($this->mensagem) || strlen($this->mensagem) < 10) {
            $errors['mensagem'] = 'Mensagem deve ter pelo menos 10 caracteres';
        }
        
        return $errors;
    }
    
    /**
     * Aplicar sanitização antes de salvar
     */
    protected function beforeSave() {
        $this->data['nome'] = $this->sanitize($this->nome);
        $this->data['email'] = strtolower(trim($this->email));
        $this->data['assunto'] = $this->sanitize($this->assunto);
        $this->data['mensagem'] = $this->sanitize($this->mensagem);
        
        // Adicionar timestamp se não existir
        if (empty($this->created_at)) {
            $this->data['created_at'] = date('Y-m-d H:i:s');
        }
    }
    
    /**
     * Salvar contato
     */
    public function save($data = null) {
        if ($data) {
            $this->fill($data);
        }
        
        // Validar antes de salvar
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new Exception('Dados inválidos: ' . implode(', ', $errors));
        }
        
        // Aplicar sanitização
        $this->beforeSave();
        
        // Salvar no log
        return parent::save();
    }
    
    /**
     * Obter estatísticas de contatos
     */
    public static function getStats() {
        $logFile = STORAGE_PATH . '/logs/contacts.log';
        
        if (!file_exists($logFile)) {
            return [
                'total' => 0,
                'today' => 0,
                'this_month' => 0
            ];
        }
        
        $contacts = file($logFile, FILE_IGNORE_NEW_LINES);
        $total = count($contacts);
        
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        
        $todayCount = 0;
        $monthCount = 0;
        
        foreach ($contacts as $line) {
            if (strpos($line, $today) === 0) {
                $todayCount++;
            }
            if (strpos($line, $thisMonth) === 0) {
                $monthCount++;
            }
        }
        
        return [
            'total' => $total,
            'today' => $todayCount,
            'this_month' => $monthCount
        ];
    }
    
    /**
     * Obter contatos recentes
     */
    public static function getRecent($limit = 10) {
        $logFile = STORAGE_PATH . '/logs/contacts.log';
        
        if (!file_exists($logFile)) {
            return [];
        }
        
        $contacts = file($logFile, FILE_IGNORE_NEW_LINES);
        $contacts = array_reverse($contacts); // Mais recentes primeiro
        
        $recent = [];
        $count = 0;
        
        foreach ($contacts as $line) {
            if ($count >= $limit) break;
            
            $parts = explode(' | ', $line, 2);
            if (count($parts) === 2) {
                $data = json_decode($parts[1], true);
                if ($data) {
                    $data['logged_at'] = $parts[0];
                    $recent[] = $data;
                    $count++;
                }
            }
        }
        
        return $recent;
    }
    
    /**
     * Limpar logs antigos (manutenção)
     */
    public static function cleanOldLogs($days = 365) {
        $logFile = STORAGE_PATH . '/logs/contacts.log';
        
        if (!file_exists($logFile)) {
            return;
        }
        
        $contacts = file($logFile, FILE_IGNORE_NEW_LINES);
        $cutoffDate = date('Y-m-d', strtotime("-{$days} days"));
        
        $filteredContacts = [];
        
        foreach ($contacts as $line) {
            $parts = explode(' | ', $line, 2);
            if (count($parts) === 2 && $parts[0] >= $cutoffDate) {
                $filteredContacts[] = $line;
            }
        }
        
        file_put_contents($logFile, implode(PHP_EOL, $filteredContacts) . PHP_EOL);
    }
}
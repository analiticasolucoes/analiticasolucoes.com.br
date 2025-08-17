<?php
/**
 * Modelo Base
 * Analítica Soluções - Sistema MVC
 */

namespace App\Models;

abstract class BaseModel {
    protected $data = [];
    protected $fillable = [];
    protected $table = '';
    
    /**
     * Preencher modelo com dados
     */
    public function fill($data) {
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->data[$key] = $value;
            }
        }
        
        return $this;
    }
    
    /**
     * Obter atributo do modelo
     */
    public function __get($key) {
        return $this->data[$key] ?? null;
    }
    
    /**
     * Definir atributo do modelo
     */
    public function __set($key, $value) {
        if (in_array($key, $this->fillable)) {
            $this->data[$key] = $value;
        }
    }
    
    /**
     * Verificar se atributo existe
     */
    public function __isset($key) {
        return isset($this->data[$key]);
    }
    
    /**
     * Obter todos os dados
     */
    public function toArray() {
        return $this->data;
    }
    
    /**
     * Converter para JSON
     */
    public function toJson() {
        return json_encode($this->data);
    }
    
    /**
     * Salvar dados (implementação base para logs)
     */
    public function save($data = null) {
        if ($data) {
            $this->fill($data);
        }
        
        return $this->writeToLog();
    }
    
    /**
     * Escrever dados no log
     */
    protected function writeToLog() {
        if (empty($this->table)) {
            return false;
        }
        
        $logDir = STORAGE_PATH . '/logs/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logFile = $logDir . $this->table . '.log';
        $logEntry = date('Y-m-d H:i:s') . ' | ' . $this->toJson() . PHP_EOL;
        
        return file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX) !== false;
    }
    
    /**
     * Validar dados do modelo
     */
    public function validate() {
        return [];
    }
    
    /**
     * Sanitizar dados
     */
    protected function sanitize($value) {
        if (is_array($value)) {
            return array_map([$this, 'sanitize'], $value);
        }
        
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Aplicar mutators antes de salvar
     */
    protected function beforeSave() {
        // Override em modelos filhos se necessário
    }
    
    /**
     * Aplicar accessors ao recuperar dados
     */
    protected function afterLoad() {
        // Override em modelos filhos se necessário
    }
}
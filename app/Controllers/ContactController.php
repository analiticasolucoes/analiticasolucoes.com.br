<?php
/**
 * Controlador de Contato
 * Analítica Soluções - Sistema MVC
 */

namespace App\Controllers;

use App\Core\Router;
use App\Core\View;
use Exception;
use App\Models\Contact;

class ContactController extends BaseController {
    
    /**
     * Processar formulário de contato
     */
    public function store() {
        try {
            // Verificar honeypot (campo oculto para prevenir spam)
            if (!empty($_POST['emails'])) {
                $this->redirect('/?status=success');
                return;
            }
            
            // Sanitizar dados
            $data = $this->sanitize($_POST);
            
            // Validar dados
            $errors = $this->validate($data, [
                'nome' => 'required|min:3',
                'email' => 'required|email',
                'mensagem' => 'required|min:3'
            ]);
            
            if (!empty($errors)) {
                $errorMessage = implode(', ', $errors);
                $this->redirect('/?status=error&message=' . urlencode($errorMessage));
                return;
            }
            
            // Criar modelo de contato
            $contact = new Contact();
            
            // Preparar dados do contato
            $contactData = [
                'nome' => $data['nome'],
                'email' => $data['email'],
                'assunto' => $data['assunto'] ?? 'Contato via site',
                'mensagem' => $data['mensagem'],
                'ip' => $this->getClientIP(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Salvar contato no log
            $contact->save($contactData);
            
            // Enviar email
            $emailSent = $this->sendContactEmail($contactData);
            
            if ($emailSent) {
                writeLog("Contato enviado com sucesso: {$contactData['nome']} ({$contactData['email']})", 'contact');
                $this->redirect('/?status=success');
            } else {
                writeLog("Falha ao enviar email de contato: {$contactData['nome']} ({$contactData['email']})", 'contact');
                $this->redirect('/?status=error&message=' . urlencode('Erro ao enviar mensagem. Tente novamente.'));
            }
            
        } catch (Exception $e) {
            writeLog("Erro no ContactController::store: " . $e->getMessage(), 'error');
            $this->redirect('/?status=error&message=' . urlencode('Ocorreu um erro interno. Tente novamente.'));
        }
    }
    
    /**
     * Enviar email de contato
     */
    private function sendContactEmail($data) {
        $subject = '[Site] ' . $data['assunto'];
        
        $message = "
Novo contato recebido pelo site:

Nome: {$data['nome']}
Email: {$data['email']}
Assunto: {$data['assunto']}

Mensagem:
{$data['mensagem']}

---
Informações técnicas:
IP: {$data['ip']}
User Agent: {$data['user_agent']}
Data/Hora: {$data['created_at']}
        ";
        
        $headers = [
            'Reply-To: ' . $data['email']
        ];
        
        return sendMail(CONTACT_EMAIL, $subject, $message, $headers);
    }
    
    /**
     * API endpoint para validação de email (AJAX)
     */
    public function validateEmail() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Método não permitido'], 405);
            return;
        }
        
        $email = $_POST['email'] ?? '';
        
        if (empty($email)) {
            $this->jsonResponse(['valid' => false, 'message' => 'Email é obrigatório']);
            return;
        }
        
        if (!isValidEmail($email)) {
            $this->jsonResponse(['valid' => false, 'message' => 'Email inválido']);
            return;
        }
        
        $this->jsonResponse(['valid' => true]);
    }
}
<form class="formulario" action="<?= url('/contato') ?>" method="post" id="contactForm">
    <input name="nome" type="text" class="form-control formulario-contato" id="nome" placeholder="Nome" required value="<?= old('nome') ?>">
    <input name="email" type="email" class="form-control formulario-contato" id="email" placeholder="E-mail" required value="<?= old('email') ?>">
    <input name="assunto" type="text" class="form-control formulario-contato" id="assunto" placeholder="Assunto" value="<?= old('assunto') ?>">
    <textarea name="mensagem" rows="7" class="form-control formulario-contato" id="mensagem" placeholder="Mensagem" required><?= old('mensagem') ?></textarea>
    <input name="submit" type="submit" class="btn btn-primary btn-lg text-center mx-auto d-block formulario-contato" id="submit" value="Enviar">
    
    <!-- Honeypot para prevenção de spam -->
    <span style="display:none;visibility:hidden;">  
        <label for="emails">
        Este campo é apenas para prevenção de spammers. Por favor, não altere seu conteudo ou sua mensagem não será enviada!
        </label>  
        <input type="text" name="emails" size="1" value="" />
    </span>
    
    <!-- Token CSRF se disponível -->
    <?php if (isset($csrfToken)): ?>
    <input type="hidden" name="_token" value="<?= $csrfToken ?>">
    <?php endif; ?>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submit');
    
    // Validação em tempo real
    const emailField = document.getElementById('email');
    emailField.addEventListener('blur', function() {
        const email = this.value;
        if (email && !isValidEmail(email)) {
            this.classList.add('is-invalid');
            showFieldError(this, 'Email inválido');
        } else {
            this.classList.remove('is-invalid');
            hideFieldError(this);
        }
    });
    
    // Validação antes do envio
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            return false;
        }
        
        // Desabilitar botão para evitar duplo envio
        submitBtn.disabled = true;
        submitBtn.value = 'Enviando...';
    });
    
    function validateForm() {
        let isValid = true;
        const fields = ['nome', 'email', 'mensagem'];
        
        fields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                showFieldError(field, `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} é obrigatório`);
                isValid = false;
            } else {
                hideFieldError(field);
            }
        });
        
        const email = document.getElementById('email');
        if (email.value && !isValidEmail(email.value)) {
            showFieldError(email, 'Email inválido');
            isValid = false;
        }
        
        return isValid;
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function showFieldError(field, message) {
        field.classList.add('is-invalid');
        
        // Remover erro anterior se existir
        hideFieldError(field);
        
        // Adicionar mensagem de erro
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
    }
    
    function hideFieldError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
});
</script>
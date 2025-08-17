<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Erro interno do servidor - <?= APP_NAME ?></title>
    <meta name="description" content="Ocorreu um erro interno no servidor. Nossa equipe foi notificada e está trabalhando para resolver o problema.">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="<?= asset('img/ico/favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="<?= asset('css/estilo.css') ?>" rel="stylesheet">
    
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
        }
        .error-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .error-content h1 {
            font-size: 8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #ffd700, #ff4757);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .error-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }
        .error-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .error-icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            color: #ffd700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .suggestions {
            text-align: left;
            max-width: 500px;
            margin: 2rem auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 15px;
        }
        .suggestions h3 {
            color: #fff;
            margin-bottom: 1rem;
            text-align: center;
        }
        .suggestions ul {
            list-style: none;
            padding: 0;
        }
        .suggestions li {
            padding: 0.8rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .suggestions li:last-child {
            border-bottom: none;
        }
        .suggestions a {
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 8px;
        }
        .suggestions a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
        }
        .suggestions a i {
            font-size: 1.5rem;
            width: 30px;
            text-align: center;
        }
        .btn-custom {
            background: linear-gradient(45deg, #ffd700, #ff4757);
            border: none;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .btn-outline-custom {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-2px);
        }
        .error-details {
            background: rgba(0, 0, 0, 0.2);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 2rem 0;
            border-left: 4px solid #ffd700;
        }
        .error-details h4 {
            color: #ffd700;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .error-details p {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }
        @media (max-width: 768px) {
            .error-content h1 { font-size: 5rem; }
            .error-content h2 { font-size: 2rem; }
            .error-content p { font-size: 1.1rem; }
            .error-content { padding: 2rem; }
            .error-icon { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-content">
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h1>500</h1>
            <h2>Erro interno do servidor</h2>
            <p>Oops! Algo deu errado em nossos servidores. Nosso time técnico já foi notificado.</p>
            
            <div class="error-details">
                <h4><i class="bi bi-info-circle-fill"></i> O que aconteceu?</h4>
                <p>• Ocorreu um erro inesperado durante o processamento da sua solicitação</p>
                <p>• Nossa equipe técnica foi automaticamente notificada</p>
                <p>• Estamos trabalhando para resolver o problema o mais rápido possível</p>
            </div>
            
            <div class="suggestions">
                <h3>O que você pode fazer:</h3>
                <ul>
                    <li>
                        <a href="javascript:location.reload()">
                            <i class="bi bi-arrow-clockwise"></i>
                            <span>Tentar novamente</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/') ?>">
                            <i class="bi bi-house-fill"></i>
                            <span>Voltar para a página inicial</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/solucoes') ?>">
                            <i class="bi bi-gear-fill"></i>
                            <span>Conhecer nossas soluções</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/contato') ?>">
                            <i class="bi bi-envelope-fill"></i>
                            <span>Reportar o problema</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mt-4">
                <a href="<?= url('/') ?>" class="btn btn-custom btn-lg me-3">
                    <i class="bi bi-arrow-left"></i>
                    Voltar ao Início
                </a>
                <a href="<?= url('/contato') ?>" class="btn btn-outline-custom btn-lg">
                    <i class="bi bi-bug"></i>
                    Reportar Erro
                </a>
            </div>
            
            <div class="mt-4">
                <small style="opacity: 0.7;">
                    ID do Erro: <?= isset($errorId) ? e($errorId) : uniqid() ?> | 
                    Horário: <?= date('d/m/Y H:i:s') ?>
                </small>
            </div>
            
            <div class="mt-2">
                <small style="opacity: 0.7;">
                    Se o problema persistir, 
                    <a href="<?= url('/contato') ?>" style="color: #ffd700; text-decoration: underline;">entre em contato conosco</a> 
                    informando o ID do erro acima.
                </small>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
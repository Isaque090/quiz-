<?php
session_start();

if (!isset($_SESSION['pergunta_atual'])) {
    $_SESSION['pergunta_atual'] = 0;
}


if (!isset($_SESSION['certas'])) {
    $_SESSION['certas'] = 0;
}



//echo $nome;

$perguntas = [
    0 => [
        'pergunta' => ' Qual tag HTML cria um parágrafo?',
        'opcoes' => ['<div>', '<br>', '<p>', '<h1>'],
        'correta' => 2
    ],
    1 => [
        'pergunta' => 'Qual linguagem é usada principalmente para estilizar páginas web?',
        'opcoes' => ['PHP', 'JavaScript', 'CSS', 'Python'],
        'correta' => 2
    ],

    2 => [
        'pergunta' => 'O que significa a sigla HTML?',
        'opcoes' => ['Hyper Text Markup Language', 'High Tech Machine Learning', 'Hyper Transfer Markup Link', 'Home Tool Markup Language'],
        'correta' => 0
    ],

    3 => [
        'pergunta' => 'Qual símbolo é usado para iniciar uma variável em PHP?',
        'opcoes' => ['@', '$', '#', '%'],
        'correta' => 1
    ],

    4 => [
        'pergunta' => 'Qual tag HTML é usada para criar um link?',
        'opcoes' => ['<link>', '<a>', '<href>', '<url>'],
        'correta' => 1
    ],

    5 => [
        'pergunta' => 'Qual é o operador de igualdade estrita em PHP?',
        'opcoes' => ['==', '=', '===', '!=='],
        'correta' => 2
    ],

    6 => [
        'pergunta' => 'Qual tag HTML define o título da página na aba do navegador?',
        'opcoes' => ['<title>', '<head>', '<meta>', '<header>'],
        'correta' => 0
    ],

    7 => [
        'pergunta' => 'Qual função do PHP é usada para exibir conteúdo na tela?',
        'opcoes' => ['print()', 'echo', 'write()', 'display()'],
        'correta' => 1
    ],

    8 => [
        'pergunta' => 'Qual atributo HTML é usado para definir o texto alternativo de uma imagem?',
        'opcoes' => ['title', 'alt', 'src', 'description'],
        'correta' => 1
    ],

    9 => [
        'pergunta' => 'Qual é o método HTTP usado para enviar dados de formulário de forma segura?',
        'opcoes' => ['GET', 'POST', 'PUT', 'DELETE'],
        'correta' => 1
    ],

    10 => [
        'pergunta' => 'Qual tag HTML cria uma lista não ordenada?',
        'opcoes' => ['<ol>', '<ul>', '<li>', '<list>'],
        'correta' => 1
    ],
];


if ($_SESSION['pergunta_atual'] >= count($perguntas)) {

    $nome = $_SESSION['nome'];
    $pontos = $_SESSION['certas']*10 ;

    include_once('config.php');
    $stmt = $conexao->prepare("UPDATE Melhores SET pontuacao= ? WHERE nm_nome = ?");
$stmt->bind_param("is",  $pontos,$nome);  
$stmt->execute();
    echo "<h2 style='color: green;'> " . $_SESSION['certas'] . "Quiz finalizado! Você respondeu todas as " . count($perguntas) . " perguntas.</h2>";
    $p = "";

    
session_destroy();

    exit;
}
$conta = $_SESSION['pergunta_atual'];
$p = $perguntas[$conta];


if (isset($_POST['escolha'])) {

    $a = $_POST['escolha'];
    echo $a;
    if ($a == $p['correta']) {
        echo 'certo';
        $_SESSION['certas'] += 1;

    }
    $_SESSION['pergunta_atual']++;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;

}


$p = $perguntas[$_SESSION['pergunta_atual']];

?><!DOCTYPE html>
<html lang="pt-br">
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Simples</title>
    <style>
        body {

            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .todo {
            width: 100% !important;
            max-width: 650px !important;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            font-size: 30px;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        p {
            font-size: 22px;
            margin-bottom: 30px;

        }

        .botao {
            display: block;
            width: 100%;
            margin: 12px 0;
            padding: 14px;
            font-size: 19px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .botao:hover {
            background-color: #2980b9;
        }

        .botao:active {
            background-color: #1f6391;
        }


        @media (max-width: 500px) {
            .todo {
                padding: 20px;
            }

            h2 {
                font-size: 1.4rem;
            }

            p {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>

    <div class="card todo">


        <h2>Questão</h2>
        <p><?= htmlspecialchars($p['pergunta']) ?></p>

        <form method="post" action="">
            <?php foreach ($p['opcoes'] as $indice => $texto): ?>
                <button type="submit" class="botao" value="<?= $indice ?>" name="escolha">
                    <?= ($indice + 1) ?>     <?= htmlspecialchars($texto) ?>
                </button>
            <?php endforeach; ?>
        </form>
    </div>

</body>

</html>
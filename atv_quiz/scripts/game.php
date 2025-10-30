<?php
session_start(); // necessário antes de usar $_SESSION

// Verifica se foi enviada uma resposta via GET
if (isset($_GET['answer'])) {

    $current_question = $_SESSION['game']['current_question'];
    $answer = (int)$_GET['answer'];
    $answer_given = $_SESSION['questions'][$current_question]['answers'][$answer];

    // Usa a chave correta 'correct_answer' definida no start.php
    if ($answer_given == $_SESSION['questions'][$current_question]['correct_answer']) {
        $_SESSION['game']['correct_answers']++;
    } else {
        $_SESSION['game']['incorrect_answers']++;
    }

    // Se for a última questão, vai para o fim do jogo
    if ($_SESSION['game']['current_question'] == $_SESSION['game']['total_questions'] - 1) {
        header('Location: index.php?route=gameover');
        exit;
    }

    $_SESSION['game']['current_question']++;

    header('Location: index.php?route=game');
    exit;
}

// Inicializa as variáveis da sessão
$current_question = $_SESSION['game']['current_question'];
$total_questions = $_SESSION['game']['total_questions'];
$correct_answers = $_SESSION['game']['correct_answers'];
$incorrect_answers = $_SESSION['game']['incorrect_answers'];

$country = $_SESSION['questions'][$current_question]['question'];
$answers = $_SESSION['questions'][$current_question]['answers'];
global $capitals;
?>

<!-- HTML para exibição da questão -->
<div class="container">
    <h1>Quiz Wicked</h1>

    <h5>Questão n.º <strong><?= $current_question + 1 . ' / ' . $total_questions ?></strong></h5>

    <div>
        <h4>Corretas: <strong><?= $correct_answers ?></strong>
        Erradas: <strong><?= $incorrect_answers ?></strong></h4>
    </div>

    <hr>
    <h4>Qual é a resposta correta: <strong><?= $country ?></strong></h4>
    <hr>

    <div>
        <h3 style="cursor: pointer" id="answer_0"><?= $capitals[$answers[0]][1] ?></h3>
        <h3 style="cursor: pointer" id="answer_1"><?= $capitals[$answers[1]][1] ?></h3>
        <h3 style="cursor: pointer" id="answer_2"><?= $capitals[$answers[2]][1] ?></h3>
    </div>

    <div>
        <a href="index.php?route=start">Desistir</a>
    </div>
</div>

<!-- Script JavaScript para capturar a resposta clicada -->
<script>
    document.querySelectorAll("[id^='answer_']").forEach(element => {
        element.addEventListener('click', () => {
            let id = element.id.split('_')[1];
            window.location.href = `index.php?route=game&answer=${id}`;
        });
    });
</script>

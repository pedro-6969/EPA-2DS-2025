<!--   
            Página de regsitro principal (Não mudará para o ticket digital.)
Somente será disponível para os organizadores.
-->

<?php 
include 'footer.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <div class="mb-3">
        <div class="row">
            <h1 class="roboto-title text-center">Registro</h1>
        </div>
        
        <!-- Formulário de registro -->
        
        <form action="registro-main.php" class="roboto-regular" method="post">
            <label for="pNome" class="label-control">Nome:</label>
            <input type="text" name="pNome" id="pNome" class="form-control" maxlength="50" required autocomplete="off">
            <br>
            <input type="submit" value="Enviar" class="btn btn-primary" onclick="limpar()">
        </form>
    </div>
    <div class="mb-3" id="exibirID"></div>
    </body>
</html>

<?php
    /* 
    Verifica se as variáveis existem
    Caso não existam o código para de rodar
    */

    $pNome = isset($_POST['pNome']) ? $_POST['pNome'] : exit();

    // Coloca os valores das variáveis dentro da tabela e colunas especificadas

    $stmt = $pdo->prepare('INSERT INTO infoParticipante (pNome) VALUES (:pNome)');

    // Limpagem de qualquer conteúdo malicios.
    $stmt->bindParam(':pNome', $pNome);
    $stmt->execute();

    // Pega o ID do participante inserido

    $ultimopId = $pdo->lastInsertId();
    
    // Insere o registro correspondente na tabela inforanking com valores padrão

    $stmtRanking = $pdo->prepare('INSERT INTO inforanking (rIdParticipante, rPontuacaoFinal) VALUES (:rIdParticipante, 0)');
    $stmtRanking->execute([':rIdParticipante' => $ultimopId]);
?>
    <!--
                Exibe o ID do usuario
        Pedir ao usuario para anotar esse valor
    -->
<div class="mb-3" id="exibirID">
    <?php if (isset($ultimopId)); { ?>
        <p class="roboto-regular text-center">
            Seu ID é:<strong><?php echo $ultimopId;?></strong>
            <br>
            Por favor, anote isso em seu ticket.
        </p>
        <?php } ?>
<?php 
include 'connection.php';
include 'footer.php';
include 'header.php';

    /*
    Buscagem de informações da tabela "infoParticipante" e de "infoRanking".
    Depois da buscagem eles se "Juntam" para formar uma unica "Tabela".
    Com isso realiza-se uma "ordem" para determinar os lideres.
    Essa ordem é baseado em Pontos e Tempo gastado.
    Cujo pontos levam a maior prioridade e tempo vem em segundo.
    */

    $stmt = $pdo->query('SELECT * FROM infoparticipante INNER JOIN inforanking ON infoparticipante.pId = inforanking.rIdParticipante ORDER BY rPontuacaoFinal DESC, TIMESTAMPDIFF(SECOND, rTempoInicial, rTempoFinal) ASC');
$rankingParticipantes = $stmt->fetchAll();


$posicao_atual = 0;
?>
<div class="d-flex flex-column justify-content-around father-container align-items-center">

    <h1 class="text-center creepster-regular">Ranking Geral</h1>

    <input type="text" name="buscar" id="input-search" class="input-search">
    <br>

    <div class="text-center roboto-regular container-fluid d-flex flex-column leaderboard-container">
    
        <?php 
            foreach ($rankingParticipantes as $index => $participante) { 
                
                // Convertendo os timestamps para objetos DateTime.
                $tempoInicial = new DateTime($participante['rTempoInicial']);
                $tempoFinal = new DateTime($participante['rTempoFinal']);
            
                // Calculando a diferença entre as duas datas.
                $diferenca = $tempoFinal->diff($tempoInicial);
        
            /*
            Formata o resultado a partir to "DateInterval::Format".
            Que seria o "Quanto tempo foi gastado".
            */
            $diferencaformatada = $diferenca->format('%d %H-%i-%s');
            
            ?>
        <p class="roboto-regular display-ranking">
                
                <?php
                    $posicao_atual++;
                    if($posicao_atual == 1){
                        echo '<img src="ouro">';
                        
                    }
                    
                    if($posicao_atual == 2){
                        echo '<img src="prata">';
                    }
                    
                    if($posicao_atual == 3){
                        echo '<img src="bronze">';
                    }
                    if ($posicao_atual >= 4) {
                        echo $posicao_atual;
                        
                        
                    }
                    ?>

                <img src="bolinha-preta">
                Nome: <strong><?php echo $participante['pNome']; ?></strong>
                Tempo: <strong><?php echo $diferencaformatada; ?></strong> 
                Pontuação: <strong><?php echo $participante['rPontuacaoFinal']; ?></strong>
            
            
            <!--
                                                                        Formatação: Dia Hora-Minutos-Segunods
                                                                        Por que? O projeto tem uma duração de 2 dias.
                                                                        Seria obsoluto adicionar mês e ano e poderia causar confusão ao adicionar "YYYY MM".
                                                                        Por curiosidade o formato timestamp é:
                                                                                YYYY-MM-DD HH-II-SS
                                                                                Onde que II = Minutos
                                                                        -->
        </p>
        <br>
        <?php } ?>

    </div>
</div>

    <!-- Exibindo informações da tabela criada a partir do INNER JOIN -->

<?php
  require_once "functions.php" ;
  session_start();
  $matricula = $_SESSION['matricula'];
?>

<script src="./js/jquery-3.4.1.min.js"></script>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Arial', sans-serif;
      background-color: #f5f5f5;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .container {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .numero-caixa {
      width: 100px;
      height: 50px;
      background-color: blue;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 18px;
      margin: 20px auto;
    }

    h2, p {
      margin: 0;
      color: #333;
    }

    h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<!-- INICIO Exibição do número aleatório na tela -->
<div class="container">
  <h2>VERIFICAÇÃO Nº 2</h2>
  <div class="numero-caixa">
    <?php
// Gera um número aleatorio para ser armazenado no banco de dados
      $numeroAleatorio = rand(1000, 9999);

// Atualiza o banco de dados com o número aleatorio
      $query = "UPDATE autenticacao SET senha_informada = '$numeroAleatorio', status = 'processando' WHERE matricula = '$matricula'";
      $executar = mysqli_query($connect, $query);
      echo $numeroAleatorio;
      //$exec = shell_exec("./exeroot './autentica.sh '".$matricula); //Chama um script para gerar a chamada automatica
    ?>
  </div>
   <p>Aguarde o contato telefônico e informe os números acima.</p>      
      
        
<p><div id="timer">1:00</div></p>

<!-- FIM Exibição do número aleatório na tela -->

<!--INICIO Bloco gerador da chamada -->  
<?php
$ArquivoCall = "autentica-$matricula.call";

//Geracao de arquivo.call chamando a AGI autenticacao.call
$frase = "Channel: SIP/$matricula
CallerID: 'Chamada de Autenticação' <777>
MaxRetries: 0
RetryTime: 300
WaitTime: 45
Application: AGI
Data: autenticacao.agi,$matricula
Archive: yes";

// Tenta abrir o arquivo para escrita (se não existir, ele será criado)
$arquivo = fopen("/var/spool/asterisk/outgoing/$ArquivoCall", 'w');

if ($arquivo) {
    // Escreve a frase no arquivo
    fwrite($arquivo, $frase);

    // Fecha o arquivo
    fclose($arquivo);
}
?>
<!--FIM Bloco gerador da chamada --> 

<!--INICIO timer exibido na pagina -->
<script>
    // Definir o tempo inicial em segundos
    var tempoRestante = 60;

    // Função para atualizar o timer
    function atualizarTimer() {
        var minutos = Math.floor(tempoRestante / 60);
        var segundos = tempoRestante % 60;

        // Adicionar um zero à esquerda se os segundos forem menores que 10
        segundos = segundos < 10 ? "0" + segundos : segundos;

        // Atualizar o conteúdo do elemento com id "timer"
        document.getElementById("timer").innerHTML = minutos + ":" + segundos;

        // Verificar se o tempo acabou
        if (tempoRestante === 0) {
            // Redirecionar para a página desejada após um minuto
            window.location.href = "./index.php";
        } else {
            // Decrementar o tempo restante
            tempoRestante--;
        }
    }

    // Chamar a função de atualização a cada segundo
    setInterval(atualizarTimer, 1000);
</script>
<!--FIM timer exibido na pagina -->


</div>

<!--INICIO script que chama o comparador de numeros -->
<script>
function verificarStatus() {
    $.ajax({
        url: 'verificar_status.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Verifica o status retornado
            if (response.status === 'aprovado') {
                // Se aprovado, redirecione para user-panel.php
                window.location.href = './user_panel.php';
            } if (response.status === 'reprovado') {
              // Se aprovado, redirecione para user-panel.php
              window.location.href = './index.php';
            
            }else {
                // Se não aprovado, continue verificando após um intervalo de tempo
                setTimeout(verificarStatus, 5000); // Verificar a cada 5 segundos (ajuste conforme necessário)
            }
        },
        error: function() {
            console.error('Erro ao verificar o status do usuário.');
            // Manipule o erro conforme necessário
        }
    });
}

verificarStatus(); // Inicie a verificação imediatamente
</script>

<!--FIM script que chama o comparador de numeros -->

</body>

</html>

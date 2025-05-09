<?php

include 'verificar_sessao.php'; // Inclui a verificação
verificarSessao(); // Verifica se o usuário está autenticado

include 'conexao.php'; // Conexão com o banco de dados
// Consulta para contar os alunos
$sql = "SELECT COUNT(*) as total FROM alunos";
$result = $conexao->query($sql);
$totalAlunos = 0;

if ($result && $row = $result->fetch_assoc()) {
    $totalAlunos = $row['total'];
}

$sqlInativos = "SELECT COUNT(*) as total FROM alunos WHERE estado = 'inativo'";
$resultInativos = $conexao->query($sqlInativos);
$totalInativos = 0;
if ($resultInativos && $row = $resultInativos->fetch_assoc()) {
    $totalInativos = $row['total'];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .painel-container {
          display: flex;
          flex-wrap: wrap;
          gap: 20px;
          padding: 20px;
        }

        /* Coluna da esquerda */
        .left-column {
          flex: 1;
          min-width: 300px;
          max-width: 50%;
          display: flex;
          flex-direction: column;
          gap: 15px;
        }

        /* Coluna da direita */
        .right-column {
          flex: 1;
          min-width: 300px;
          max-width: 50%;
          display: flex;
          flex-direction: column;
          gap: 15px;
        }

        /* Estilo dos cards */
        .painel-card {
          display: block;
          background-color: #f8f9fa;
          padding: 20px;
          border-left: 6px solid #3AD770;
          border-radius: 8px;
          text-decoration: none;
          color: #333;
          transition: 0.3s;
        }

        .painel-card:hover {
          background-color: #e9ffe6;
        }

        /* Estilo das info-boxes */
        .info-box {
          background-color: #ffffff;
          border: 2px solid #3AD770;
          border-radius: 8px;
          padding: 20px;
          font-size: 16px;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .custom-logout {
          color: #dc3545; /* vermelho */
          border: 1px solid transparent;
          padding: 5px 10px;
          border-radius: 4px;
          transition: all 0.3s ease;
        }

        .custom-logout:hover {
          border: 1px solid #dc3545;
          background-color: transparent;
          color: #dc3545;
        }

    </style>
</head>
<body>
<!-- Menu Hambúrguer -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand"><img src="logo_Unitech.png" alt="Logo da escola" class="navbar-logo"></a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Início</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cadastro_aluno.php">Cadastrar Alunos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="listar_alunos.php">Matrículas</a>
      </li>
    </ul>

    <ul class="navbar-nav ms-auto me-3"> <!-- me-3 afasta da borda direita -->
  <li class="nav-item">
    <a class="nav-link logout-btn text-danger" href="logout.php">Sair</a>
  </li>
    </ul>
  </div>
</nav>

<?php

// Mensagem de boas vindas ao usuario
$usuario = isset($_SESSION['email']) ? $_SESSION['email'] : 'Usuário';
?>

<div id="mensagemBoasVindas" class="alert alert-success text-center" role="alert">
  Bem-vindo ao sistema da Unitech, <strong><?= htmlspecialchars($usuario) ?></strong>!
</div>

<br><br>

  <h2 class="text-center">Painel Principal</h2>
<div class="painel-container">
  <!-- Coluna da esquerda com os cards -->
  <div class="left-column">
    <a href="cadastro_aluno.php" class="painel-card">
      <h3>Cadastrar Aluno</h3>
    </a>
    <a href="cursos_turmas.php" class="painel-card">
      <h3>Gerenciar Cursos e Turmas</h3>
    </a>
    <a href="gerenciar_alunos.php" class="painel-card">
      <h3>Listar Alunos</h3>
    </a>
  </div>

  <!-- Coluna da direita com as infos -->
  <div class="right-column">
    <div class="info-box">
      <strong>Alunos cadastrados:</strong> <?php echo $totalAlunos; ?>
    </div>
    <div class="info-box">
      <strong>Alunos formados:</strong> <?php echo $totalInativos; ?>
    </div>
  </div>
</div>

  <script>
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"

  // Esconde a mensagem após 7 segundos (7000 ms)
setTimeout(function() {
  const mensagem = document.getElementById('mensagemBoasVindas');
  if (mensagem) {
    mensagem.style.display = 'none';
  }
}, 7000);
  </script>
</body>
</html>
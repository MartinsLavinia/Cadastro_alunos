<?php
include 'verificar_sessao.php'; // Inclui a verificação
verificarSessao(); // Verifica se o usuário está autenticado

include 'conexao.php'; // Conexão com o banco de dados

// Verifica se a matrícula foi passada pela URL
if (!isset($_GET['matricula'])) {
    die("Matrícula do aluno não informada.");
}

$matricula = $_GET['matricula'];

// Verifica se a matrícula foi corretamente passada
var_dump($_GET); // Depuração

// Consulta para buscar os dados completos do aluno usando a matrícula
$sql = "SELECT * FROM alunos WHERE matricula = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $matricula); // 's' para string, já que a matrícula é uma string
$stmt->execute();
$result = $stmt->get_result();
$aluno = $result->fetch_assoc();

if (!$aluno) {
    die("Aluno não encontrado.");
}

// Lógica de edição
if (isset($_POST['editar'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];

    $updateSql = "UPDATE alunos SET nome = ?, cpf = ?, rg = ? WHERE matricula = ?";
    $updateStmt = $conexao->prepare($updateSql);
    $updateStmt->bind_param("ssss", $nome, $cpf, $rg, $matricula);

    if ($updateStmt->execute()) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados: " . $conexao->error;
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css"  rel="stylesheet">
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
          <a class="nav-link active" aria-current="page" href="index.php">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cadastro_aluno.php">Cadastrar Alunos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="listar_alunos.php">Matriculas</a>
        </li>
      </ul>
    </div>
  </nav>
  
    <div class="container my-4">
        <h2 class="text-center">Editar Dados do Aluno</h2>

        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo isset($aluno['nome']) ? $aluno['nome'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo isset($aluno['cpf']) ? $aluno['cpf'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="rg" class="form-label">RG</label>
                        <input type="text" name="rg" id="rg" class="form-control" value="<?php echo isset($aluno['rg']) ? $aluno['rg'] : ''; ?>" required>
            </div>
            <button type="submit" name="editar" class="btn btn-primary">Atualizar</button>
        </form>

        <form method="POST" class="mb-4">
            <button type="submit" name="excluir" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este aluno?')">Excluir</button>
        </form>

        <button onclick="window.print()" class="btn btn-secondary">Imprimir</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

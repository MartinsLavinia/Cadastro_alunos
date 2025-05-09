<?php
include 'conexao.php';


if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $sql = "SELECT * FROM alunos WHERE matricula = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $aluno = $resultado->fetch_assoc();

    if (!$aluno) {
        echo "Aluno não encontrado.";
        exit;
    }
} else {
    echo "Matrícula não fornecida.";
    exit;
}


$mensagem = '';
$alunoData = null;

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $stmt = $conexao->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alunoData = $result->fetch_assoc();
    } else {
        $mensagem = "❌ Matrícula não encontrada.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula'];
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['nascimento'];
    $sexo = $_POST['sexo'];
    $responsavel = $_POST['responsavel'];
    $estado_aluno = $_POST['estado'];
    $curso = $_POST['curso'];
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $nometurma = $_POST['turma'];
    $tipo_ensino = $_POST['tipo_ensino'];
    $periodo = $_POST['periodo'];

    $stmt = $conexao->prepare("
        UPDATE alunos SET 
            nome = ?, rg = ?, cpf = ?, data_nascimento = ?, sexo = ?, 
            responsavel = ?, estado = ?, curso = ?, 
            inicio = ?, termino = ?, turma = ?, tipo_ensino = ?, periodo = ?
        WHERE matricula = ?
    ");
    $stmt->bind_param(
        "sssssssssssssi",
        $nome, $rg, $cpf, $data_nascimento, $sexo, $responsavel, $estado_aluno,
        $curso, $inicio, $termino, $nometurma, $tipo_ensino, $periodo,
        $matricula
    );

    if ($stmt->execute()) {
        $mensagem = "✅ Dados do aluno atualizados com sucesso!";
    } else {
        $mensagem = "❌ Erro ao atualizar os dados do aluno.";
    }

    $stmt = $conexao->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $alunoData = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h2>Editar Aluno</h2>
  <form action="atualizar_aluno.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="matricula" value="<?php echo $aluno['matricula']; ?>">

    <label for="nome">Nome completo:</label>
    <input type="text" name="nome" id="nome" class="form-control" value="<?php echo $aluno['nome']; ?>" required>

    <label for="rg">RG:</label>
    <input type="text" name="rg" id="rg" class="form-control" value="<?php echo $aluno['rg']; ?>" required>

    <label for="cpf">CPF:</label>
    <input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $aluno['cpf']; ?>" required>

    <label for="data_nascimento">Data de nascimento:</label>
    <input type="date" name="data_nascimento" id="data_nascimento" class="form-control" value="<?php echo $aluno['data_nascimento']; ?>" required>

    <label for="sexo">Sexo:</label>
    <select name="sexo" id="sexo" class="form-control">
        <option value="Masculino" <?php if($aluno['sexo'] == 'Masculino') echo 'selected'; ?>>Masculino</option>
        <option value="Feminino" <?php if($aluno['sexo'] == 'Feminino') echo 'selected'; ?>>Feminino</option>
    </select>

    <label for="responsavel">Responsável:</label>
    <input type="text" name="responsavel" id="responsavel" class="form-control" value="<?php echo $aluno['responsavel']; ?>" required>

    <label for="estado">Estado:</label>
    <input type="text" name="estado" id="estado" class="form-control" value="<?php echo $aluno['estado']; ?>" required>

    <label for="foto">Alterar Foto (opcional):</label>
    <input type="file" name="foto" id="foto" class="form-control">

    <button type="submit" class="btn btn-success mt-3">Salvar Alterações</button>
  </form>
</div>

</body>
</html>

<?php
include 'conexao.php';

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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>✏️ Editar Dados do Aluno</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($mensagem)): ?>
                        <div class="alert <?= strpos($mensagem, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
                            <?= $mensagem ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($alunoData): ?>
                        <form method="POST">
                            <input type="hidden" name="matricula" value="<?= htmlspecialchars($alunoData['matricula']) ?>">

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Nome:</label>
                                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($alunoData['nome']) ?>" required>
                                </div>
                                <div class="col">
                                    <label>RG:</label>
                                    <input type="text" name="rg" class="form-control" value="<?= htmlspecialchars($alunoData['rg']) ?>" required>
                                </div>
                                <div class="col">
                                    <label>CPF:</label>
                                    <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($alunoData['cpf']) ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Data de Nascimento:</label>
                                    <input type="date" name="nascimento" class="form-control" value="<?= htmlspecialchars($alunoData['data_nascimento']) ?>" required>
                                </div>
                                <div class="col">
                                    <label>Sexo:</label>
                                    <select name="sexo" class="form-control" required>
                                        <option value="M" <?= $alunoData['sexo'] === 'M' ? 'selected' : '' ?>>Masculino</option>
                                        <option value="F" <?= $alunoData['sexo'] === 'F' ? 'selected' : '' ?>>Feminino</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Responsável:</label>
                                    <input type="text" name="responsavel" class="form-control" value="<?= htmlspecialchars($alunoData['responsavel']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Estado:</label>
                                    <input type="text" name="estado" class="form-control" value="<?= htmlspecialchars($alunoData['estado']) ?>">
                                </div>
                                <div class="col">
                                    <label>Curso:</label>
                                    <input type="text" name="curso" class="form-control" value="<?= htmlspecialchars($alunoData['curso']) ?>">
                                </div>
                                <div class="col">
                                    <label>Tipo de Ensino:</label>
                                    <input type="text" name="tipo_ensino" class="form-control" value="<?= htmlspecialchars($alunoData['tipo_ensino']) ?>">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label>Início:</label>
                                    <input type="date" name="inicio" class="form-control" value="<?= htmlspecialchars($alunoData['inicio']) ?>">
                                </div>
                                <div class="col">
                                    <label>Término:</label>
                                    <input type="date" name="termino" class="form-control" value="<?= htmlspecialchars($alunoData['termino']) ?>">
                                </div>
                                <div class="col">
                                    <label>Turma:</label>
                                    <input type="text" name="turma" class="form-control" value="<?= htmlspecialchars($alunoData['turma']) ?>">
                                </div>
                            </div>

                            <div class="mb-3 text-end">
                                <button type="submit" class="btn btn-success">💾 Salvar Alterações</button>
                            </div>
                        </form>
                        <a href="consulta.php" class="btn btn-secondary">🔙 Voltar para Consulta</a>
                    <?php else: ?>
                        <div class="alert alert-warning">⚠️ Nenhum aluno selecionado para edição.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

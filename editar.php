<?php
include 'conexao.php';

$mensagem = '';
$osData = null;

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $stmt = $connection->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $osData = $result->fetch_assoc();
    } else {
        $mensagem = "❌ Matricula não encontrada.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar os dados do formulário
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['nascimento'];
    $sexo = $_POST['sexo'];
    $responsavel = $_POST['responsavel'];
    $estado_aluno = $_POST['estado'];
    $foto_perfil = $_FILES['foto']['name'] ?? null;
    $matricula = $_POST['matricula'];
    $curso = $_POST['curso'];
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $nometurma = $_POST['turma'];
    $tipo_ensino = $_POST['tipo_ensino'];
    $periodo = $_POST['periodo'];

    // Atualiza os dados do aluno
    $stmt = $connection->prepare("
        UPDATE alunos 
        SET nome = ?, rg = ?, cpf = ?, data_nascimento = ?, sexo = ?, 
         responsavel = ?, estado = ?, matricula = ?, curso = ?, 
            inicio = ?, termino = ?, turma = ?, tipo_ensino = ?, periodo = ?
        WHERE matricula = ?
    ");
    $stmt->bind_param(
        "sssssssissssss",
        $nome, $rg, $cpf, $data_nascimento, $sexo, $responsavel, $estado_aluno,
        $matricula, $curso, $inicio, $termino, $nometurma, $tipo_ensino, $periodo,
    );

    if ($stmt->execute()) {
        $mensagem = "✅ Dados do aluno atualizados com sucesso!";
    } else {
        $mensagem = "❌ Erro ao atualizar os dados do aluno.";
    }

    // Recarrega os dados atualizados
    $stmt = $connection->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmt->bind_param("i", $matricula);
    $stmt->execute();
    $alunoData = $stmt->get_result()->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Alterar Ordem de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>✏️ Editar Ordem de Serviço</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($mensagem)): ?>
                        <div class="alert <?= strpos($mensagem, '✅') !== false ? 'alert-success' : 'alert-danger' ?>">
                            <?= $mensagem ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($osData): ?>
                        <form method="POST">
                            <input type="hidden" name="numero_os" value="<?= htmlspecialchars($osData['NumeroOS']) ?>">

                            <div class="mb-3">
                                <label class="form-label">Número da OS:</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($osData['NumeroOS']) ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Data:</label>
                                <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($osData['Data']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Equipamento:</label>
                                <input type="text" name="equipamento" class="form-control" value="<?= htmlspecialchars($osData['Equipamento']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Defeito:</label>
                                <input type="text" name="defeito" class="form-control" value="<?= htmlspecialchars($osData['Defeito']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Serviço:</label>
                                <input type="text" name="servico" class="form-control" value="<?= htmlspecialchars($osData['Servico']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Valor Total (R$):</label>
                                <input type="number" class="form-control" value="<?= htmlspecialchars($osData['ValorTotal']) ?>" readonly>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
                            </div>
                        </form>
                        <div class="card-body">
    <a href="consulta.php" class="btn btn-secondary mb-3">🔙 Voltar para Consulta</a>
    </div>
                    <?php elseif (!$mensagem): ?>
                        <div class="alert alert-warning">⚠️ Nenhuma Ordem de Serviço foi selecionada.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

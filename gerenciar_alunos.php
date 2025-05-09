<?php
include 'verificar_sessao.php'; // Inclui a verificação
verificarSessao(); // Verifica se o usuário está autenticado

include 'conexao.php';

// Excluir aluno e seus dados de matrícula
if (isset($_GET['excluir_id'])) {
    $matricula = intval($_GET['excluir_id']);
    
    // Exclui primeiro da tabela relacionada (dados_matricula)
    $conexao->query("DELETE FROM dados_matricula WHERE matricula = $matricula");
    // Depois da tabela principal
    $conexao->query("DELETE FROM alunos WHERE matricula = $matricula");

    header("Location: gerenciar_alunos.php");
    exit;
}

// Atualizar registro
if (isset($_POST['atualizar'])) {
    $matricula = intval($_POST['matricula']);
    $nome = $_POST['nome'];
    $RG = $_POST['RG'];
    $CPF = $_POST['CPF'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo = $_POST['sexo'];
    $responsavel = $_POST['responsavel'];
    $estado = $_POST['estado'];
    $turma_id = $_POST['turma_id'];
    $inicio = $_POST['inicio'];
    $termino = $_POST['termino'];
    $curso_id = $_POST['curso_id'];

    // Atualiza alunos
    $stmt1 = $conexao->prepare("UPDATE alunos SET nome=?, RG=?, CPF=?, data_nascimento=?, sexo=?, responsavel=?, estado=? WHERE matricula=?");
    $stmt1->bind_param("sssssssi", $nome, $RG, $CPF, $data_nascimento, $sexo, $responsavel, $estado, $matricula);
    $stmt1->execute();

    // Atualiza dados_matricula
    $stmt2 = $conexao->prepare("UPDATE dados_matricula SET turma_id=?, inicio=?, termino=?, curso_id=? WHERE matricula=?");
    $stmt2->bind_param("issii", $turma_id, $inicio, $termino, $curso_id, $matricula);
    $stmt2->execute();

    header("Location: gerenciar_alunos.php");
    exit;
}

// Buscar todos os alunos com suas matrículas
$sql = "SELECT a.*, d.turma_id, d.inicio, d.termino, d.curso_id 
        FROM alunos a 
        LEFT JOIN dados_matricula d ON a.matricula = d.matricula";

if (isset($_GET['busca_id']) && is_numeric($_GET['busca_id'])) {
    $busca_id = intval($_GET['busca_id']);
    $sql .= " WHERE a.matricula = $busca_id";
}

$resultado = $conexao->query($sql);

// Buscar aluno específico para edição
$aluno_editar = null;
if (isset($_GET['editar_id'])) {
    $id_editar = intval($_GET['editar_id']);
    $res = $conexao->query("SELECT a.*, d.turma_id, d.inicio, d.termino, d.curso_id 
                            FROM alunos a 
                            LEFT JOIN dados_matricula d ON a.matricula = d.matricula 
                            WHERE a.matricula = $id_editar");
    $aluno_editar = $res->fetch_assoc();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Alunos</title>
    <link href="editar.css" rel="stylesheet">
</head>
<body>
    <div class="tabela-container">
    <h2>Alunos Cadastrados</h2>

    <!-- Formulário de pesquisa por matrícula -->
    <div class="pesquisa-container">
        <form method="get">
            <input type="number" name="busca_id" placeholder="Buscar por matrícula (ID)" value="<?= isset($_GET['busca_id']) ? $_GET['busca_id'] : '' ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>

    <table>
        <tr>
            <th>Matrícula</th>
            <th>Nome</th>
            <th>RG</th>
            <th>CPF</th>
            <th>Curso</th>
            <th>Turma</th>
            <th>Início</th>
            <th>Término</th>
            <th>Estado</th>
            <th>Ações</th>
        </tr>
        <?php while ($linha = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($linha['matricula']) ?></td>
                <td><?= htmlspecialchars($linha['nome']) ?></td>
                <td><?= htmlspecialchars($linha['RG']) ?></td>
                <td><?= htmlspecialchars($linha['CPF']) ?></td>
                <td><?= htmlspecialchars($linha['curso_id']) ?></td>
                <td><?= htmlspecialchars($linha['turma_id']) ?></td>
                <td><?= htmlspecialchars($linha['inicio']) ?></td>
                <td><?= htmlspecialchars($linha['termino']) ?></td>
                <td><?= htmlspecialchars($linha['estado']) ?></td>
                <td>
                    <div class="acoes">
                        <form method="get" action="gerenciar_alunos.php">
                            <input type="hidden" name="editar_id" value="<?= $linha['matricula'] ?>">
                            <button type="submit" class="btn-alterar">Alterar</button>
                        </form>
                        <form method="get" action="gerenciar_alunos.php" onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                            <input type="hidden" name="excluir_id" value="<?= $linha['matricula'] ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="botoes">
        <button onclick="exportarCSV()" class="btn-exportar">Exportar CSV</button>
        <button onclick="window.location.href='index.php'">Voltar pro Home</button>
    </div>

    <script>
        function exportarCSV() {
            const linhas = document.querySelectorAll("table tr");
            let csv = [];

            linhas.forEach(linha => {
                let dados = [];
                linha.querySelectorAll("th, td").forEach(celula => {
                    dados.push('"' + celula.innerText.replace(/"/g, '""') + '"');
                });
                csv.push(dados.join(","));
            });

            let blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
            let link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "dados_alunos.csv";
            link.click();
        }
    </script>

    <?php if ($aluno_editar): ?>
        <h2>Editar Aluno</h2>
        <form class="editar-form" method="post" action="gerenciar_alunos.php">
            <input type="hidden" name="matricula" value="<?= $aluno_editar['matricula'] ?>">
            <label>Nome: <input type="text" name="nome" value="<?= htmlspecialchars($aluno_editar['nome']) ?>"></label><br>
            <label>RG: <input type="text" name="RG" value="<?= htmlspecialchars($aluno_editar['RG']) ?>"></label><br>
            <label>CPF: <input type="text" name="CPF" value="<?= htmlspecialchars($aluno_editar['CPF']) ?>"></label><br>
            <label>Data de Nascimento: <input type="date" name="data_nascimento" value="<?= htmlspecialchars($aluno_editar['data_nascimento']) ?>"></label><br>
            <label>Sexo: <input type="text" name="sexo" value="<?= htmlspecialchars($aluno_editar['sexo']) ?>"></label><br>
            <label>Responsável: <input type="text" name="responsavel" value="<?= htmlspecialchars($aluno_editar['responsavel']) ?>"></label><br>
            <label>Estado: <input type="text" name="estado" value="<?= htmlspecialchars($aluno_editar['estado']) ?>"></label><br>
            <label>Turma: <input type="text" name="turma_id" value="<?= htmlspecialchars($aluno_editar['turma_id']) ?>"></label><br>
            <label>Curso: <input type="text" name="curso_id" value="<?= htmlspecialchars($aluno_editar['curso_id']) ?>"></label><br>
            <label>Início: <input type="date" name="inicio" value="<?= htmlspecialchars($aluno_editar['inicio']) ?>"></label><br>
            <label>Término: <input type="date" name="termino" value="<?= htmlspecialchars($aluno_editar['termino']) ?>"></label><br>
            <button type="submit" name="atualizar">Salvar Alterações</button>
        </form>
    <?php endif; ?>
</div>


</body>
</html>
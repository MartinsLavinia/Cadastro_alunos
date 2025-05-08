<?php
include('conexao.php');

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['formulario'] == 'turma') {
        // Cadastro de turma
        $nome = $_POST['nome_turma'];
        $tipo_ensino = $_POST['tipo_ensino'];
        $periodo = $_POST['periodo'];
        $curso_id = !empty($_POST['curso_id']) ? $_POST['curso_id'] : NULL;

        $stmt = $conexao->prepare("INSERT INTO turmas (nome, tipo_ensino, periodo, curso_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nome, $tipo_ensino, $periodo, $curso_id);

        if ($stmt->execute()) {
            $mensagem = "Turma cadastrada com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar turma: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($_POST['formulario'] == 'curso') {
        // Cadastro de curso
        $nome = $_POST['nome_curso'];
        $carga = $_POST['carga_horaria'];
        $descricao = $_POST['descricao'];

        $stmt = $conexao->prepare("INSERT INTO cursos (nome, carga_horaria, descricao) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nome, $carga, $descricao);

        if ($stmt->execute()) {
            $mensagem = "Curso cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar curso: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Buscar cursos para o select do formulário de turmas
$cursos = [];
$result = $conexao->query("SELECT id, nome FROM cursos");
while ($row = $result->fetch_assoc()) {
    $cursos[] = $row;
}
$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f0f2f5;
  margin: 0;
  padding: 30px 0;
}

form {
  margin-bottom: 20px;
}

label {
  display: block;
  margin: 12px 0 6px;
  font-weight: 600;
  color: #333;
}

input, select {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  background-color: #fff;
  transition: border-color 0.3s;
}

input:focus, select:focus {
  border-color: #4CAF50;
  outline: none;
  box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
}

button {
  padding: 12px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

button:hover {
  background-color: #45a049;
  transform: translateY(-2px);
}

.main-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 30px;
  padding: 30px;
  flex-wrap: wrap; /* Para evitar que estourem em telas menores */
}

.form-box {
  width: 480px;
  background-color: #ffffff;
  padding: 30px 40px;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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

<?php if (!empty($mensagem)) echo "<p><strong>$mensagem</strong></p>"; ?>

<!-- Formulário de Turmas -->
<div class="main-container">
  <div class="form-box">
      <h2>Cadastrar Turma</h2>
      <form method="post">
          <input type="hidden" name="formulario" value="turma">

          <label for="nome_turma">Nome da Turma:</label>
          <input type="text" id="nome_turma" name="nome_turma" required>

          <label for="tipo_ensino">Tipo de Ensino:</label>
          <select id="tipo_ensino" name="tipo_ensino" required>
              <option value="">Selecione</option>
              <option value="Fundamental">Fundamental</option>
              <option value="Médio">Médio</option>
              <option value="Curso">Curso</option>
          </select>

          <label for="periodo">Período:</label>
          <select id="periodo" name="periodo" required>
              <option value="">Selecione</option>
              <option value="Manhã">Manhã</option>
              <option value="Tarde">Tarde</option>
              <option value="Noite">Noite</option>
          </select>

          <label for="curso_id">Curso (caso seja um curso):</label>
          <select id="curso_id" name="curso_id">
              <option value="">Nenhum</option>
              <?php foreach ($cursos as $curso): ?>
                  <option value="<?= $curso['id'] ?>"><?= $curso['nome'] ?></option>
              <?php endforeach; ?>
          </select>

          <button type="submit">Cadastrar Turma</button>
      </form>
  </div>

  <!-- Formulário de Cursos -->
  <div class="form-box">
    <h2>Cadastrar Curso</h2>
    <form method="post">
        <input type="hidden" name="formulario" value="curso">

        <label for="nome_curso">Nome do Curso:</label>
        <input type="text" id="nome_curso" name="nome_curso" required>

        <label for="carga_horaria">Carga Horária:</label>
        <input type="number" id="carga_horaria" name="carga_horaria" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <button type="submit">Cadastrar Curso</button>
    </form>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

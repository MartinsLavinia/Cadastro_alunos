<?php
include('conexao.php');

// Inserção se formulário enviado
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $tipo_ensino = $_POST['tipo_ensino'];
    $periodo = $_POST['periodo'];
    $curso_id = !empty($_POST['curso_id']) ? $_POST['curso_id'] : NULL;

    $stmt = $conexao->prepare("INSERT INTO turmas (nome, tipo_ensino, periodo, curso_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $tipo_ensino, $periodo, $curso_id);

    if ($stmt->execute()) {
        $mensagem = "Turma cadastrada com sucesso!";
    } else {
        $mensagem = "Erro: " . $stmt->error;
    }

    $stmt->close();
}

// Buscar cursos para o select
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
    <div class="form-box">
        <h2>Cadastrar Turma</h2>
        <?php if (!empty($mensagem)) echo "<p>$mensagem</p>"; ?>
        <form method="post">
            <label for="nome">Nome da Turma:</label>
            <input type="text" id="nome" name="nome" required>

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

            <button type="submit">Cadastrar Turma</button>
        </form>
    </div>
</body>
</html>

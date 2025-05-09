<?php
include 'verificar_sessao.php'; // Inclui a verificação
verificarSessao(); // Verifica se o usuário está autenticado

// Incluir a conexão com o banco
include('conexao.php');

function gerarMatricula() {
  // Gerar número aleatório de 6 dígitos
  $matricula = rand(100000, 999999);
  return $matricula;
}


// Função para verificar se a matrícula já existe
function matriculaExiste($matricula, $conexao) {
  $sql = "SELECT COUNT(*) FROM alunos WHERE matricula = ?";
  $stmt = $conexao->prepare($sql);
  $stmt->bind_param("i", $matricula);
  $stmt->execute();
  $stmt->bind_result($count);
  $stmt->fetch();
  return $count > 0; // Retorna true se a matrícula já existir
}

// Gerar uma matrícula única
do {
  $matricula = gerarMatricula();
} while (matriculaExiste($matricula, $conexao)); // Continua gerando enquanto já existir

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = $_POST['nome'];
  $cpf = $_POST['cpf'];
  $rg = $_POST['rg'];
  $nascimento = $_POST['nascimento'];
  $sexo = $_POST['sexo'];
  $responsavel = $_POST['responsavel'];
  $estado = $_POST['estado'];
  $foto_url = '';


// Verifica se já existe aluno com o mesmo CPF ou RG
$verifica = $conexao->prepare("SELECT * FROM alunos WHERE cpf = ? OR rg = ?");
$verifica->bind_param("ss", $cpf, $rg);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {
    echo "<script>alert('CPF ou RG já cadastrado!'); window.history.back();</script>";
    exit; // Interrompe o cadastro
}

  // Upload da foto
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
      $foto_nome = $_FILES['foto']['name'];
      $foto_temp = $_FILES['foto']['tmp_name'];
      $foto_ext = pathinfo($foto_nome, PATHINFO_EXTENSION);
      $foto_url = 'uploads/' . uniqid() . '.' . $foto_ext;
      move_uploaded_file($foto_temp, $foto_url);
  }

  // Inserir na tabela alunos
  $sqlAluno = "INSERT INTO alunos (matricula, nome, cpf, rg, foto_url, data_nascimento, sexo, responsavel, estado)
               VALUES ('$matricula', '$nome', '$cpf', '$rg', '$foto_url', '$nascimento', '$sexo', '$responsavel', '$estado')";
  
  if ($conexao->query($sqlAluno) === TRUE) {
      // Dados para a tabela dados_matricula
      $curso_id = isset($_POST['curso_id']) && $_POST['curso_id'] !== '' ? intval($_POST['curso_id']) : "NULL";
      $turma_id = isset($_POST['turma_id']) ? $_POST['turma_id'] : null;
      $inicio = $_POST['inicio'];
      $termino = $_POST['termino'];
      
      if (!$turma_id && !$curso_id) {
          die("Erro: turma_id ou curso_id não enviados. Verifique o formulário.");
      }

      $sqlMatricula = "INSERT INTO dados_matricula (matricula, turma_id, curso_id, inicio, termino)
                       VALUES ('$matricula', '$turma_id', $curso_id, '$inicio', '$termino')";

      if ($conexao->query($sqlMatricula) === TRUE) {
          echo "Aluno cadastrado com sucesso!";
      } else {
          echo "Erro ao inserir dados de matrícula: " . $conexao->error;
      }
  } else {
      echo "Erro ao inserir aluno: " . $conexao->error;
  }
}

$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css"  rel="stylesheet">
    <style>
  body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f0f2f5;
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

.container {
  display: flex;
  width: 85%;
  min-height: 85vh;
  margin: auto;
  margin-top: 60px;
  background-color: #ffffff;
  padding: 30px 40px;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.left-panel, .right-panel {
  width: 50%;
  padding: 30px;
}

@media (max-width: 768px) {
  .container {
    flex-direction: column;
    padding: 20px;
  }

  .left-panel, .right-panel {
    width: 100%;
    padding: 15px 0;
  }
}


        .image-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin-top: 10px;
        }

        .image-label {
            display: block;
            width: 100%;
            height: 100%;
            cursor: pointer;
            position: relative;
        }

        #preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 2px dashed #ccc;
            border-radius: 50%;
            box-sizing: border-box;
        }

        .overlay-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 50%;
            text-align: center;
            pointer-events: none;
        }

        .image-label:hover .overlay-text {
            opacity: 1;
        }

        .overlay-text span {
            pointer-events: auto;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .overlay-text span:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Alterna os textos com base na classe 'selected' */
        img.selected + .overlay-text .select-text {
            display: none;
        }

        img.selected + .overlay-text .remove-text {
            display: block;
        }

        .remove-text {
            display: none;
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

    <div class="container">
        <div class="left-panel">
            <form action="cadastro_aluno.php" method="POST" enctype="multipart/form-data">
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" maxlength="14"/>

                <label for="rg">RG</label>
                <input type="text" name="rg" maxlength="12" />

                <label for="nascimento">Data de Nascimento:</label>
                <input type="date" name="nascimento" name="nascimento" required>

                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                    <option value="outro">Outro</option>
                </select>

                <label for="responsavel">Responsável:</label>
                <input type="text" id="responsavel" name="responsavel" required>

                <label for="estado">Estado do Aluno:</label>
                <select id="estado" name="estado" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="ativo">Ativo</option>
                    <option value="inativo">Inativo</option>
                </select>
            </div>
            <div class="right-panel">
                <div class="image-container">
                    <label for="foto" class="image-label">
                    <img id="preview" src="perfil.png" alt="Foto do Aluno">
                    <div class="overlay-text">
                        <span class="select-text">Selecionar imagem</span>
                        <span class="remove-text" onclick="removerImagem()">Remover imagem</span>
                    </div>
                    </label>
                    <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" onchange="previewImage(event)">
                </div>


                <?php
                //Retorna o valor gerado da matrícula
                echo "<p style='margin-top: 25px; margin-bottom: 1px; '>Matrícula:</p><h2 style='margin: -1px; color: #2ecc71'>$matricula</h2>";
                ?>


                <label for="tipo_ensino">tipo de ensino:</label>
                <select id="tipo_ensino" name="tipo_ensino" required onchange="verificarTipoEnsino()">
                    <option value="" disabled selected>Selecione</option>
                    <option value="fundamental">fundamental</option>
                    <option value="medio">medio</option>
                    <option value="curso">curso</option>
                </select>

                <div id="campoCurso">
                <label for="curso_id">Curso:</label>
                <select id="curso_id" name="curso_id">
                    <option value="" disabled selected>Selecione</option>
                    <?php
                    // Exibir os cursos existentes do banco
                    include 'conexao.php';
                    $result = $conexao->query("SELECT id, nome FROM cursos");
                    while ($curso = $result->fetch_assoc()) {
                        echo "<option value='{$curso['id']}'>{$curso['nome']}</option>";
                    }
                    ?>
                </select>
            </div>

                <label for="inicio">Início:</label>
                <input type="date" id="inicio" name="inicio" required>

                <label for="termino">Término:</label>
                <input type="date" id="termino" name="termino" required>

                <label for="turma_id">Turma:</label>
                <select id="turma_id" name="turma_id" required>
                    <option value="" disabled selected>Selecione</option>
                    <?php
                    // Exibir as turmas existentes do banco
                    include 'conexao.php';
                    $result = $conexao->query("SELECT id, nome FROM turmas");
                    while ($turma = $result->fetch_assoc()) {
                        echo "<option value='{$turma['id']}'>{$turma['nome']}</option>";
                    }
                    ?>
                </select>

                <label for="periodo">Período:</label>
                <select id="periodo" name="periodo" required>
                    <option value="" disabled selected>Selecione</option>
                    <option value="manhã">manhã</option>
                    <option value="tarde">tarde</option>
                    <option value="noite">noite</option>
                </select>

                <button type="submit">Cadastrar</button>
            </div>
          </div>
      </form>
      
    <script>
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">

        function previewImage(event) {
        const preview = document.getElementById('preview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
                preview.classList.add('selected');
            };
            reader.readAsDataURL(file);
        }
    }

    function removerImagem() {
        const preview = document.getElementById('preview');
        preview.src = "perfil.png"; // Substitua pelo caminho correto da imagem padrão
        preview.classList.remove('selected');
        document.getElementById('foto').value = "";
    }

    //Se o tipo de ensino for curso exibe o campo, se não, o mantem oculto
    function verificarTipoEnsino() {
    var tipo = document.getElementById("tipo_ensino").value;
    var campoCurso = document.getElementById("campoCurso");

    if (tipo === "curso") {
        campoCurso.style.display = "block";
        document.getElementById("curso").required = true;
    } else {
        campoCurso.style.display = "none";
        document.getElementById("curso").required = false;
    }
}


// Formata o CPF no formato 000.000.000-00
function formatCPF(value) {
    // Remove tudo que não é número
    const numericValue = value.replace(/\D/g, "");
    let formattedValue = "";

    if (numericValue.length <= 3) {
      formattedValue = numericValue;
    } else if (numericValue.length <= 6) {
      formattedValue = numericValue.replace(/(\d{3})(\d+)/, "$1.$2");
    } else if (numericValue.length <= 9) {
      formattedValue = numericValue.replace(
        /(\d{3})(\d{3})(\d+)/,
        "$1.$2.$3"
      );
    } else if (numericValue.length <= 11) {
      formattedValue = numericValue.replace(
        /(\d{3})(\d{3})(\d{3})(\d+)/,
        "$1.$2.$3-$4"
      );
    } else {
      formattedValue = numericValue.slice(0, 11).replace(
        /(\d{3})(\d{3})(\d{3})(\d{2})/,
        "$1.$2.$3-$4"
      );
    }

    return formattedValue;
  }

  // Formata o RG no formato 00.000.000-0
  function formatRG(value) {
    // Remove tudo que não é número ou x
    const alphanumericValue = value.toUpperCase().replace(/[^0-9X]/g, "");
    let formattedValue = "";

    if (alphanumericValue.length <= 2) {
      formattedValue = alphanumericValue;
    } else if (alphanumericValue.length <= 5) {
      formattedValue = alphanumericValue.replace(/(\d{2})(\d+)/, "$1.$2");
    } else if (alphanumericValue.length <= 8) {
      formattedValue = alphanumericValue.replace(
        /(\d{2})(\d{3})(\d*)/,
        "$1.$2.$3"
      );
    } else if (alphanumericValue.length <= 9) {
      formattedValue = alphanumericValue.replace(
        /(\d{2})(\d{3})(\d{3})([0-9X]?)/,
        "$1.$2.$3-$4"
      );
    } else {
      // Se tiver mais chars, limita e formata os primeiros 9
      formattedValue = alphanumericValue
        .slice(0, 9)
        .replace(/(\d{2})(\d{3})(\d{3})([0-9X]?)/, "$1.$2.$3-$4");
    }

    return formattedValue;
  }

  const cpfInput = document.getElementById("cpf");
  const rgInput = document.getElementById("rg");

  cpfInput.addEventListener("input", (e) => {
    const formatted = formatCPF(e.target.value);
    e.target.value = formatted;
  });

  rgInput.addEventListener("input", (e) => {
    const formatted = formatRG(e.target.value);
    e.target.value = formatted;
  });
    </script>
</body>
</html>
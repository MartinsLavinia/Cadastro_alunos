<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cursos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
            border-width: 1px;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

        .container {
            display: flex;
            width: 80%;
            height: 130vh;
            margin: auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .left-panel {
            width: 50%;
            padding: 65px;
        }

        .right-panel {
            width: 50%;
            padding: 65px;
        }


        body {
      font-family: Arial, sans-serif;
      margin: 0;
      background-color: #f8f9fa;
    }
    .container {
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 40px;
}

.card {
  background-color: white;
  padding: 20px 30px;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 80px;
}

.card:hover {
  transform: translateX(5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.card h3 {
  margin: 0;
  font-size: 1.2em;
}

.info-box {
  background-color: #e9ecef;
  padding: 15px 25px;
  border-radius: 10px;
  text-align: left;
  font-size: 1.1em;
}

h2 {
  margin-bottom: 30px;
  text-align: center;
}

a.card {
  text-decoration: none;
  color: inherit;
}

    </style>
</head>
<body>


<h2>Painel Principal</h2>
  <div class="container">
    <a href="cadastro_aluno.php" class="card">
      <h3>Cadastrar Aluno</h3>
    </a>
    <a href="cursos_turmas.php" class="card">
      <h3>Gerenciar Cursos e Turmas</h3>
    </a>
    <a href="editar.php" class="card">
      <h3>Listar Alunos</h3>
    </a>
    <div class="info-box">
      <strong>Alunos cadastrados:</strong> 23
    </div>
    <div class="info-box">
      <strong>Cursos disponíveis:</strong> 5
    </div>
  </div>
</body>
</html>
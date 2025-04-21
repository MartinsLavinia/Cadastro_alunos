<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
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
            margin-bottom: 10px;
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
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="cadastro.php" method="POST">
            <label for="name">Nome Completo:</label>
            <input type="text" id="name" name="name" required>

            <label for="rg">RG:</label>
            <input type="text" id="rg" name="rg" required pattern="\d{6,8}[0-9Xx]">

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" pattern="\d{11}" required>

            <label for="nascimento">Data de Nascimento:</label>
            <input type="date" id="nascimento" name="nascimento" required>

            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="">Selecione</option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="outro">Outro</option>
            </select>

            <label for="responsavel">Responsável:</label>
            <input type="text" id="responsavel" name="responsavel" required>

            <label for="estado">Estado do Aluno:</label>
            <select id="estado" name="estado" required>
                <option value="">Selecione</option>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>

            <label for="foto">Foto do Aluno:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required>

            <label for="matricula">Matrícula:</label>
            <input type="number" id="matricula" name="matricula" required>

            <label for="curso">Curso:</label>
            <select id="curso" name="curso" required>
                <option value="">Selecione</option>
                <option value="curso1">Curso 1</option>
                <option value="curso2">Curso 2</option>
                <!-- teste -->
            </select>

            <label for="inicio">Início:</label>
            <input type="date" id="inicio" name="inicio" required>

            <label for="termino">Término:</label>
            <input type="date" id="termino" name="termino" required>

            <label for="turma">Turma:</label>
            <input type="text" id="turma" name="turma" required>

            <label for="periodo">Período:</label>
            <input type="text" id="periodo" name="periodo" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
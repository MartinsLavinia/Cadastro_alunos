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
    <div class="container">
        <div class="left-panel">
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
            </div>
        </form>
    </div>
    <script>
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
    </script>
</body>
</html>
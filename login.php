<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body, html {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: Arial, sans-serif;
}

.container {
  display: flex;
  height: 100vh;
}

.left-panel {
  width: 35%; /* Menos da metade */
  background-color: #2ecc71;
  color: #fff;
  padding: 40px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
}

.right-panel {
  width: 65%;
  background-color: #fff;
  padding: 60px;
}

/* Estilos opcionais */
.logo {
  max-width: 300px;
  margin-bottom: 20px;
}

.texto-info {
  text-align: center;
  font-size: 20px;
  line-height: 1.5;
}

.seta {
  position: absolute;
  right: -20px;
  top: 50%;
  background-color: #4D9165;
  color: #000;
  border-radius: 50%;
  padding: 10px 15px;
  font-size: 20px;
}

input {
    background-color: #F6F5F5;
    border-width: 1px;
    padding: 8px;
    border-radius: 5px;
}

.box {
    height: 50vh;
    width: 100%;
    max-width: 400px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: left;
    justify-content: left;
    padding: 20px;
    margin-top: 15%;
    margin-left: 20%;
}

form {
  display: flex;
  flex-direction: column;
  gap: 15px;
  width: 100%;
}

button {
    background-color: #2ecc71;
    border-radius: 5px;
    border-width: 1px;
    width: 40%;
    padding: 8px;
}

    </style>
</head>
<body>
    <div class="container">
    <div class="left-panel">
        <img src="logo_Unitech.png" alt="Logo do Colégio UniTech" class="logo">
        <p class="texto-info">
        Bem-vindo ao novo sistema digital da escola! Faça login ao lado para acessar sua área exclusiva como coordenador.
        <div class="seta">➜</div>
    </div>
    <div class="right-panel">
        <!-- Aqui vai o formulário depois -->
        <div class="box">
            <h1>Login</h1>
            <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a> </p>
            <br>
                <form method="POST">
                    <label for="email">Email Institucional:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>

                    <button type="submit">Login</button>
                </form>
                <?php

                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "cadastro_alunos";

                    // Conexão
                    $conexao = new mysqli($servername, $username, $password, $dbname);
                    if ($conexao->connect_error) {
                        die("Falha na conexão: " . $conexao->connect_error);
                    }

                    // Verifica se foi enviado via POST
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = trim($_POST['email']);
                        $senha = $_POST['senha'];

                        $stmt = $conexao->prepare("SELECT senha FROM contas WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($senhaHash);
                            $stmt->fetch();

                            if (password_verify($senha, $senhaHash)) {
                                $_SESSION['email'] = $email;
                                header("Location: index.php");
                                exit(); // Encerrar execução após redirecionar
                            } else {
                                $erro = "Senha incorreta!";
                            }
                        } else {
                            $erro = "Email não encontrado!";
                        }

                        $stmt->close();
                        $conexao->close();
                    }
                    ?>
                    
                    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

        </div>
    </div>
    </div>
</body>
</html>
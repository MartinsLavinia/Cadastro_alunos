<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
        Preencha os campos ao lado para criar seu acesso como coordenador e integrar o novo sistema digital da escola!
        </p>
        <div class="seta">➜</div>
    </div>
    <div class="right-panel">
        <!-- Aqui vai o formulário depois -->
        <div class="box">
            <h1>Cadastro</h1>
            <p>Já tem uma conta? <a href="login.php">Entre aqui</a> </p>
            <br>
                <form method="POST">
                    <label for="email">Email Institucional:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="senha">Criar Senha:</label>
                    <input type="password" id="senha" name="senha" required>

                    <label for="confirmarsenha">Confirmar a Senha:</label>
                    <input type="password" id="confirmarsenha" name="confirmarsenha" required>

                    <button type="submit">Cadastrar</button>
                </form>
                <br>
                <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cadastro_alunos";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já existe
    $verifica = $conexao->prepare("SELECT email FROM contas WHERE email = ?");
    $verifica->bind_param("s", $email);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        echo "Já existe uma conta cadastrada neste email!";
    } else {
        $stmt = $conexao->prepare("INSERT INTO contas (email, senha) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $senhaCriptografada);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
    }

    $verifica->close();
    $conexao->close();
}
?>
        </div>
    </div>
    </div>
</body>
</html>
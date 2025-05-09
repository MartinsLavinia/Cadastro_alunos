<?php
include 'conexao.php'; // Conexão com o banco de dados

$sql = "SELECT * FROM alunos";
$result = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css"  rel="stylesheet">
    <style>
      .container {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    h2.text-center {
        margin-bottom: 30px;
        font-weight: bold;
        color: #3AD770;
    }

    .table {
        background-color: #fafafa;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th {
        background-color: #3AD770;
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .table img {
        border-radius: 50%;
        border: 2px solid #3AD770;
        object-fit: cover;
    }

    .btn-info {
        background-color: #3AD770;
        border: none;
        color: white;
        transition: background 0.3s ease;
    }

    .btn-info:hover {
        background-color: #2fb95f;
    }

    .link-detalhes {
    color: #0d6efd; /* Azul padrão de link */
    text-decoration: underline;
    font-weight: 500;
    cursor: pointer;
    transition: color 0.2s ease;
    }

    .link-detalhes:hover {
        color: #084298; /* Azul mais escuro ao passar o mouse */
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

    <div class="container my-4">
        <h2 class="text-center">Lista de Alunos</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Matrícula</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($aluno = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <img src="<?php echo !empty($aluno['foto_url']) ? $aluno['foto_url'] : 'perfil.png'; ?>" alt="Foto de <?php echo $aluno['nome']; ?>" width="50" height="50">
                        </td>
                        <td><?php echo $aluno['nome']; ?></td>
                        <td><?php echo $aluno['matricula']; ?></td>
                        <td>
                          <a href="detalhes.php?matricula=<?php echo $aluno['matricula']; ?>" class="link-detalhes">Mais Detalhes</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

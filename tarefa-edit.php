<?php
session_start();
require_once('conexao.php');
$tarefa = [];
if (!isset($_GET['id'])) { //isset - ver se a variável existe
    header('Location: index.php');
} //se não tiver id redireciona para o index
else {
    $tarefaId = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM tarefa WHERE id = '{$tarefaId}'";
    $query = mysqli_query($conn, $sql);

    $sqlTa = "SELECT id, nome FROM status_tarefa";
    $statusTarefa = mysqli_query($conn, $sqlTa);

    if (mysqli_num_rows($query) > 0) {
        $tarefa = mysqli_fetch_array($query);
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Editar - Tarefa</title>
</head>

<style>
    body {
        background-image: url('./img/fundo_cadastro.jpg');
        background-size: cover;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }
</style>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="bi bi-person-fill-gear"></i>
                            Editar Tarefa
                            <a href="tarefas-index.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if ($tarefa):
                        ?>
                            <form action="acoes.php" method="POST">
                                <input type="hidden" name="tarefa_id" value="<?= $tarefa['id'] ?>">
                                <div class="mb-3">
                                    <label for="txt-nome-tarefa">Nome da tarefa</label>
                                    <input type="text" name="txt-nome-tarefa" id="txt-nome-tarefa" value="<?= $tarefa['nome'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="txt-descricao">Descrição</label>
                                    <input type="text" name="txt-descricao" id="txt-descricao" value="<?= $tarefa['descricao'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label for="txt-status">Status</label>
                                    <select name="txt-status" id="txt-status" class="form-select">
                                        <?php foreach ($statusTarefa as $sT): ?>
                                            <option value="<?php echo $sT['id'] ?>"
                                                <?php echo $sT['id'] == $tarefa['fk_id_status'] ? 'selected' : '' ?>>
                                                <?php echo $sT['nome'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="txt-data_limite">Data Limite</label>
                                    <input type="date" name="txt-data_limite" id="txt-data_limite" value="<?= $tarefa['data_limite'] ?>" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <button type="submit" name="edit_tarefa" class="btn btn-primary float-end">Salvar</button>
                                </div>
                            </form>
                        <?php
                        else:
                        ?>

                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                Tarefa não encontrado
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>

                        <?php
                        endif
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
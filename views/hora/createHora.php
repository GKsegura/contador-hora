<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcar Horas</title>
</head>

<body>
    <?php
    include './../../utils/conection.php'; // Inclui o arquivo de conexão

    // Obtém o ID do projeto da URL
    $id_projeto = isset($_GET['id_projeto']) ? intval($_GET['id_projeto']) : 0;

    // Verifica se o ID do projeto é válido
    if ($id_projeto <= 0) {
        die("ID do projeto inválido.");
    }

    // Consulta para obter informações do projeto
    $sql_projeto = "SELECT nome FROM projeto WHERE id_projeto = ?";
    $stmt_projeto = $conecta->prepare($sql_projeto);
    $stmt_projeto->bind_param("i", $id_projeto);
    $stmt_projeto->execute();
    $result_projeto = $stmt_projeto->get_result();

    if ($result_projeto->num_rows == 0) {
        die("Projeto não encontrado.");
    }

    $projeto = $result_projeto->fetch_assoc();
    ?>
    <header>
        <h1>Marcar Horas para o Projeto: <?php echo htmlspecialchars($projeto['nome']); ?></h1>
    </header>
    <main>
        <form action="saveHora.php" method="post">
            <input type="hidden" name="id_projeto" value="<?php echo htmlspecialchars($id_projeto); ?>">

            <label for="hora_inicial">Hora Inicial:</label>
            <input type="datetime-local" name="hora_inicial" id="hora_inicial" required>

            <label for="hora_final">Hora Final:</label>
            <input type="datetime-local" name="hora_final" id="hora_final" required>

            <button type="submit">Salvar Horas</button>
        </form>
    </main>
    <footer>
        <a href="../index.php">Voltar para a Página Inicial</a>
    </footer>
</body>

</html>
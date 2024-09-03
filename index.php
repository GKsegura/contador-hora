<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de horas</title>
</head>

<body>
    <?php
    include 'utils/conection.php'; // Inclui o arquivo de conexão
    ?>
    <header>
        <h1>header</h1>
    </header>
    <main>
        <h1>main</h1>
        <a href="./views/projeto/createProjeto.php">Adicionar Projeto</a>
        <a href="./views/hora/createHora.php">Marcar Horas</a>

        <div class="projetos">
            <?php
            $sql = "SELECT * FROM projeto";
            $result = $conecta->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Ajuste o caminho da imagem conforme necessário
                    $imagem_capa = $row['imagem_capa'];

                    // Se o caminho da imagem for relativo ao diretório onde as imagens são armazenadas
                    $caminho_imagem = 'public/images/' . basename($imagem_capa);

                    echo "<div class='projeto' style='border: 1px solid black;'>";
                    echo "<img src='" . $caminho_imagem . "' alt='" . $row['nome'] . "' style='max-width: 300px; height: auto;border: 1px solid black;'>";
                    echo "<h2>" . $row['nome'] . "</h2>";
                    echo "<a href='" . $row['link'] . "' target='_blank'>Acessar no GitHub</a>";
                    if ($row['total_horas'] != null && $row['total_horas'] != 0 && $row['total_horas'] != '') {
                        echo "<p>Total de horas: " . $row['total_horas'] . "</p>";
                    } else {
                        echo "<p>Nenhuma hora marcada</p>";
                    }
                    echo "<a href='./views/hora/createHora.php?id_projeto=" . $row['id_projeto'] . "'>Marcar horas</a>";
                    echo "</div>";
                }
            } else {
                echo "Nenhum projeto cadastrado";
            }
            ?>
        </div>
    </main>
    <footer>
        <h1>footer</h1>
    </footer>
</body>

</html>
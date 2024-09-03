<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de horas</title>
</head>

<body>
    <?php
    include './../../utils/conection.php';
    ?>
    <header>
        <h1>header</h1>
    </header>
    <main>
        <h1>main</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
            <label for="link">Link:</label>
            <input type="text" name="link" id="link" required>
            <label for="imagem_capa">Imagem:</label>
            <input type="file" name="imagem_capa" id="imagem_capa" required>
            <button type="submit">Adicionar</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $link = $_POST['link'];

            // Verifica se o arquivo foi enviado e se não houve erro
            if (isset($_FILES['imagem_capa']) && $_FILES['imagem_capa']['error'] == 0) {
                $imagem_capa = $_FILES['imagem_capa'];

                // Defina o diretório onde as imagens serão salvas
                $diretorio = __DIR__ . '/../../public/images/'; // Caminho absoluto

                // Crie o diretório se não existir
                if (!is_dir($diretorio)) {
                    mkdir($diretorio, 0777, true);
                }

                // Define o caminho do arquivo
                $caminho_imagem = $diretorio . basename($imagem_capa['name']);

                // Move o arquivo para o diretório
                if (move_uploaded_file($imagem_capa['tmp_name'], $caminho_imagem)) {
                    // Salva as informações no banco de dados
                    $sql = "INSERT INTO projeto (nome, link, imagem_capa) VALUES (?, ?, ?)";
                    $stmt = $conecta->prepare($sql);
                    $stmt->bind_param("sss", $nome, $link, $caminho_imagem);
                    $result = $stmt->execute();

                    if ($result) {
                        echo "Projeto adicionado com sucesso!";
                    } else {
                        echo "Erro ao adicionar projeto: " . $stmt->error;
                    }
                } else {
                    echo "Erro ao fazer upload da imagem!";
                }
            } else {
                echo "Nenhuma imagem foi enviada ou houve um erro no envio.";
            }
        }
        ?>
    </main>
    <footer>
        <h1>footer</h1>
    </footer>
</body>

</html>
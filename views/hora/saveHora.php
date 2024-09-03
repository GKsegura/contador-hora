<?php
include './../../utils/conection.php'; // Inclui o arquivo de conexão

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $id_projeto = isset($_POST['id_projeto']) ? intval($_POST['id_projeto']) : 0;
    $hora_inicial = isset($_POST['hora_inicial']) ? $_POST['hora_inicial'] : '';
    $hora_final = isset($_POST['hora_final']) ? $_POST['hora_final'] : '';

    // Verifica se os dados são válidos
    if ($id_projeto > 0 && !empty($hora_inicial) && !empty($hora_final)) {
        // Inserir horas na tabela horas
        $sql_horas = "INSERT INTO horas (hora_inicial, hora_final, data_registro) VALUES (?, ?, NOW())";
        $stmt_horas = $conecta->prepare($sql_horas);
        $stmt_horas->bind_param("ss", $hora_inicial, $hora_final);

        if ($stmt_horas->execute()) {
            // Obtém o ID da última inserção
            $id_horas = $conecta->insert_id;

            // Relaciona as horas com o projeto
            $sql_horas_projeto = "INSERT INTO horas_projeto (id_projeto, id_horas) VALUES (?, ?)";
            $stmt_horas_projeto = $conecta->prepare($sql_horas_projeto);
            $stmt_horas_projeto->bind_param("ii", $id_projeto, $id_horas);

            if ($stmt_horas_projeto->execute()) {
                echo "Horas registradas com sucesso!";
            } else {
                echo "Erro ao associar horas com o projeto!";
            }
        } else {
            echo "Erro ao registrar horas!";
        }
    } else {
        echo "Dados inválidos!";
    }
} else {
    echo "Método de requisição inválido.";
}
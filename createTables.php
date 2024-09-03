<?php
function criarTabelas($conecta)
{
    // Cria a tabela projeto se não existir
    $sql = "CREATE TABLE IF NOT EXISTS projeto (
id_projeto INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
link VARCHAR(255),
imagem_capa VARCHAR(255),
total_horas DECIMAL(5, 2) DEFAULT 0.00
)";
    if (!mysqli_query($conecta, $sql)) {
        echo "Erro ao criar a tabela projeto: " . mysqli_error($conecta);
        return;
    }

    // Cria a tabela horas se não existir
    $sql = "CREATE TABLE IF NOT EXISTS horas (
id_horas INT AUTO_INCREMENT PRIMARY KEY,
horas DECIMAL(5, 2),
data_registro DATETIME
)";
    if (!mysqli_query($conecta, $sql)) {
        echo "Erro ao criar a tabela horas: " . mysqli_error($conecta);
        return;
    }

    // Cria a tabela horas_projeto se não existir
    $sql = "CREATE TABLE IF NOT EXISTS horas_projeto (
id_horas_projeto INT AUTO_INCREMENT PRIMARY KEY,
id_projeto INT,
id_horas INT,
FOREIGN KEY (id_projeto) REFERENCES projeto(id_projeto),
FOREIGN KEY (id_horas) REFERENCES horas(id_horas)
)";
    if (!mysqli_query($conecta, $sql)) {
        echo "Erro ao criar a tabela horas_projeto: " . mysqli_error($conecta);
        return;
    }

    echo "Tabelas criadas com sucesso!";
}

// Função para adicionar horas e atualizar o total no projeto
function adicionarHoras($conecta, $id_projeto, $horas)
{
    // Adiciona a nova entrada de horas
    $sql = "INSERT INTO horas (horas, data_registro) VALUES (?, NOW())";
    $stmt = mysqli_prepare($conecta, $sql);
    mysqli_stmt_bind_param($stmt, "d", $horas);

    if (mysqli_stmt_execute($stmt)) {
        $id_horas = mysqli_insert_id($conecta); // Obtém o ID da nova entrada de horas

        // Relaciona as horas ao projeto
        $sql = "INSERT INTO horas_projeto (id_projeto, id_horas) VALUES (?, ?)";
        $stmt = mysqli_prepare($conecta, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_projeto, $id_horas);

        if (mysqli_stmt_execute($stmt)) {
            // Atualiza o total de horas na tabela projeto
            $sql = "UPDATE projeto SET total_horas = total_horas + ? WHERE id_projeto = ?";
            $stmt = mysqli_prepare($conecta, $sql);
            mysqli_stmt_bind_param($stmt, "di", $horas, $id_projeto);

            if (mysqli_stmt_execute($stmt)) {
                echo "Horas adicionadas e total de horas atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar o total de horas: " . mysqli_error($conecta);
            }
        } else {
            echo "Erro ao relacionar horas com o projeto: " . mysqli_error($conecta);
        }
    } else {
        echo "Erro ao adicionar horas: " . mysqli_error($conecta);
    }
}
criarTabelas($conecta);
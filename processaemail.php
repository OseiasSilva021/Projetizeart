<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $email = $_POST['email'];

    // Configurações de conexão com o banco de dados
$host = 'sql105.infinityfree.com'; // Host do seu banco de dados
$dbname = 'if0_37745435_cadastro'; // Nome do banco de dados
$username = 'if0_37745435'; // Usuário do banco
$password = 'KMrIBprDe4'; // Senha do banco

    // Conexão com o banco de dados MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se a conexão foi bem-sucedida
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Preparar a consulta SQL para inserir os dados no banco de dados
    $sql = "INSERT INTO usuarios (email) VALUES (?)";

    // Preparar a declaração
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nome, $email);  // "ss" indica que são dois parâmetros do tipo string

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Dados inseridos com sucesso!";
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>
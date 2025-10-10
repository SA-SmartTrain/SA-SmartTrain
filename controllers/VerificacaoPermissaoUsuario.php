<?php
class User {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    // Login existente
    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email_usuarios = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $dados = $resultado->fetch_assoc();
            if (password_verify($password, $dados["senha_usuarios"])) {
                session_start();
                $_SESSION["email_usuarios"] = $dados["email_usuarios"];
                $_SESSION["nome_usuarios"] = $dados["nome_usuarios"];
                $_SESSION["perfil"] = $dados["perfil"];

                if ($dados["perfil"] === "administrador") {
                    header('Location: ../admin.php');
                    exit;
                } else {
                    header('Location: ../pagina_inicial.php');
                    exit;
                }
            }
        }
        return false;
    }

    // Novo método para cadastro
    public function register($nome, $email, $password, $cpf, $perfil, $foto) {
        // Verifica email
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email_usuarios = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) return "Email já cadastrado.";

        // Verifica CPF
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE cpf_usuarios = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) return "CPF já cadastrado.";

        // Insere usuário
        $senhaHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nome_usuarios, email_usuarios, senha_usuarios, cpf_usuarios, perfil, foto_usuarios) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $email, $senhaHash, $cpf, $perfil, $foto);

        if ($stmt->execute()) {
            // Cria sessão
            session_start();
            $_SESSION["email_usuarios"] = $email;
            $_SESSION["nome_usuarios"] = $nome;
            $_SESSION["perfil"] = $perfil;

            // Redireciona administrador
            if ($perfil === "administrador") {
                header('Location: ../admin.php');
                exit;
            } else {
                header('Location: ../pagina_inicial.php');
                exit;
            }
        } else {
            return "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>

<?php
require_once __DIR__ . '/../Model/PostModel.php';
require_once __DIR__ . '/../Helper/Auth.php';

class PostController {
    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    public function index() {
        Auth::verificar();
        $model = new PostModel($this->db);
        $posts = $model->buscarTodos();
        // Caminho atualizado para refletir a nova organização em pastas
        include __DIR__ . '/../View/Comunidade/feedView.php';
    }

    public function salvar() {
        Auth::verificar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conteudo = $_POST['conteudo_texto']; 
            $titulo = "Post da Comunidade"; 
            $id_usuario = $_SESSION['usuario_id']; 

            $model = new PostModel($this->db);

            // REFINAMENTO: Chamando a regra de negócio que valida o conteúdo
            if (!$model->validarConteudo($conteudo)) {
                header("Location: index.php?rota=feed&erro=conteudo_vazio");
                exit();
            }

            $post_caminho_imagem = null;
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
                $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                $novo_nome = uniqid() . "." . $extensao;
                $destino = 'public/uploads/' . $novo_nome;

                if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                    $post_caminho_imagem = $destino;
                }
            }

            $model->inserir($id_usuario, $titulo, $conteudo, $post_caminho_imagem); 

            header("Location: index.php?rota=feed");
            exit();
        }
    }

    public function excluir() {
        Auth::verificar(); 
        if (isset($_GET['id'])) {
            $id_post = $_GET['id'];
            $id_usuario_logado = $_SESSION['usuario_id'];

            $model = new PostModel($this->db);
            $model->excluirSeguro($id_post, $id_usuario_logado);
        }
        header("Location: index.php?rota=feed");
        exit();
    }

    public function curtir() {
        // REFINAMENTO: Protegendo a rota de curtidas contra acessos maliciosos deslogados
        Auth::verificar();
        if (isset($_GET['id'])) {
            $id_post = $_GET['id'];
            $model = new PostModel($this->db);
            $model->adicionarCurtida($id_post);
        }
        header("Location: index.php?rota=feed");
        exit();
    }
}
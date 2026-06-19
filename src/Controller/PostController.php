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
        include __DIR__ . '/../View/Comunidade/feedView.php';
    }

    public function salvar() {
        Auth::verificar();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conteudo = $_POST['conteudo_texto']; 
            $titulo = "Post da Comunidade"; 
            $id_usuario = $_SESSION['usuario_id']; 

            $model = new PostModel($this->db);
            
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
            $post = $model->buscarPorId($id_post);
            
            if ($model->excluirSeguro($id_post, $id_usuario_logado)) {
                if ($post && !empty($post['post_caminho_imagem']) && file_exists($post['post_caminho_imagem'])) {
                    unlink($post['post_caminho_imagem']);
                }
            }
        }
        header("Location: index.php?rota=feed");
        exit();
    }

    public function curtir() {
        Auth::verificar();
        
        if (ob_get_length()) ob_clean();
        
        header('Content-Type: application/json');

        if (isset($_GET['id'])) {
            $id_post = $_GET['id'];
            $id_usuario_logado = $_SESSION['usuario_id'];

            $model = new PostModel($this->db);
            $model->alternarCurtida($id_post, $id_usuario_logado);
            
            $postAtualizado = $model->buscarPorId($id_post);
            
            echo json_encode([
                'sucesso' => true,
                'curtidas' => $postAtualizado['curtidas']
            ]);
            exit();
        }

        echo json_encode(['sucesso' => false, 'erro' => 'ID inválido']);
        exit();
    }
}
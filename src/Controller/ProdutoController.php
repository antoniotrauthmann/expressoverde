<?php
require_once __DIR__ . '/../Model/ProdutoModel.php';

class ProdutoController
{
    private $db;

    public function __construct($mysqli)
    {
        $this->db = $mysqli;
    }

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome      = trim($_POST['nome']);
            $categoria = $_POST['categoria'];
            $preco     = $_POST['preco'];
            $estoque   = $_POST['estoque'];
            $descricao = trim($_POST['descricao'] ?? '');

            // Verifica se o usuário está logado e é profissional
            if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'profissional') {
                header("Location: index.php?rota=login");
                exit();
            }

            // Validação antes de qualquer insert
            if (empty($_FILES['imagens']['name'][0])) {
                $_SESSION['erro'] = 'Adicione ao menos uma imagem.';
                header("Location: index.php?rota=cadastrar_produto");
                exit();
            }

            if (empty($descricao)) {
                $_SESSION['erro'] = 'Preencha a descrição do produto.';
                header("Location: index.php?rota=cadastrar_produto");
                exit();
            }

            $model = new ProdutoModel($this->db);

            try {
                $id_produto = $model->inserir($nome, $categoria, $preco, $estoque, $descricao);

                $uploadDir = __DIR__ . '/../../public/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                foreach ($_FILES['imagens']['tmp_name'] as $i => $tmpName) {
                    if ($_FILES['imagens']['error'][$i] !== UPLOAD_ERR_OK) continue;

                    $nomeArquivo = uniqid() . '_' . basename($_FILES['imagens']['name'][$i]);
                    $destino     = $uploadDir . $nomeArquivo;

                    if (move_uploaded_file($tmpName, $destino)) {
                        $model->inserirImagem($id_produto, $nomeArquivo);
                    }
                }

                $_SESSION['sucesso'] = 'Produto cadastrado com sucesso!';
            } catch (Exception $e) {
                $_SESSION['erro'] = 'Erro ao cadastrar produto. Tente novamente.';
            }

            header("Location: index.php?rota=cadastrar_produto");
            exit();
        }

        include __DIR__ . '/../View/Cadastro_produto/index.php';
    }
}

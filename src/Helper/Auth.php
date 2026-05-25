<?php

/**
 * Helper para verificar autenticação e gerenciar sessões de usuário.
 */
class Auth {
    /**
     * Garante que a sessão esteja ativa antes de qualquer operação.
     * Verifica se já existe uma sessão antes de iniciar uma nova.
     */
    private static function iniciarSessao() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Verifica se o usuário está autenticado.
     * Se não estiver, redireciona para a página de login.
     * * @return array Retorna a superglobal $_SESSION
     */
    public static function verificar() {
        self::iniciarSessao();
        
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?rota=login');
            exit;
        }
        
        return $_SESSION;
    }

    /**
     * Verifica se está autenticado sem realizar redirecionamentos.
     * * @return bool
     */
    public static function estaAutenticado() {
        self::iniciarSessao();
        return isset($_SESSION['usuario_id']);
    }

    /**
     * Obtém o ID do usuário autenticado na sessão.
     * * @return mixed|null
     */
    public static function obterIdUsuario() {
        self::iniciarSessao();
        return $_SESSION['usuario_id'] ?? null;
    }

    /**
     * Obtém os principais dados do usuário autenticado.
     * * @return array
     */
    public static function obterDados() {
        self::iniciarSessao();
        return [
            'id'    => $_SESSION['usuario_id'] ?? null,
            'nome'  => $_SESSION['usuario_nome'] ?? null,
            'email' => $_SESSION['usuario_email'] ?? null,
            'tipo'  => $_SESSION['usuario_tipo'] ?? null
        ];
    }

    /**
     * Finaliza a sessão atual e redireciona para a tela de login.
     */
    public static function logout() {
        self::iniciarSessao();
        session_destroy();
        header('Location: index.php?rota=catalogo');
        exit;
    }
}
?>
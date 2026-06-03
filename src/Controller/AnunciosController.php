<?php

class AnunciosController {
    
    private $caminhoJSON;
    
    public function __construct() {
        $this->caminhoJSON = __DIR__ . '/../Model/anuncios.json';
    }
    
    /**
     * Obtém todos os anúncios ativos
     * @return array Lista de anúncios
     */
    public function obterAnuncios() {
        $dados = $this->lerJSON();
        
        if(!$dados) {
            return [];
        }
        
        // Filtrar apenas anúncios ativos
        $anunciosAtivos = array_filter($dados['anuncios'], function($anuncio) {
            return $anuncio['ativo'] === true;
        });
        
        return array_values($anunciosAtivos);
    }
    
    /**
     * Obtém um anúncio específico pelo ID
     * @param int $id ID do anúncio
     * @return array|null Dados do anúncio ou null
     */
    public function obterAnuncioPorId($id) {
        $anuncios = $this->obterAnuncios();
        
        foreach($anuncios as $anuncio) {
            if($anuncio['id'] == $id) {
                return $anuncio;
            }
        }
        
        return null;
    }
    
    /**
     * Adiciona um novo anúncio
     * @param array $anuncio Dados do novo anúncio
     * @return bool Sucesso da operação
     */
    public function adicionarAnuncio($anuncio) {
        $dados = $this->lerJSON();
        
        if(!$dados) {
            $dados = ['anuncios' => []];
        }
        
        // Gerar novo ID
        $novoId = count($dados['anuncios']) > 0 ? 
                  max(array_column($dados['anuncios'], 'id')) + 1 : 1;
        
        $anuncio['id'] = $novoId;
        $anuncio['ativo'] = $anuncio['ativo'] ?? true;
        
        $dados['anuncios'][] = $anuncio;
        
        return $this->salvarJSON($dados);
    }
    
    /**
     * Atualiza um anúncio existente
     * @param int $id ID do anúncio
     * @param array $dados Dados para atualizar
     * @return bool Sucesso da operação
     */
    public function atualizarAnuncio($id, $dados) {
        $jsonDados = $this->lerJSON();
        
        foreach($jsonDados['anuncios'] as $key => $anuncio) {
            if($anuncio['id'] == $id) {
                $jsonDados['anuncios'][$key] = array_merge($anuncio, $dados);
                return $this->salvarJSON($jsonDados);
            }
        }
        
        return false;
    }
    
    /**
     * Remove um anúncio (soft delete - marca como inativo)
     * @param int $id ID do anúncio
     * @return bool Sucesso da operação
     */
    public function removerAnuncio($id) {
        return $this->atualizarAnuncio($id, ['ativo' => false]);
    }
    
    /**
     * Carrega dados do arquivo JSON
     * @return array|null Dados do JSON ou null em caso de erro
     */
    private function lerJSON() {
        if(!file_exists($this->caminhoJSON)) {
            return null;
        }
        
        $conteudo = file_get_contents($this->caminhoJSON);
        return json_decode($conteudo, true);
    }
    
    /**
     * Salva dados no arquivo JSON
     * @param array $dados Dados para salvar
     * @return bool Sucesso da operação
     */
    private function salvarJSON($dados) {
        $json = json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        
        return file_put_contents($this->caminhoJSON, $json) !== false;
    }
}

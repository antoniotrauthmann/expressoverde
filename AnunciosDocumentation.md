# Documentação do AnunciosController e Estrutura JSON

(arquivo de documentação gerado com IA. basicamente o json será o banco de dados para os anuncios, guardando dados básicos como 
 URL,midia e se é um anuncio ativo ou não, enquanto AnunciosController é onde ocorre a criação,leitura,atualização e delete dos anuncios)

## Visão Geral

Esta documentação descreve as funcionalidades do `AnunciosController` e a estrutura do arquivo JSON `anuncios.json` utilizado para armazenar os dados dos anúncios.

## Estrutura JSON (`anuncios.json`)

O arquivo `anuncios.json` é um objeto JSON que contém uma lista de anúncios. A estrutura é a seguinte:

```json
{
  "anuncios": [
    {
      "id": number,           // Identificador único do anúncio
      "titulo": string,       // Título do anúncio
      "descricao": string,    // Descrição do anúncio
      "imagem": string,       // Caminho para a imagem do anúncio
      "link": string,         // URL de destino do anúncio
      "ativo": boolean        // Status do anúncio (true = ativo, false = inativo)
    }
  ]
}
```

### Campos do Anúncio

- **id**: Número inteiro único que identifica o anúncio.
- **titulo**: String com o título do anúncio.
- **descricao**: String com a descrição detalhada do anúncio.
- **imagem**: String com o caminho relativo para a imagem do anúncio.
- **link**: String com a URL para onde o anúncio direciona.
- **ativo**: Booleano que indica se o anúncio está ativo (true) ou inativo (false).

## AnunciosController

A classe `AnunciosController` gerencia as operações CRUD (Create, Read, Update, Delete) dos anúncios armazenados no arquivo JSON.

### Métodos Públicos

#### `obterAnuncios()`

Obtém todos os anúncios ativos.

- **Parâmetros**: Nenhum
- **Retorno**: Array de anúncios ativos
- **Exemplo de uso**:
  ```php
  $controller = new AnunciosController();
  $anuncios = $controller->obterAnuncios();
  ```

#### `obterAnuncioPorId($id)`

Obtém um anúncio específico pelo ID.

- **Parâmetros**:
  - `$id` (int): ID do anúncio
- **Retorno**: Array com os dados do anúncio ou null se não encontrado
- **Exemplo de uso**:
  ```php
  $anuncio = $controller->obterAnuncioPorId(1);
  ```

#### `adicionarAnuncio($anuncio)`

Adiciona um novo anúncio.

- **Parâmetros**:
  - `$anuncio` (array): Dados do novo anúncio (titulo, descricao, imagem, link, ativo opcional)
- **Retorno**: Boolean indicando sucesso da operação
- **Exemplo de uso**:
  ```php
  $novoAnuncio = [
      'titulo' => 'Novo Anúncio',
      'descricao' => 'Descrição do anúncio',
      'imagem' => '../public/img/novo.jpg',
      'link' => 'https://exemplo.com'
  ];
  $sucesso = $controller->adicionarAnuncio($novoAnuncio);
  ```

#### `atualizarAnuncio($id, $dados)`

Atualiza um anúncio existente.

- **Parâmetros**:
  - `$id` (int): ID do anúncio a ser atualizado
  - `$dados` (array): Dados para atualizar
- **Retorno**: Boolean indicando sucesso da operação
- **Exemplo de uso**:
  ```php
  $dadosAtualizados = ['titulo' => 'Título Atualizado'];
  $sucesso = $controller->atualizarAnuncio(1, $dadosAtualizados);
  ```

#### `removerAnuncio($id)`

Remove um anúncio (soft delete - marca como inativo).

- **Parâmetros**:
  - `$id` (int): ID do anúncio a ser removido
- **Retorno**: Boolean indicando sucesso da operação
- **Exemplo de uso**:
  ```php
  $sucesso = $controller->removerAnuncio(1);
  ```

### Métodos Privados

#### `lerJSON()`

Carrega dados do arquivo JSON.

- **Parâmetros**: Nenhum
- **Retorno**: Array com os dados do JSON ou null em caso de erro

#### `salvarJSON($dados)`

Salva dados no arquivo JSON.

- **Parâmetros**:
  - `$dados` (array): Dados para salvar
- **Retorno**: Boolean indicando sucesso da operação

## Notas de Implementação

- O controlador utiliza soft delete para remoção de anúncios (marca como inativo).
- Os IDs são gerados automaticamente como números sequenciais.
- O arquivo JSON é armazenado em `src/Model/anuncios.json`.
- Todas as operações retornam boolean para indicar sucesso/falha.</content>
<parameter name="filePath">d:\xampp\htdocs\expressoverde\projeto-es\AnunciosDocumentation.md
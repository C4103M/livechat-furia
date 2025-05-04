# 📡 Documentação da API - Projeto Portal Interativo Fúria

Este documento descreve os endpoints da API responsáveis pela comunicação entre o frontend (Vue.js) e o backend (PHP) do projeto **Portal Interativo Fúria**.

A API segue o padrão RESTful e é utilizada para operações de autenticação, chat, comentários e gerenciamento de usuários.

---

## 📁 Endpoints

### 1. 🔐 Autenticação

#### `POST /api/user/userLogin.php`

- **Descrição:** Realiza o login do usuário.
- **Corpo da requisição:**

```json
{
  "email": "usuario@exemplo.com",
  "senha": "123456"
}
```

- **Resposta:**

```json
{
  "status": "sucesso",
  "token": "abc123",
  "message": "Login realizado com sucesso",
  "codigo": 200
}
```

---

#### `POST /api/user/userCadastro.php`

- **Descrição:** Realiza o cadastro de um novo usuário.
- **Corpo da requisição:**

```json
{
  "nome": "Caio",
  "email": "usuario@exemplo.com",
  "senha": "123456"
}
```

- **Resposta:**

```json
{
  "status": "sucesso",
  "mensagem": "Usuário cadastrado com sucesso",
  "codigo": 200,
  "token": "abcdee"
}
```

---

### 2. 💬 Chat público (Livechat)
(Em fase de desenvolvimento)
#### `GET /api/message/publico`

- **Descrição:** Retorna todas as mensagens do chat público.
- **Resposta:**

```json
[
  {
    "usuario": "Luiza",
    "mensagem": "Nova atualização da Fúria chegou!",
    "data": "2025-05-04 14:32"
  }
]
```

---

#### `POST /api/message/publico`

- **Descrição:** Envia uma nova mensagem para o chat público.
- **Cabeçalho necessário:** Token de autenticação
- **Corpo da requisição:**

```json
{
  "user_id": 1,  
  "mensagem": "Alguém testou a nova skin?"
}
```

- **Resposta:**

```json
{
  "status": "sucesso",
  "mensagem": "Mensagem enviada"
}
```

---

### 3. 📥 Chat privado

#### `GET /api/message/buscarConversa.php/`

- **Descrição:** Retorna as mensagens privadas com um determinado usuário.
- **Resposta:**

```json
[
  {
    "de": "Caio",
    "para": "Lucas",
    "mensagem": "Jogamos mais tarde?",
    "data": "2025-05-04 14:10"
  }
]
```

---

#### `POST /api/message/enviarMensagem.php`

- **Descrição:** Envia uma mensagem privada.
- **Corpo da requisição:**

```json
{
  "destinatario_id": 2,
  "remetente_id": 1,
  "mensagem": "Partiu jogar?"
}
```

- **Resposta:**

```json
{
  "status": "sucesso",
  "codigo": 200,
  "mensagem": "Mensagem enviada com sucesso"
}
```

---

### 4. 📰 Notícias

#### `GET /api/posts/listNews.php`

- **Descrição:** Retorna todas as notícias do portal.
- **Resposta:**

```json
[
  {
    "id": 1,
    "titulo": "Fúria lança nova atualização",
    "conteudo": "A atualização traz novos personagens...",
    "data": "2025-05-02"
  }
]
```

---

#### `POST /api/posts/{id}/comentarios`

- **Descrição:** Envia um comentário em uma notícia.
- **Corpo da requisição:**

```json
{
  "autor_id": 1,
  "conteudo": "Muito legal essa atualização!",
  "slug": "camisa-furia-nova"
}
```

- **Resposta:**

```json
{
  "status": "sucesso",
  "mensagem": "Comentário enviado com sucesso",
  "codigo": "200"
}
```

---

#### `GET /api/posts/buscarPorSlug.php`

- **Descrição:** Busca uma notícia específica.
- **Corpo da requisição:**

```json
{
  "slug": "slug-da-noticia"
}
```

- **Resposta:**

```json
{
  "status": "success",
  "mensagem": "Sucesso",
  "codigo": 200,
  "data": {
    // Dados do post
  }
}
```

---

#### `POST /api/posts/editPost.php`

- **Descrição:** Busca uma notícia específica.
- **Corpo da requisição:**

```json
{
  "titulo": "Titulo da notícia",
  "slug": "slug-da-noticia",
  "subtitulo": "subtitulo da notícia",
  "conteudo": "Conteúdo do post",
  "categoria": "CAT"
}
```

- **Resposta:**

```json
{
  "status": "success",
  "message": "Atualizado com sucesso",
  "codigo": ""
}
```

---
#### `POST /api/posts/inserPost.php`

- **Descrição:** Requisição para Criar notícias.
- **Corpo da requisição:**

```json
{
  "titulo": "Titulo da notícia",
  "slug": "slug-da-noticia",
  "subtitulo": "subtitulo da notícia",
  "conteudo": "Conteúdo do post",
  "categoria": "CAT",
  "autor_id": 1
}
```

- **Resposta:**

```json
{
  "status": "success",
  "message": "Inserido com sucesso",
  "codigo": ""
}
```

---

### 5. ⚙️ Configurações

#### `GET /api/user/alterEmail.php`

- **Descrição:** Altera o email do usuário.

- **Corpo da requisição:**

```json
[
  {
    "id": 1,
    "newEmail": "exemplo2@email",
    "senha": "12345"
  }
]
```

---

- **Resposta:**

```json
[
  {
    "status": "success",
    "codigo": 200,
    "mensagem": "Email alterado com sucesso",
    "token": "newToken"
  }
]
```

---

#### `GET /api/user/alterFoto.php`

- **Descrição:** Altera ou adiciona foto ao usuário.

- **Corpo da requisição:**

```json
[
  {
    "id": 1,
    "newFoto": "FILE",
    "senha": "12345"
  }
]
```

---

- **Resposta:**

```json
[
  {
    "status": "success",
    "codigo": 200,
    "mensagem": "Foto alterada com sucesso",
    "token": "newToken"
  }
]
```

---
#### `GET /api/user/alterName.php`

- **Descrição:** Altera o nomr do usuário.

- **Corpo da requisição:**

```json
[
  {
    "id": 1,
    "newName": "Fulaninho",
    "senha": "12345"
  }
]
```

---

- **Resposta:**

```json
[
  {
    "status": "success",
    "codigo": 200,
    "mensagem": "Nome alterado com sucesso",
    "token": "newToken"
  }
]
```

---

#### `GET /api/user/alterSenha.php`

- **Descrição:** Altera a senha do usuário.

- **Corpo da requisição:**

```json
[
  {
    "id": 1,
    "newPassword": "4321",
    "senha": "12345"
  }
]
```

---

- **Resposta:**

```json
[
  {
    "status": "success",
    "codigo": 200,
    "mensagem": "Senha alterada com sucesso",
    "token": "newToken"
  }
]
```

---

#### `GET /api/user/userDelete.php`

- **Descrição:** Deleta o usuário do banco de dados.

- **Corpo da requisição:**

```json
[
  {
    "id": 1,
    "senha": "1234"
  }
]
```

---

- **Resposta:**

```json
[
  {
    "status": "success",
    "codigo": 200,
    "mensagem": "Usuário excluído com sucesso"
  }
]
```

---

## ✅ Autenticação

A maioria dos endpoints exige um **token JWT** no cabeçalho da requisição:

```http
Authorization: Bearer <token>
```

---

## 🛠️ Códigos de Status HTTP

| Código | Significado                |
|--------|----------------------------|
| 200    | OK                         |
| 201    | Criado                     |
| 400    | Requisição inválida        |
| 401    | Não autorizado             |
| 404    | Não encontrado             |
| 500    | Erro interno do servidor   |

---

## 📌 Observações

- Todos os dados são trafegados em formato **JSON**.
- O backend deve validar campos obrigatórios e autenticação.
- Requisições sem token ou com token inválido receberão `401 Unauthorized`.

---

📄 **Última atualização:** 04/05/2025  
👤 **Responsável:** Caio ([GitHub](https://github.com/C4103M))
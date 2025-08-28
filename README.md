# Projeto: Portal Interativo Fúria

Sistema web que simula um ambiente interativo de fãs do jogo **Fúria**, com chat ao vivo, portal de notícias e mensagens diretas entre usuários.

---

## Funcionalidades principais

- 💬 **Livechat** público com atualização em tempo real  
- 📰 **Portal de notícias** com atualizações sobre o jogo Fúria e seção de comentários  
- 📥 **Chats privados** entre usuários cadastrados  
- 🔒 **Sistema de autenticação** com cadastro e login de usuários  
- ⚙️ **Painel administrativo** para moderação de conteúdo *(em desenvolvimento)*  

---

## Tecnologias utilizadas

- **Frontend:** Vite.js/React  
- **Backend:** PHP  
- **Banco de dados:** MySQL  
- **Comunicação em tempo real:** WebSockets (ou long-polling)  
- **Servidor:** Docker (para ambiente de produção)  

---

## Instalação e execução

1. Clone o repositório:

    ```bash
    git clone https://github.com/C4103M/Furia-Chalenge.git
    ```

2. Configure o ambiente:
    - Edite o arquivo dentro da pasta config do Backend chamado conexao.php com as variáveis necessárias para conexão com o banco de dados;
    - Garanta que o Docker Desktop (no windows) esteja instalado
    - Suba o ambiente com Docker:
    - Garanta que todas as portas utilizadas estejam livres antes de subir os containers (ou altere as portas no arquivo docker-compose.yml)
    ```bash
    docker-compose up -d
    ```

3. Acesse o projeto:

    ```
    http://localhost:8083
    ```

---

## Testes

*Em desenvolvimento*  
Planejado para uso com:
- **PHPUnit** para backend  
- **Vitest** ou **Jest** para frontend  

---

## Contribuições

Quer contribuir? Siga os passos abaixo:

1. Faça um **fork** do projeto  
2. Crie uma branch: `git checkout -b minha-feature`  
3. Commit suas mudanças: `git commit -m 'feat: nova funcionalidade'`  
4. Push para o seu repositório: `git push origin minha-feature`  
5. Crie um **Pull Request**

---

## Licença

Este projeto está sob a licença **MIT**. Veja o arquivo `LICENSE` para mais informações.

---

## API

A API está toda documentada, leia `API` para mais informações.

---
## Contato

Para dúvidas ou sugestões, entre em contato:  
📧 [caioemanoel36@gmail.com]

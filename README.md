# Situação de Aprendizagem- SmartTrain

> Esta Situação de Aprendizagem foi desenvolvida durante o componente curricular nomeado Programação de Aplicativos. Como objetivo central de desenvolvimento do aplicativo SmartTrain, pode-se destacar a "dor" absorvida de gerenciadores de ferrovias de trens, através da necessidade de adicionar conceitos tecnológicos na efetivação das mesmas, buscando facilitar a conexão efetiva entre ferrovias, trens, gestores e usuários.



### Ajustes

O aplicativo nomeado SmartTrain deve atender algumas funcionalidades:
- [x] Adequação a Formatação escolhida;
- [x] Utilização de funcionalidades específicas;
- [x] Possibilidade de Modificação de Dados.

### Instalação

1.  **Clone o repositório:**

    ```bash
    git clone https://github.com/SA-SmartTrain/SA-SmartTrain.git
    cd SA-SmartTrain
    ```

2.  **Configuração do Banco de Dados:**

    *   Crie um banco de dados MySQL/MariaDB.
    *   Importe o script SQL localizado em `db/` para criar as tabelas necessárias.
    *   Edite o arquivo `config.php` (localizado na raiz do projeto) com as credenciais do seu banco de dados.

3.  **Configuração do Servidor Web:**

    *   Mova os arquivos do projeto para o diretório de documentos do seu servidor web (ex: `/var/www/html/` ou `htdocs/`).
    *   Certifique-se de que o servidor web está configurado para processar arquivos PHP.

4.  **Configuração dos Módulos Arduino (Opcional):**

    *   Abra os arquivos `.ino` na pasta `arduino/` com a Arduino IDE.
    *   Conecte seu módulo Arduino e carregue o código correspondente.
    *   Ajuste as configurações de comunicação (ex: porta serial, Wi-Fi) conforme necessário para interagir com o aplicativo.

### Execução

Após a instalação, acesse o aplicativo através do seu navegador web, navegando para o endereço onde o projeto foi configurado no seu servidor (ex: `http://localhost/SA-SmartTrain`).

## Arquitetura do Projeto (V1.0.0-beta)

```
SA-SmartTrain/
├── README.md
├───.vscode
├───arduino
├───controllers
├───db
├───mqtt
├───pages
├───public
│   ├───admin
│   ├───login
│   ├───templates
│   │   └───header-example
│   └───uploads
├───src
│   └───assets
│       ├───images
│       │   ├───readme
│       │   └───social-media
│       └───logo
├───style
└───uploads


```

## 🤝 Colaboradores

O Projeto foi desenvolvido inteiramente pelos estudantes descritos abaixo, que através de
aprofundamentos teóricos e práticos desenvolveram as necessárias competências para atender as demandas
necessárias:

<table>
  <tr>
    <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/beatrizcc.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/><br>
  <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/miguel.jpg" width="100px;" alt="Foto de Miguel Rocha Xavier"/><br>
    <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/iasmin.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/><br>
            <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/beatrizco.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/><br>
      



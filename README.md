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

## Arquitetura do Projeto (V0.9.0-beta)

```
SA-SmartTrain/
├── README.md
├── arduino
├── components
│   ├── CadastrarSensores.php
│   ├── ListarSensores.php
│   └── RemoverSensores.php
├── config.php
├── db
│   ├── Database.sql
│   ├── InsertColunaUsuarios.sql
│   └── conn.php
├── pages
│   └── index.html
├── public
│   ├── adiconar_sensores.php
│   ├── admin
│   │   ├── admin.php
│   │   └── visualizar_user.php
│   ├── alertas_e_notificacoes.html
│   ├── cadastro_de_cargas.html
│   ├── dashboard.html
│   ├── documentacoes.html
│   ├── editar_dados_perfil.php
│   ├── editar_meu_perfil_beta.php
│   ├── excluir_dados_perfil.php
│   ├── funcionarios.html
│   ├── gerenciamento_manutenção_trens.html
│   ├── gerenciamento_sensores.php
│   ├── gerenciamento_trens.html
│   ├── gestao_rotas.html
│   ├── login
│   │   ├── cadastre-se-page.php
│   │   ├── cadastro-se-dados.php
│   │   └── logout.php
│   ├── manutencao_trilho.html
│   ├── meu_perfil_beta.php
│   ├── monitoramento_cargas.html
│   ├── pagina_inicial.php
│   ├── relatorios_e_analises.html
│   ├── remover_sensores.php
│   ├── templates
│   │   ├── header-example
│   │   │   └── home-bar.html
│   │   └── header.php
│   └── uploads 
├── src
│   ├── api_clima_dashboard.js
│   ├── api_maps.js
│   ├── assets
│   │   ├── images
│   │   │   ├── adicionar.png
│   │   │   ├── alerta.png
│   │   │   ├── amarelo-listrar-gerenciamento.png
│   │   │   ├── dark_and_white-mode.png
│   │   │   ├── documentacao-sem-png.png
│   │   │   ├── estatistica.png
│   │   │   ├── estoque-bar.png
│   │   │   ├── funcionarios-bar.png
│   │   │   ├── grafico.jpg
│   │   │   ├── info.png
│   │   │   ├── inicio-bar.png
│   │   │   ├── key.png
│   │   │   ├── latalixo.png
│   │   │   ├── listar.png
│   │   │   ├── local-saida.png
│   │   │   ├── logo-sesisenai.png
│   │   │   ├── logo-smarttrain-apagada.png
│   │   │   ├── logo-smarttrain-semfundo.PNG
│   │   │   ├── logo-smarttrain.png
│   │   │   ├── lupa-monitoramento.png
│   │   │   ├── lupa.png
│   │   │   ├── menu-bar.png
│   │   │   ├── notifications.png
│   │   │   ├── password.png
│   │   │   ├── profile-login.png
│   │   │   ├── readme
│   │   │   │   ├── beatrizcc.jpg
│   │   │   │   ├── beatrizco.jpg
│   │   │   │   ├── iasmin.jpg
│   │   │   │   └── miguel.jpg
│   │   │   ├── relogio.png
│   │   │   ├── remover.png
│   │   │   ├── sair.png
│   │   │   ├── seta.png
│   │   │   ├── social-media
│   │   │   │   ├── facebook.png
│   │   │   │   ├── google.png
│   │   │   │   └── linkdin.png
│   │   │   ├── user.png
│   │   │   └── yellow.png
│   │   ├── logo
│   │   │   └── favicon.ico
│   │   └── tela_carregamento_waiting.js
│   ├── calendar.js
│   ├── login-admin.js
│   ├── logout.js
│   ├── template_notificacao.js
│   └── trocar_foto_meuperfil.js
├── style
│   ├── alertas_e_notificacoes.css
│   ├── cadastro_cargas.css
│   ├── cadastro_sensores.css
│   ├── configuracoes.css
│   ├── dashboard.css
│   ├── dashboard_calendar.css
│   ├── documentacoes.css
│   ├── funcionarios.css
│   ├── gerenciamento_manutenção_trens.css
│   ├── gerenciamento_sensores.css
│   ├── gerenciamento_trens.css
│   ├── gestao_rotas.css
│   ├── global.css
│   ├── index.css
│   ├── manutencao_trilho.css
│   ├── meu_perfil.css
│   ├── meu_perfil_beta.css
│   ├── meuperfil_func.css
│   ├── monitoramento_cargas.css
│   ├── pagina_inicial.css
│   └── relatorios_e_analises.css


```

## 🤝 Colaboradores

O Projeto foi desenvolvido inteiramente pelos estudantes descritos abaixo, que através de
aprofundamentos teóricos e práticos desenvolveram as necessárias competências para atender as demandas
necessárias:

<table>
  <tr>
    <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/beatrizcc.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/>Beatriz Cercal Cachoeira<br>
  <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/miguel.jpg" width="100px;" alt="Foto de Miguel Rocha Xavier"/>Miguel Rocha Xavier<br>
    <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/iasmin.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/>Iasmin Rabelo<br>
            <td align="center">
      <a href="#" title="Fotografia Pessoal">
        <img src="/src/assets/images/readme/beatrizco.jpg" width="100px;" alt="Foto de Beatriz Cercal Cachoeira"/>Beatriz Crispim de Oliveira<br>
      



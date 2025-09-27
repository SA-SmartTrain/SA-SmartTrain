                    <div class="container-menu-bar">
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741387947671582/inicio-bar.png?ex=68cf3961&is=68cde7e1&hm=c7185d30797b701fe8d859c923d089c36c4d1dc65f66c5ec33965ab8278edd6a&=&format=webp&quality=lossless" alt="">
                            <div id="incio">
                                <a href="../public/pagina_inicial.php"><span>Início</span></a>
                            </div>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741388589404220/menu-bar.png?ex=68cf3961&is=68cde7e1&hm=8ba9f963bf5c804e92aa79f8056e4d2c4804a2594df7ce9ba5863582be6258e6&=&format=webp&quality=lossless" alt="">
                            <a href="../public/documentacoes.html"><span>Menu</span></a>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <img src="https://media.discordapp.net/attachments/1418730196617396327/1418741388912361765/estoque-bar.png?ex=68cf3962&is=68cde7e2&hm=2f81ca0a243c1ba493fa2b154e76d3483cd3a2aee8b28787247a1d77eb169de1&=&format=webp&quality=lossless" alt="">
                            <a href="../public/relatorios_e_analises.html"><span>Estoque</span></a>
                        </div>
                        <div class="sections-menu-bar" id="press-effect">
                            <div id="funcionarios"><img src="https://media.discordapp.net/attachments/1418730196617396327/1418741387599548526/funcionarios-bar.png?ex=68cf3961&is=68cde7e1&hm=8129bcfc6bd85e81d312f7dfd7ff8ce81bd21d75925fcd2b0a43e9f594873ccd&=&format=webp&quality=lossless" alt=""></div>
                            <a href="../public/funcionarios.html"><span>Funcionários</span></a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>
</body>

<style>
    body {
        overflow-x: hidden;
        max-height: 700px;
    }

    .container-menu-bar {
        margin-top: 45%;
        display: flex;
        justify-content: center;
        width: 100vw;
        height: 60px;
        gap: 150px;
    }

    .sections-menu-bar {
        position: relative;
        left: 6px;
        width: 50px;
        height: 50px;
        margin-left: 10px;
        opacity: 0.3;
    }

    .sections-menu-bar span {
        position: relative;
        left: 5px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 600;
    }

    .sections-menu-bar a {
        text-decoration: none;
    }

    .container-menu-bar img {
        width: 100%;
    }

    #press-effect:hover {
        opacity: 1;
    }

    #notifications:hover {
        cursor: pointer;
    }

    @media(max-height: 866px) {

        .container-menu-bar {
            position: relative;
            top: 570px;
            right: 20px;
            gap: 45px;
        }
    }
</style>
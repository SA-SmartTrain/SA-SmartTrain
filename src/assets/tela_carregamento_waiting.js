function Loading_url_tela_incial_for_pagina_incial(url) {
    setTimeout(function () {
        window.location.href = url;
    }, 5000); // 5000 milissegundos = 5 segundos
}

Loading_url_tela_incial_for_pagina_incial("pagina_incial.html");


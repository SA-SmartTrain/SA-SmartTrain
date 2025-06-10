function loginAdmin() {
    const username = document.getElementById('username').value.trim().toLowerCase();

    if (username === 'admin') {
        alert('Bem-vindo à SmartTrain | Admin');
        window.location.href = '.../public/pagina_inicial.html';
    } else {
        alert('Bem-vindo à SmartTrain');
    }
}
 const apiKey = '61ca3412d583e361f978db0b6f10918e';
    const city = 'Joinville';

    async function getWeather() {
      try {
        const response = await fetch(
          `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`
        );
        const data = await response.json();

        document.getElementById('temp').innerText = `${Math.round(data.main.temp)}°`;
        document.getElementById('location').innerText = city;
        document.getElementById('date').innerText = new Date().toLocaleDateString('en-GB', {
          weekday: 'short', day: '2-digit', month: 'short'
        });

        document.getElementById('maxmin').innerText = `${Math.round(data.main.temp_max)}° / ${Math.round(data.main.temp_min)}°`;
        document.getElementById('feels').innerText = `${Math.round(data.main.feels_like)}°`;

        const iconCode = data.weather[0].icon;
        document.getElementById('icon').innerHTML = `<img src="https://openweathermap.org/img/wn/${iconCode}@2x.png" alt="icon" width="60"/>`;
      } catch (error) {
        document.getElementById('weather-card').innerText = 'Erro ao carregar o tempo.';
        console.error('Erro na API:', error);
      }
    }

    getWeather();
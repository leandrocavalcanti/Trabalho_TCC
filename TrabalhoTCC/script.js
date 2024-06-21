document.addEventListener('DOMContentLoaded', function () {
    const display = document.getElementById('timer');
    let intervalId;
    let timer = 0;

    function startTimer(duration) {
        timer = duration;
        intervalId = setInterval(function () {
            const minutes = parseInt(timer / 60, 10);
            const seconds = parseInt(timer % 60, 10);
            const displayMinutes = minutes < 10 ? '0' + minutes : minutes;
            const displaySeconds = seconds < 10 ? '0' + seconds : seconds;
            display.textContent = displayMinutes + ':' + displaySeconds;
            
            if (--timer < 0) {
                clearInterval(intervalId);
                timer = duration;
            }
        }, 1000);
    }

    document.getElementById('start').addEventListener('click', function () {
        if (!intervalId) {
            const inputTempo = document.getElementById('tempo');
            const tempoInSeconds = parseInt(inputTempo.value, 10);
            const duration = tempoInSeconds * 60 || 0; // Verifica se o valor é um número válido
            startTimer(duration);
        }
    });

    document.getElementById('stop').addEventListener('click', function () {
        clearInterval(intervalId);
        intervalId = null;
        timer = 0;
        display.textContent = '00:00';
    });
});

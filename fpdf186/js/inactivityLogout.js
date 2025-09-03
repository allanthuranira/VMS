window.addEventListener('load', () => {
    let timeout;

    function logout() {
        window.location.href = 'adminLogin.html';
    }

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(logout, 600000); // 10 minutes
    }

    ['load', 'mousemove', 'mousedown', 'touchstart', 'click', 'keypress'].forEach(event => {
        window.addEventListener(event, resetTimer);
    });

    resetTimer();
});

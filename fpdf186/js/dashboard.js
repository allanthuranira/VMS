document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('selectedDate');
    if (dateInput) {
        dateInput.addEventListener('change', function () {
            document.getElementById('dateForm').submit();
        });
    }
});

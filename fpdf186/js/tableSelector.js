window.addEventListener('DOMContentLoaded', function () {
    const selector = document.getElementById('tableSelector');
    if (!selector) return;

    selector.addEventListener('change', function () {
        const selected = selector.value;
        document.querySelectorAll('.table').forEach(tbl => {
            tbl.style.display = 'none';
        });
        if (selected) {
            const selectedTable = document.getElementById(selected);
            if (selectedTable) selectedTable.style.display = 'block';
        }
    });
});
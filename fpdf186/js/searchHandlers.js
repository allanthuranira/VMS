window.addEventListener('load', () => {
    const searchConfigs = [
        ['searchTermVehicle', 'vehicleDataTable', 1],
        ['searchTermGeneral', 'generalDataTable', 0],
        ['searchTermStaff', 'staffDataTable', 1],
        ['searchTermParticipant', 'participantDataTable', 1],
        ['searchTermVisitor', 'visitorDataTable', 1],
        ['searchTermKSGVehicle', 'ksgVehicleDataTable', 0],
    ];

    searchConfigs.forEach(([inputId, tableId, columnIndex]) => {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);
            rows.forEach(row => {
                const text = row.cells[columnIndex].textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
});

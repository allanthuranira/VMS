// Handles all download buttons
window.addEventListener('load', function () {
    function downloadPDF(contentId, filename) {
        const { jsPDF } = window.jspdf;
        const content = document.getElementById(contentId);
        html2canvas(content).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save(filename);
        });
    }

    function downloadImage(contentId, filename) {
        const content = document.getElementById(contentId);
        html2canvas(content).then(canvas => {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = filename;
            link.click();
        });
    }

    function downloadCSV(contentId, filename) {
        const content = document.getElementById(contentId);
        const table = content.querySelector('table');
        const rows = table.querySelectorAll('tr');
        let csvContent = '';
        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            let rowContent = '';
            cols.forEach(col => {
                rowContent += `"${col.textContent.trim().replace(/"/g, '""')}",`;
            });
            csvContent += rowContent.slice(0, -1) + '\n';
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.href = url;
        link.setAttribute('download', filename);
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Hook buttons
    const downloadMappings = [
        ['downloadVehiclePDF', () => downloadPDF('content', 'Car_Number_plates.pdf')],
        ['downloadVehicleImage', () => downloadImage('content', 'Car_Number_plates.png')],
        ['downloadGeneralPDF', () => downloadPDF('contentGeneral', 'General_Registration_Details.pdf')],
        ['downloadGeneralExcel', () => downloadCSV('contentGeneral', 'General_Registration_Details.csv')],
        ['downloadStaffPDF', () => downloadPDF('contentStaff', 'Staff_Details.pdf')],
        ['downloadStaffExcel', () => downloadCSV('contentStaff', 'Staff_Details.csv')],
        ['downloadParticipantPDF', () => downloadPDF('contentParticipant', 'Participants_Details.pdf')],
        ['downloadParticipantExcel', () => downloadCSV('contentParticipant', 'Participants_Details.csv')],
        ['downloadVisitorPDF', () => downloadPDF('contentVisitor', 'Visitors_Details.pdf')],
        ['downloadVisitorExcel', () => downloadCSV('contentVisitor', 'Visitors_Details.csv')],
        ['downloadKSGVehiclesPDF', () => downloadPDF('contentKSGVehicles', 'KSG_Vehicles_Check_IN_Details.pdf')],
        ['downloadKSGVehiclesExcel', () => downloadCSV('contentKSGVehicles', 'KSG_Vehicles_Check_IN_Details.csv')],
    ];

    downloadMappings.forEach(([id, handler]) => {
        const btn = document.getElementById(id);
        if (btn) btn.onclick = handler;
    });
});

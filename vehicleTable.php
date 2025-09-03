
<!DOCTYPE html>
<html lang="en">
<body>

<!-- In your <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Before </body> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    var table = $('#vehicleDataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "fetch_vehicle_data.php",
            type: "POST",
            data: function (d) {
                d.campus = $('#campusSelect').val(); // attach dropdown value
            }
        },
        pageLength: 50,
        lengthChange: false,
        searching: true,
        order: [[0, 'desc']],
        columns: [
            { data: "arrivalDateTime" },
            { data: "motorNumber" },
            { data: "fullName" },
            { data: "phoneNumber" },
            { data: "ksgStaffOrParticipantOrVisitor" },
            { data: "campus", title: "Campus" }
        ]
    });

  
    // ✅ optional: live search for number plate
    $('#searchTermVehicle').on('keyup', function () {
        table.search(this.value).draw();
    });
});
</script>

<!-- Vehicle Details Table -->
       
            <h2>Vehicle Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermVehicle" placeholder="Search by Number Plate">
                </div>
            </div>

            <div id="content">
                <table id="vehicleDataTable">
                    <thead>
                        <tr>
                            <th>Time and Date of Arrival</th>
                            <th>Number Plate</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Type of Visitor</th>
                            <th>Campus</th>                            
                        </tr>
                    </thead>
                    <tbody>
                  
                        
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadVehiclePDF">Download as PDF</button>
                <button class="download-button" id="downloadVehicleImage">Download as Image</button>
            </div>
      

</body>
</html>

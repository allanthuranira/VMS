    <!-- KSG Vehicle Check IN Details Table -->
 <!-- In your <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Before </body> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <script>
    $(document).ready(function () {
        $('#ksgVehicleDataTable').DataTable({
            paging: true,           // Enables pagination
            pageLength: 50,         // Rows per page
            lengthChange: false,    // Option to change rows per page
            searching: true         // Keep search box if needed
        });
    });
</script>
            <h2>KSG Vehicles Movement Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermKSGVehicle" placeholder="Search by Number Plate">
                </div>
            </div>
            <div id="contentKSGVehicles">
                <table id="ksgVehicleDataTable">
                    <thead>
                    <tr>
                        <th>Number Plate</th>
                        <th>Driver Name</th>
                        <th>Check OUT Date & Time</th>
                        <th>Check IN Date & Time</th>
                        <th>Authorized BY:</th>
                        <th>Campus</th>                        
                    </tr>
                    </thead>
                    
                    <tbody>
                    <?php while($row = $ksgvehicle_checkInResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['car_number_plate']; ?></td>
                                <td><?php echo $row['driver_name']; ?></td>                                
                                <td>
                                    <?php 
                                    if (!empty($row['check_out_datetime'])) {
                                        $dt = new DateTime($row['check_out_datetime']);
                                        echo $dt->format('F j, Y, g:i A'); 
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if (!empty($row['check_in_datetime'])) {
                                        $dt = new DateTime($row['check_in_datetime']);
                                        echo $dt->format('F j, Y, g:i A'); 
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['authorized_by']; ?></td>
                                <td><?php echo $row['campus']; ?></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadKSGVehiclesPDF">Download as PDF</button>
                <button class="download-button" id="downloadKSGVehiclesExcel">Download as Excel</button>
            </div>

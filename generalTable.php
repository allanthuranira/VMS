 <!-- General Registration Details Table -->
  
<!-- In your <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Before </body> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <script>
    $(document).ready(function () {
        $('#generalDataTable').DataTable({
            paging: true,           // Enables pagination
            pageLength: 50,         // Rows per page
            lengthChange: false,    // Option to change rows per page
            searching: true         // Keep search box if needed
        });
    });
</script>

            <h2>General Registration Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermGeneral" placeholder="Search by ID Number">
                </div>
            </div>

            <div id="contentGeneral">
                <table id="generalDataTable">
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Registration Date & Time</th>
                            <th>Did the Guest come Driving</th>
                            <th>Number Plate</th>
                            <th>KSG Staff or Partcipant or Visitor</th>
                            <th>Campus</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $generalResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['idNumber']; ?></td>
                            <td><?php echo $row['fullName']; ?></td>
                            <td><?php echo $row['phoneNumber']; ?></td>
                            <td>
                                <?php 
                                if (!empty($row['arrivalDateTime'])) {
                                    $dt = new DateTime($row['arrivalDateTime']);
                                    echo $dt->format('F j, Y, g:i A'); 
                                }
                                ?>
                            </td>
                            <td><?php echo $row['MeansQuestion']; ?></td>
                            <td><?php echo $row['motorNumber']; ?></td>
                            <td><?php echo $row['ksgStaffOrParticipantOrVisitor']; ?></td>
                            <td><?php echo $row['campus']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="button-container">
                <button class="download-button" id="downloadGeneralPDF">Download as PDF</button>
                <button class="download-button" id="downloadGeneralExcel">Download as Excel</button>
            </div>
   
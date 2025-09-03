<!-- Visitor's Details Table -->
   <!-- In your <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Before </body> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <script>
    $(document).ready(function () {
        $('#visitorDataTable').DataTable({
            paging: true,           // Enables pagination
            pageLength: 50,         // Rows per page
            lengthChange: false,    // Option to change rows per page
            searching: true         // Keep search box if needed
        });
    });
</script>
            <h2>Visitor's Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermVisitor" placeholder="Search by ID Number">
                </div>
            </div>
            <div id="contentVisitor">
                <table id="visitorDataTable">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>ID Number</th>
                        <th>Arrival Date & Time</th>
                        <th>Office Visiting</th>
                        <th>Officer Name</th>
                        <th>Visitor Purpose</th>
                        <th>Campus</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $visitorResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['fullName']; ?></td>
                                <td><?php echo $row['idNumber']; ?></td>
                                <td>
                                    <?php 
                                    if (!empty($row['arrivalDateTime'])) {
                                        $dt = new DateTime($row['arrivalDateTime']);
                                        echo $dt->format('F j, Y, g:i A'); 
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['officeVisiting']; ?></td>
                                <td><?php echo $row['officerName']; ?></td>
                                <td><?php echo $row['visitorPurpose']; ?></td>
                                <td><?php echo $row['campus']; ?></td>
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadVisitorPDF">Download as PDF</button>
                <button class="download-button" id="downloadVisitorExcel">Download as Excel</button>
            </div>
    
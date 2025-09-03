 <!-- staffTable -->
  <!-- In your <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- Before </body> -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

 <script>
    $(document).ready(function () {
        $('#staffDataTable').DataTable({
            paging: true,           // Enables pagination
            pageLength: 50,         // Rows per page
            lengthChange: false,    // Option to change rows per page
            searching: true         // Keep search box if needed
        });
    });
</script>

       
            <h2>KSG Staff Details</h2>
            <div class="search-container">
                <div class="search-form">
                    <input type="text" id="searchTermStaff" placeholder="Search by ID Number">
                </div>
            </div>
            <div id="contentStaff">
                <table id="staffDataTable">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Personal Number/ID Number</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php while($row = $staffResult->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['fullName']; ?></td>
                                <td><?php echo $row['idNumber']; ?></td>
                                
                                
                            </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="button-container">
                <button class="download-button" id="downloadStaffPDF">Download as PDF</button>
                <button class="download-button" id="downloadStaffExcel">Download as Excel</button>
            </div>
        
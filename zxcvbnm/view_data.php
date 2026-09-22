<?php
include_once("header.php");
include_once '../config.php';
include_once '../classes/securityHelper.php';
$db = new Database();
$conn = $db->getConnection();
// Sanitize and validate ID to prevent SQL injection and ModSecurity issues
$id = SecurityHelper::sanitizeId($_GET['id'] ?? null);
if (!$id) {
  die("Invalid employee ID");
}
// Use prepared statement for security
$stmt = $conn->prepare("SELECT * FROM forms WHERE eid=? AND formno != '' ORDER BY id DESC");
if ($stmt) {
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $res = $stmt->get_result();
} else {
  die("Database error");
}
?>
<style>
    html.js.js body div.wrapper div.structure-row div.right-sec div.content-section div.container-liquid div.row div.col-xs-12 div.sec-box div.contents div.table-box form table.table tbody tr td.col-md-8 div.input-group-btn select.btn.btn-default.dropdown-toggle {
        width: 200px;
    }

    html.js.js body div.wrapper div.structure-row div.right-sec div.content-section div.container-liquid div.row div.col-xs-12 div.sec-box div.contents div.table-box form table.table tbody tr td input.btn.btn-primary.style2 {
        margin: 0px 0px;
    }
</style>
<div class="content-section">
    <div class="container-liquid">
        <div class="row">
            <div class="col-xs-12">
                <div class="sec-box">
                    <header>
                        <h2 class="heading"> User forms</h2>
                    </header>
                    <div class="contents">
                        <div class="table-box">
                        </div>
                        <div class="clearfix"></div>

                        <tr>
                            <td>
                                <h2>Data List:</a></h2>
                            </td>
                        </tr>
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                                <tr>
                                    <th>Form No</th>

                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($res)) {
                                ?>
                                    <tr>
                                        <td><?= $row['formno']; ?></td>
                                        <td><?= $row['invoice_no']; ?></td>
                                        <td><?= $row['demoDate']; ?></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!-- Row End -->
    </div>
</div>
<!-- Content Section End -->
</div>
<!-- Right Section End -->
</div>
</div>
</body>

</html>
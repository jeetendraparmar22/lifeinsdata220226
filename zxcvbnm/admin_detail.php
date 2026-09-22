<?php
include_once("header.php");
?>
<style>
  /* General button styles */
  .btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.2s ease;
    text-align: center;
  }

  /* Edit button styles */
  .edit-btn {
    background-color: #4CAF50;
    /* Green */
  }

  .edit-btn:hover {
    background-color: #45a049;
    transform: scale(1.05);
  }

  /* Delete button styles */
  .delete-btn {
    background-color: #f44336;
    /* Red */
  }

  .delete-btn:hover {
    background-color: #e53935;
    transform: scale(1.05);
  }

  .status-btn.active {
    background-color: #4CAF50;
    /* Green for Active */
    border: 1px solid #3e8e41;
  }

  /* Deactive button styles */
  .status-btn.deactive {
    background-color: #f44336;
    /* Red for Deactive */
    border: 1px solid #d32f2f;
  }
</style>

<div class="contents">
  <div class="table-box">
    <script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
    <table class="display table" id="example">
      <thead>
        <tr>
          <th>Admin Username</th>
          <th>Admin Password</th>
          <th>Active Date</th>
          <th>Deactive Date</th>
          <th>Active Time</th>
          <th>Deactive Time</th>
          <th>Number Of User</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $selectadmin = mysqli_query($conn, "SELECT *FROM `subadmin` ORDER BY id DESC");
        while ($row = mysqli_fetch_array($selectadmin)) {
        ?>
          <tr class="gradeX">
            <td><?php echo $row['adminusername']; ?></td>
            <td><?php echo $row['adminpassword']; ?></td>
            <td class="center"><?php echo $row['active_date']; ?></td>
            <td class="center"><?php echo $row['deactive_date']; ?></td>
            <td class="center"><?php echo $row['active_time']; ?></td>
            <td class="center"><?php echo $row['deactive_time']; ?> </td>
            <td class="center"><?php echo $row['no_of_user']; ?></td>
            <td class="center">
              <?php if ($row['status'] === 'y') : ?>
                <a class="btn status-btn active">Active</a>
              <?php else : ?>
                <a class="btn status-btn deactive">Deactive</a>
              <?php endif; ?>
            </td>

            <td><a href="update_admin.php?update=<?php echo $row['0']; ?> " class="btn edit-btn">Edit</a></td>
            <td><a href="delete.php?del=<?php echo $row['0']; ?>" class="btn delete-btn">Delete</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <div class="clearfix"></div>
</div>
</body>

</html>
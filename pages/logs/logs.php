<!DOCTYPE html>
<html>

<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../../login.php");
} else {
  ob_start();
  include('../head_css.php'); ?>

  <body class="skin-black">
    <?php include "../connection.php" ?>
    <?php include('../header.php') ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
      <?php include('../sidebar-left.php') ?>
      <aside class="right-side">
        <section class="content-header">
          <h1>Staff Logs</h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="box">
              <div class="box-header">
                <div style="padding:10px;">
                </div>
              </div>
              <div class="box-body table-responsive">
                <form method="post">
                  <table id="table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $squery = mysqli_query($con, "select * from tbllogs order by logdate desc");
                      while ($row = mysqli_fetch_array($squery)) {
                        echo '
                          <tr>
                            <td>' . $row['user'] . '</td>
                            <td>' . $row['logdate'] . '</td>
                            <td>' . $row['action'] . '</td>
                          </tr>
                        ';
                      } ?>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </div>
        </section>
      </aside>
    </div>
  <?php }
include "../footer.php"; ?>
  <script type="text/javascript">
    $(function () {
      $("#table").dataTable({
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }], "aaSorting": []
      });
    });
  </script>
</body>

</html>
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
          <h1>Barangay Officials</h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="box">
              <div class="box-header">
                <div style="padding:10px;">
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal"><i
                      class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;ADD BRGY OFFICIALS</button>
                  <?php
                  if (!isset($_SESSION['staff'])) {
                    ?>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i
                        class="fa fa-trash-o" aria-hidden="true"></i> &nbsp;REMOVE</button>
                    <?php
                  } ?>
                </div>
              </div>
              <div class="box-body table-responsive">
                <form method="post">
                  <table id="table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <?php
                        if (!isset($_SESSION['staff'])) {
                          ?>
                          <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain"
                              onchange="checkMain(this)" /></th>
                          <?php
                        } ?>
                        <th>POSITION</th>
                        <th>NAME</th>
                        <th>CONTACT</th>
                        <th>ADDRESS</th>
                        <th>START OF TERM</th>
                        <th>END OF TERM</th>
                        <th style="width: 130px !important;">OPTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!isset($_SESSION['staff'])) {
                        $squery = mysqli_query($con, "select * from tblofficial ");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                              <td>' . $row['sPosition'] . '</td>
                              <td>' . $row['completeName'] . '</td>
                              <td>' . $row['pcontact'] . '</td>
                              <td>' . $row['paddress'] . '</td>
                              <td>' . $row['termStart'] . '</td>
                              <td>' . $row['termEnd'] . '</td>
                              <td style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                              <button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> EDIT</button>';
                          if ($row['status'] == 'Ongoing Term') {
                            echo '<button class="btn btn-danger btn-sm" data-target="#endModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-minus-circle " aria-hidden="true"></i> END</button>';
                          } else {
                            echo '<button class="btn btn-success btn-sm" data-target="#startModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-minus-circle " aria-hidden="true"></i> START</button>';
                          }
                          echo '</td>
                            </tr>
                          ';
                          include "edit_modal.php";
                          include "endterm_modal.php";
                          include "startterm_modal.php";
                        }
                      } else {
                        $squery = mysqli_query($con, "select * from tblofficial where status = 'Ongoing Term' group by termend");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td>' . $row['sPosition'] . '</td>
                              <td>' . $row['completeName'] . '</td>
                              <td>' . $row['pcontact'] . '</td>
                              <td>' . $row['paddress'] . '</td>
                              <td>' . $row['termStart'] . '</td>
                              <td>' . $row['termEnd'] . '</td>
                              <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></td>
                            </tr>
                          ';
                          include "edit_modal.php";
                        }
                      } ?>
                    </tbody>
                  </table>
                  <?php include "../deleteModal.php"; ?>
                </form>
              </div>
            </div>
            <?php include "../duplicate_error.php"; ?>
            <?php include "../edit_notif.php"; ?>
            <?php include "../added_notif.php"; ?>
            <?php include "../delete_notif.php"; ?>
            <?php include "add_modal.php"; ?>
            <?php include "function.php"; ?>
          </div>
        </section>
      </aside>
    </div>
  <?php }
include "../footer.php"; ?>
  <script type="text/javascript">
    <?php
    if (!isset($_SESSION['staff'])) {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 7] }], "aaSorting": []
        });
      });
      <?php
    } else {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [6] }], "aaSorting": []
        });
      });
      <?php
    } ?>
  </script>
</body>

</html>
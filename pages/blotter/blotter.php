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
    <?php
    include "../connection.php";
    ?>
    <?php include('../header.php'); ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
      <?php include('../sidebar-left.php'); ?>
      <aside class="right-side">
        <section class="content-header">
          <h1>
            Blotter
          </h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="box">
              <div class="box-header">
                <div style="padding:10px;">
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i
                      class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;ADD BLOTTER</button>
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
                              onchange="checkMain(this)" />
                          </th>
                          <?php
                        } ?>
                        <th>DATE RECORDED</th>
                        <th>COMPLAINANT</th>
                        <th>PERSON TO COMPLAIN</th>
                        <th>COMPLAINT</th>
                        <th>ACTION TAKEN</th>
                        <th>STATUS</th>
                        <th>LOCATION OF INCIDENCE</th>
                        <th style="width: 40px !important;">OPTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if (!isset($_SESSION['staff'])) {
                        $squery = mysqli_query($con, "SELECT *,r.id as rid,b.id as bid,CONCAT(r.lname,', ', r.fname, ' ', r.mname) as rname from tblblotter b left join tblresident r on b.personToComplain = r.id ") or die('Error: ' . mysqli_error($con));
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['bid'] . '" /></td>
                              <td>' . $row['dateRecorded'] . '</td>
                              <td>' . $row['complainant'] . '</td>
                              <td>' . $row['rname'] . '</td>
                              <td>' . $row['complaint'] . '</td>
                              <td>' . $row['actionTaken'] . '</td>
                              <td>' . $row['sStatus'] . '</td>
                              <td>' . $row['locationOfIncidence'] . '</td>
                              <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['bid'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;EDIT</button></td>
                            </tr>
                          ';
                          include "edit_modal.php";
                        }
                      } else {
                        $squery = mysqli_query($con, "SELECT *,r.id as rid,b.id as bid,CONCAT(r.lname,', ', r.fname, ' ', r.mname) as rname from tblblotter b left join tblresident r on b.personToComplain = r.id ") or die('Error: ' . mysqli_error($con));
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td>' . $row['dateRecorded'] . '</td>
                              <td>' . $row['complainant'] . '</td>
                              <td>' . $row['rname'] . '</td>
                              <td>' . $row['complaint'] . '</td>
                              <td>' . $row['actionTaken'] . '</td>
                              <td>' . $row['sStatus'] . '</td>
                              <td>' . $row['locationOfIncidence'] . '</td>
                              <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['bid'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></td>
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
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 8] }], "aaSorting": []
        });
        $(".select2").select2();
      });
      <?php
    } else {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [7] }], "aaSorting": []
        });
        $(".select2").select2();
      });
      <?php
    } ?>
  </script>
</body>

</html>
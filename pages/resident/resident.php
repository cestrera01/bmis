<!DOCTYPE html>
<html>

<?php
session_start();
if (!isset($_SESSION['role'])) {
  header("Location: ../../login.php");
} else {
  ob_start();
  include('../head_css.php'); ?>
  <style>
    .input-size {
      width: 418px;
    }
  </style>

  <body class="skin-black">
    <?php include "../connection.php" ?>
    <?php include('../header.php') ?>
    <div class="wrapper row-offcanvas row-offcanvas-left">
      <?php include('../sidebar-left.php') ?>
      <aside class="right-side">
        <section class="content-header">
          <h1>Resident</h1>
        </section>
        <?php
        if (!isset($_GET['resident'])) {
          ?>
          <section class="content">
            <div class="row">
              <div class="box">
                <div class="box-header">
                  <div style="padding:10px;">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal"><i
                        class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;ADD RESIDENT</button>
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
                  <form method="post" enctype="multipart/form-data">
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
                          <th>PUROK</th>
                          <th>IMAGE</th>
                          <th>NAME</th>
                          <th>AGE</th>
                          <th>GENDER</th>
                          <th>FORMER ADDRESS</th>
                          <th style="width: 40px !important;">OPTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (!isset($_SESSION['staff'])) {
                          $squery = mysqli_query($con, "SELECT purok,id,CONCAT(lname, ', ', fname, ' ', mname) as cname, age, gender, formerAddress, image FROM tblresident order by purok");
                          while ($row = mysqli_fetch_array($squery)) {
                            echo '
                              <tr>
                                <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                                <td>' . $row['purok'] . '</td>
                                <td style="width:70px;"><image src="image/' . basename($row['image']) . '" style="width:60px;height:60px;"/></td>
                                <td>' . $row['cname'] . '</td>
                                <td>' . $row['age'] . '</td>
                                <td>' . $row['gender'] . '</td>
                                <td>' . $row['formerAddress'] . '</td>
                                <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;EDIT</button></td>
                              </tr>
                            ';
                            include "edit_modal.php";
                          }
                        } else {
                          $squery = mysqli_query($con, "SELECT purok,id,CONCAT(lname, ', ', fname, ' ', mname) as cname, age, gender, formerAddress, image FROM tblresident order by purok");
                          while ($row = mysqli_fetch_array($squery)) {
                            echo '
                              <tr>
                                <td>' . $row['purok'] . '</td>
                                <td style="width:70px;"><image src="image/' . basename($row['image']) . '" style="width:60px;height:60px;"/></td>
                                <td>' . $row['cname'] . '</td>
                                <td>' . $row['age'] . '</td>
                                <td>' . $row['gender'] . '</td>
                                <td>' . $row['formerAddress'] . '</td>
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
              <?php include "../edit_notif.php"; ?>
              <?php include "../added_notif.php"; ?>
              <?php include "../delete_notif.php"; ?>
              <?php include "../duplicate_error.php"; ?>
              <?php include "add_modal.php"; ?>
              <?php include "function.php"; ?>
            </div>
          </section>
          <?php
        } else {
          ?>
          <section class="content">
            <div class="row">
              <div class="box">
                <div class="box-body table-responsive">
                  <form method="post" enctype="multipart/form-data">
                    <table id="table" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain"
                              onchange="checkMain(this)" />
                          </th>
                          <th>Image</th>
                          <th>Name</th>
                          <th>Age</th>
                          <th>Gender</th>
                          <th>Former Address</th>
                          <th style="width: 40px !important;">Option</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $squery = mysqli_query($con, "SELECT id,CONCAT(lname, ', ', fname, ' ', mname) as cname, age, gender, formerAddress, image FROM tblresident where householdnum = '" . $_GET['resident'] . "'");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                              <td style="width:70px;"><image src="image/' . basename($row['image']) . '" style="width:60px;height:60px;"/></td>
                              <td>' . $row['cname'] . '</td>
                              <td>' . $row['age'] . '</td>
                              <td>' . $row['gender'] . '</td>
                              <td>' . $row['formerAddress'] . '</td>
                              <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></td>
                            </tr>
                          ';
                          include "edit_modal.php";
                        } ?>
                      </tbody>
                    </table>
                    <?php include "../deleteModal.php"; ?>
                    <?php include "../duplicate_error.php"; ?>
                  </form>
                </div>
              </div>
            </div>
          </section>
          <?php
        } ?>
      </aside>
    </div>
  <?php }
include "../footer.php"; ?>
  <script type="text/javascript">
    $(function () {
      $("#table").dataTable({
        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 6] }], "aaSorting": []
      });
    });
  </script>
</body>

</html>
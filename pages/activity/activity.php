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
          <h1>Activity</h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="box">
              <div class="box-header">
                <div style="padding:10px;">
                  <?php
                  if (!isset($_SESSION['resident'])) {
                    ?>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i
                        class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;ADD ACTIVITY</button>
                    <?php
                    if (!isset($_SESSION['staff'])) {
                      ?>
                      <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i
                          class="fa fa-trash-o" aria-hidden="true"></i> &nbsp;REMOVE</button>
                      <?php
                    }
                  } ?>
                </div>
              </div>
              <div class="box-body table-responsive">
                <form method="post">
                  <table id="table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <?php
                        if ((!isset($_SESSION['staff'])) && (!isset($_SESSION['resident']))) {
                          ?>
                          <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain"
                              onchange="checkMain(this)" />
                          </th>
                          <?php
                        } ?>
                        <th>DATE OF ACTIVITY</th>
                        <th>ACTIVITY</th>
                        <th>DESCRIPTION</th>
                        <th style="width: 140px !important;">OPTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($_SESSION['role'] == "Administrator") {
                        $squery = mysqli_query($con, "select * from tblactivity");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                              <td>' . $row['dateofactivity'] . '</td>
                              <td>' . $row['activity'] . '</td>
                              <td>' . $row['description'] . '</td>
                              <td style="display: flex; align-items: center; justify-content: center; gap: 8px">
                                <button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> &nbsp;EDIT</button>
                                <button class="btn btn-primary btn-sm" data-target="#viewModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;PHOTO</button>
                              </td>
                            </tr>
                          ';
                          include "edit_modal.php";
                          include "view_modal.php";
                        }
                      } elseif (isset($_SESSION['resident'])) {
                        $squery = mysqli_query($con, "select * from tblactivity");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td>' . $row['dateofactivity'] . '</td>
                              <td>' . $row['activity'] . '</td>
                              <td>' . $row['description'] . '</td>
                              <td><button class="btn btn-primary btn-sm" data-target="#viewModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-search" aria-hidden="true"></i> Photo</button></td>
                            </tr>
                          ';
                          include "view_modal.php";
                        }
                      } else {
                        $squery = mysqli_query($con, "select * from tblactivity");
                        while ($row = mysqli_fetch_array($squery)) {
                          echo '
                            <tr>
                              <td>' . $row['dateofactivity'] . '</td>
                              <td>' . $row['activity'] . '</td>
                              <td>' . $row['description'] . '</td>
                              <td>
                                <button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
                                <button class="btn btn-primary btn-sm" data-target="#viewModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-search" aria-hidden="true"></i> Photo</button>
                              </td>
                            </tr>
                          ';
                          include "edit_modal.php";
                          include "view_modal.php";
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
      </aside>
    </div>
  <?php }
include "../footer.php"; ?>
  <script type="text/javascript">
    var select_all = document.getElementById("cbxMainphoto"); // select all checkbox
    var checkboxes = document.getElementsByClassName("chk_deletephoto"); // checkbox items

    // select all checkboxes
    select_all.addEventListener("change", function (e) {
      for (i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = select_all.checked;
      }
    });

    for (var i = 0; i < checkboxes.length; i++) {
      checkboxes[i].addEventListener('change', function (e) { // checkbox change
        // uncheck select all if one of the listed checkbox item is unchecked
        if (this.checked == false) {
          select_all.checked = false;
        }
        // check select all if all checkbox items are checked
        if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
          select_all.checked = true;
        }
      });
    }

    <?php
    if ($_SESSION['role'] == "Administrator") {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 4] }], "aaSorting": []
        });
        $(".select2").select2();
      });
      <?php
    } elseif (isset($_SESSION['resident'])) {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false }], "aaSorting": []
        });
        $(".select2").select2();
      });
      <?php
    } else {
      ?>
      $(function () {
        $("#table").dataTable({
          "aoColumnDefs": [{ "bSortable": false, "aTargets": [4] }], "aaSorting": []
        });
        $(".select2").select2();
      });
      <?php
    } ?>
  </script>
</body>

</html>
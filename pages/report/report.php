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
          <h1>Reports</h1>
        </section>
        <section class="content">
          <div class="row">
            <div class="box">
              <div class="box-header">
                <div style="padding:10px;">
                  <form action="export.php" method="post">
                    <button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-excel-o"
                        aria-hidden="true"></i> &nbsp;EXPORT</button>
                  </form>
                </div>
              </div>
              <div class="box-body table-responsive">
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Resident Income Level
                      </div>
                      <div class="panel-body">
                        <div id="morris-bar-chart4"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Resident Educational Attainment
                      </div>
                      <div class="panel-body">
                        <div id="morris-donut-chart"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Population per Purok
                      </div>
                      <div class="panel-body">
                        <div id="morris-bar-chart3"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        Age
                      </div>
                      <div class="panel-body">
                        <div id="morris-bar-chart2"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </aside>
    </div>
  <?php }
include "../footer.php";
include "donut-chart.php";
include "bar-chart.php"; ?>
</body>

</html>
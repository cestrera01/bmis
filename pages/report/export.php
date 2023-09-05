<?php
if (isset($_POST['export'])) {

  include "connection.php";

  $SQL1 = "SELECT count(*) as NumberofResident, round(monthlyincome,-1) as Income FROM tblresident group by monthlyincome";
  $SQL2 = "SELECT count(*) as NumberofResident,purok FROM tblresident r group by r.purok";
  $SQL3 = "SELECT COUNT( * ) as NumberofResident , Age FROM tblresident GROUP BY age";
  $SQL4 = "SELECT count(*) as NumberofResident,HighestEducationalAttainment from tblresident group by highesteducationalattainment";

  $arrsql = array($SQL1, $SQL2, $SQL3, $SQL4);
  $arrhead = array("Resident Income Level", "Population per Purok", "Age", "Resident Educational Attainment");
  foreach (array_combine($arrsql, $arrhead) as $value => $headers) {

    $header = "$headers\n";
    $result = '';
    $exportData = mysqli_query($con, $value) or die("Sql error : " . mysqli_error($con));
    $fields = mysqli_num_fields($exportData);

    for ($i = 0; $i < $fields; $i++) {
      $header .= mysqli_fetch_field_direct($exportData, $i)->name . "\t";
    }

    while ($row = mysqli_fetch_row($exportData)) {
      $line = '';
      foreach ($row as $value) {
        if ((!isset($value)) || ($value == "")) {
          $value = "\t";
        } else {
          $value = str_replace('"', '""', $value);
          $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
      }
      $result .= trim($line) . "\n";
    }

    $result = str_replace("\r", "", $result);

    if ($result == "") {
      $result = "\nNo Record(s) Found!\n";
    }

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=export.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$result\n\n";
  }
} ?>
<?php
$lastip = array();

            $sql = "SELECT ip, Country FROM scanned ORDER BY timestamp DESC";
            $result = mysqli_query($con, $sql) or die (mysqli_error($con));

            if (mysqli_num_rows($result) == 0)
            {}
            else
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    array_push($lastip, array("0"=> $row['Country'],"1"=> $row['ip']));
                    
                }
            }
            
echo'<div>';
echo '<!--Table-->
<table id="tablePreview" class="table table-dark table-striped table-hover table-sm">
<!--Table head-->
  <thead>
    <tr>
      <th>IP</th>
	  <th>Country</th>
    </tr>
  </thead>
  <!--Table head-->';
	
    // Cycle through the array
    for($i=0; $i<sizeof($iparr); $i++){
        echo "<tr>";
        echo "<td>". $lastip[$i]['0']."</td>";
        echo "<td>". $lastip[$i]['1']."</td>";
        echo "</tr>";
    }

    // Close the table
echo "</table>";
echo"</div>";
?>
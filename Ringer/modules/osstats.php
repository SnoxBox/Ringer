<?php
$osarr = array();
            $sql = "SELECT COUNT(os) as oscnt, os FROM scanned GROUP BY os ORDER BY COUNT(os) DESC";
            $result = mysqli_query($con, $sql) or die (mysqli_error($con));

            if (mysqli_num_rows($result) == 0)
            {}
            else
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    array_push($osarr, array("0"=> $row['os'],"1"=> $row['oscnt']));        
                }
            }
?>
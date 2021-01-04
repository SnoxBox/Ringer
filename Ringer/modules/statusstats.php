<?php
$statarr = array();
            $sql = "SELECT COUNT(status) as statcnt, status FROM scanned GROUP BY status ORDER BY COUNT(status) DESC";
            $result = mysqli_query($con, $sql) or die (mysqli_error($con));

            if (mysqli_num_rows($result) == 0)
            {}
            else
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    array_push($statarr, array("0"=> $row['status'],"1"=> $row['statcnt']));        
                }
            }
?>
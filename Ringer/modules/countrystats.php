<?php

function isotoname(string $ccode) {
$codes = array_flip(json_decode(file_get_contents('http://country.io/iso3.json'), true));
$names = json_decode(file_get_contents('http://country.io/names.json'), true);
$cname= $codes[$ccode];
return $names[$cname];
}


$iparr = array();

            $sql = "SELECT ROW_NUMBER() OVER (ORDER BY id) AS IRow, COUNT(id) as cnt, Country, City FROM scanned GROUP BY Country ORDER BY COUNT(id) DESC ";
            $result = mysqli_query($con, $sql) or die (mysqli_error($con));

            if (mysqli_num_rows($result) == 0)
            {}
            else
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    array_push($iparr, array("index"=> $row['IRow'],"0"=> $row['Country'],"1"=> $row['cnt'],"2"=> $row['City']));
                    
                }
            }
            
echo'<div class="col-md-2 tables">';
echo '<!--Table-->
<table id="tablePreview" class="table table-dark table-striped table-hover table-sm">
<!--Table head-->
  <thead>
      <tr>
          <th>#</th>
          <th>Country</th>
          <th>Count</th>
      </tr>
  </thead>
  <!--Table body--><tbody>';
  


//   echo "<tr>";
//   echo "<td>". isotoname($iparr[$i]['0'])."</td>";
//   echo "<td>". $iparr[$i]['1']."</td>";
//   echo "</tr>";

    // Cycle through the array
    for($i=0; $i<sizeof($iparr); $i++){
        $sid='s'.$iparr[$i]['index'];
        echo "<tr>
        <td style='width:25px; text-align: center;'>
          <div class='sidbutton' id='$sid' style='display:inline;width:25px' onclick=display_detail(".$iparr[$i]['index'].")>+</div>
        </td>
        <td>".$iparr[$i]['0']."</td>
        <td>".$iparr[$i]['1']."</td>
        <td></td>
      </tr>";
    echo "<tr class='child ".$sid."child'>
              <td>&nbsp;</td>
              <td><b>City</b> : ".$iparr[$i]['2']."</td>
              <td><b>Count</b>: ".$iparr[$i]['1']."</td>
        </tr>";

    }
echo "</tbody></table>";
echo"</div>";

?>



<script language="JavaScript">
function display_detail(id){  

  var sid='s'+id;
  var sidbuttons = document.getElementsByClassName('sidbutton');
  for(i = 0; i < sidbuttons.length; i++) {
    if(sidbuttons[i].id == sid){
      if(sidbuttons[i].classList.contains('bopen')){
        sidbuttons[i].innerHTML = '+';
        sidbuttons[i].classList.remove('bopen');
      }else{
        sidbuttons[i].innerHTML = '-';
        sidbuttons[i].classList.add('bopen');    
      }      
    }else{
      if(!sidbuttons[i].classList.contains('bopen'))
        sidbuttons[i].innerHTML = '+';      
    }
  }

  var childrows = document.getElementsByClassName('child');
  for(i = 0; i < childrows.length; i++) {
    if(childrows[i].classList.contains(sid+'child')){
      if( childrows[i].classList.contains('copen') ){
        childrows[i].style.display = 'none';
        childrows[i].classList.remove('copen');
      }
      else{
        childrows[i].style.display = 'table-row';
        childrows[i].classList.add('copen'); 
      }
    }else{
      if(!childrows[i].classList.contains('copen'))  
        childrows[i].style.display = 'none';      
    }  
  }  

}
</script>
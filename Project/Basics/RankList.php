<?php
$result="";
$percentage="";
$dept="";
$fname="";
$lname="";
$gender="";
$rn="";
$grade="";
if(isset($_POST['btn_submit']))
{
	$fname=$_POST['txt_fname'];
	$lname=$_POST['txt_lname'];
	$rn=$_POST['txt_rn'];
	$gender=$_POST['rad_gender'];
	$dept=$_POST['txt_d'];
	$m1=$_POST['txt_m1'];
	$m2=$_POST['txt_m2'];
	$m3=$_POST['txt_m3'];
	$result=$m1+$m2+$m3;
	$percentage=(($m1+$m2+$m3)/300)*100;
	if($percentage>=80)
	{
		$grade='A';
	}
	else if($percentage>=60)
	{
		$grade='B';
	}
	else if($percentage>=40)
	{
		$grade='C';
	}
	else
	{
		$grade='FAILED';
	}
}




?>








<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td>First Name</td>
      <td><label for="txt_fname"></label>
      <input type="text" name="txt_fname" id="txt_fname" /></td>
    </tr>
    <tr>
      <td>Last Name</td>
      <td><label for="txt_lname"></label>
      <input type="text" name="txt_lname" id="txt_lname" /></td>
    </tr>
    <tr>
      <td>Roll No</td>
      <td><label for="txt_rn"></label>
      <input type="text" name="txt_rn" id="txt_rn" /></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td><input type="radio" name="rad_gender" id="rad_gender" value="Male" />Male
      <label for="txt_m">
        <input type="radio" name="rad_gender" id="rad_gender" value="Female" />Female
      </label></td>
    </tr>
    <tr>
      <td>Department</td>
      <td><label for="txt_d"></label>
        <select name="txt_d" id="txt_d">
          <option>--Select--</option>
          <option>BCA</option>
          <option>BBA</option>
        </select></td>
    </tr>
    <tr>
      <td>Mark 1</td>
      <td><label for="txt_m1"></label>
      <input type="text" name="txt_m1" id="txt_m1" /></td>
    </tr>
    <tr>
      <td>Mark 2</td>
      <td><label for="txt_m2"></label>
      <input type="text" name="txt_m2" id="txt_m2" /></td>
    </tr>
    <tr>
      <td>Mark 3</td>
      <td><label for="txt_m3"></label>
      <input type="text" name="txt_m3" id="txt_m3" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
      </div></td>
    </tr>
    <tr>
      <td>Full Name </td>
      <td><?php echo $fname." ".$lname?></td>
    </tr>
    <tr>
      <td>Roll No</td>
      <td><?php echo $rn?></td>
    </tr>
    <tr>
      <td>Gender</td>
      <td><?php echo $gender?></td>
    </tr>
    <tr>
      <td>Department</td>
      <td><?php echo $dept?></td>
    </tr>
    <tr>
      <td>Total Mark</td>
      <td><?php echo $result?></td>
    </tr>
    <tr>
      <td>Percentage</td>
      <td><?php echo $percentage?></td>
    </tr>
    <tr>
      <td>Grade</td>
      <td><?php echo $grade?></td>
    </tr>
  </table>
</form>

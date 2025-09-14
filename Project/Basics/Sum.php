<?php
$result="";
if(isset($_POST['btn_sum']))
{
	$num1=$_POST['txt_num1'];
	$num2=$_POST['txt_num2'];
	$result=$num1+$num2;
	
}

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="200" border="1">
    <tr>
      <td>Number 1</td>
      <td><label for="txt_num1"></label>
      <input type="text" name="txt_num1" id="txt_num1" /></td>
    </tr>
    <tr>
      <td>Number 2</td>
      <td><label for="txt_num2"></label>
      <input type="text" name="txt_num2" id="txt_num2" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn_sum" id="btn_sum" value="Sum" />
      </div></td>
    </tr>
    <tr>
      <td>Result</td>
      <td><?php echo $result?></td>
    </tr>
  </table>
</form>
</body>
</html>
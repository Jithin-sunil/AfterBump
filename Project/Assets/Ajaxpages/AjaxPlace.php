<?php
include("../Connection/Connection.php");
?>
<option>Select Place</option>
<?php
$sel="select * from tbl_place where district_id='".$_GET['did']."'";
$res=$Con->query($sel);
while($data=$res->fetch_assoc())
{
	?>
    <option value="<?php echo $data['place_id'];?>"><?php echo $data['place_name'] ?></option>
    <?php
}
?>
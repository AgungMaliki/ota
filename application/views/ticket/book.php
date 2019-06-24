<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />

</head>
<body>

<?php echo form_open('booking/booked');?>

<div class="container">
    <div class="row">
        <div class="card" style="margin:0 auto;">
            <div class="card-body">
                <table>
                    <tr><td>Fullname</td><td><?php echo form_input('name');?></td></tr>
                    <tr><td>Date of birth</td><td><?php echo form_input('dob');?></td></tr> 
                    <tr><td>Email</td><td><?php echo form_input('email');?></td></tr>       
                    <tr><td colspan="2">
                    <input type = "hidden" name = "id" value = "<?php echo $detail[0]->id; ?>" /> 
                        <?php echo form_submit('submit','Book');?>
                        </td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 

    echo form_close();

?>
</body>
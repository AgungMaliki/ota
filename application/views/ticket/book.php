<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<!-- Bootstrap core CSS-->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />

</head>
<body>

<form action="<?php echo base_url(). 'booking/booked'; ?>" method="post">
		<table style="margin:20px auto;">
			<tr>
				<td>Fullname</td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>Date of birth</td>
				<td><input type="text" name="dob"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td></td>
                <input type = "hidden" name = "id" value = "<?php echo $detail[0]->id; ?>" />
				<td><input type="submit" value="Tambah"></td>
			</tr>
		</table>
	</form>	
</body>
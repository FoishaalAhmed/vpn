<?php include('includes/config.php'); ?>

	<?php
		$username = $_SESSION['user'];
		$sql_query = "SELECT Password, Email
				FROM tbl_user
				WHERE username = ?";

		// create array variable to store previous data
		$data = array();

		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $username);
			// Execute query
			$stmt->execute();
			// store result
			$stmt->store_result();
			$stmt->bind_result($data['Password'], $data['Email']);
			$stmt->fetch();
			$stmt->close();
		}

		$previous_password = $data['Password'];
		$previous_email = $data['Email'];

		if(isset($_POST['btnChange'])){
			$email = $_POST['email'];
			$old_pass = $_POST['old_password'];
			$new_pass= $_POST['new_password'];
			$conf_pass= $_POST['confirm_password'];
			
			// create array variable to handle error
			$error = array();
			$update_result = false;
			// check password
			if(!empty($old_pass) && !empty($new_pass) && !empty($conf_pass)){
				if(!empty($old_pass)){
					$old_password = hash('sha256',$username.$old_pass);
					$new_password = hash('sha256',$username.$new_pass);
					$confirm_password = hash('sha256',$username.$conf_pass);
					$new_e_password = hash('sha256',$email.$new_pass);
					if($old_password == $previous_password){
						if(!empty($_POST['new_password']) || !empty($_POST['confirm_password'])){
							if($new_password == $confirm_password){
								// update password in user table
								$sql_query = "UPDATE tbl_user
										SET password = ?, e_password = ?
										WHERE username = ?";

								$stmt = $connect->stmt_init();
								if($stmt->prepare($sql_query)) {
									// Bind your variables to replace the ?s
									$stmt->bind_param('sss',
												$new_password,
												$new_e_password,
												$username);
									// Execute query
									$stmt->execute();
									// store result
									$update_result = $stmt->store_result();
									$stmt->close();
								}
							}else{
								$error['confirm_password'] = " <span class='label red-text'>New password don't match!</span>";
							}
						}else{
							$error['confirm_password'] = " <span class='label red-text'>Please insert your new password and re new password!</span>";
						}
					}else{
						$error['old_password'] = " <span class='label red-text'>Your old password is wrong!</span>";
					}
				}else{
					$error['old_password'] = " <span class='label red-text'>Please insert your old password!</span>";
				}
				
				if(empty($email)){
					$error['email'] = " <span class='label red-text'>Please insert your email!</span>";
				}else{
					$valid_mail = "/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i";
					if (!preg_match($valid_mail, $email)){
						$error['email'] = " <span class='label red-text'>your email format false!</span>";
						$email = "";
					}else{
						// update password in user table
						$sql_query = "UPDATE tbl_user
								SET Email = ?
								WHERE Username = ?";

						$stmt = $connect->stmt_init();
						if($stmt->prepare($sql_query)) {
							// Bind your variables to replace the ?s
							$stmt->bind_param('ss',
										$email,
										$username);
							// Execute query
							$stmt->execute();
							// store result
							$update_result = $stmt->store_result();
							$stmt->close();
						}
					}
				}
			}  
		
			// check update result
			if($update_result){
				//$to = $email;
				//$subject = $email_subject;
				//$message = $change_message;
				//$from = $admin_email;
				//$headers = 'From:' . $from;
				//mail($to,$subject,$message,$headers);
				$error['update_user'] = "<div class='card-panel green lighten-4'>
											<span class='green-text text-darken-2'>
												User updated successfully.
											</span>
										</div>";
			}else{
				$error['update_user'] = "<div class='card-panel red lighten-4'>
										<span class='red-text text-darken-2'>
											Required parameter is missing! 
										</span>
									</div>";
			}
		}

		$sql_query = "SELECT email FROM tbl_user WHERE username = ?";

		$stmt = $connect->stmt_init();
		if($stmt->prepare($sql_query)) {
			// Bind your variables to replace the ?s
			$stmt->bind_param('s', $username);
			// Execute query
			$stmt->execute();
			// store result
			$stmt->store_result();
			$stmt->bind_result($previous_email);
			$stmt->fetch();
			$stmt->close();
		}
	?>

<!-- START CONTENT -->
<section id="content">

	<!--breadcrumbs start-->
	<div id="breadcrumbs-wrapper" class=" grey lighten-3">
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					<h5 class="breadcrumbs-title">My Profile</h5>
					<ol class="breadcrumb">
						<li><a href="dashboard.php" class="deep-orange-text">Dashboard</a>
						</li>
						<li><a class="active">My Profile</a>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!--breadcrumbs end-->

		<!--start container-->
	<div class="container">
		<div class="section">
			<div class="card-panel borderTop">
				<div class="row">
					<form method="post" class="col s12"  id="form-validation">
						<div class="row">
							<div class="input-field col s12">
								<?php echo isset($error['update_user']) ? $error['update_user'] : '';?>

								<div class="row">
									<div class="input-field col s12">
									<input type="text" name="username" id="username" value="<?php echo $username; ?>" readonly/>
									<label for="username">Username</label>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
									<input type="text" name="email" id="email" value="<?php echo $previous_email; ?>" />
									<label for="email">Email</label><?php echo isset($error['email']) ? $error['email'] : '';?>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
									<input type="password" name="old_password" id="old_password" value="" />
									<label for="old_password">Old Password</label><?php echo isset($error['old_password']) ? $error['old_password'] : '';?>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
									<input type="password" name="new_password" id="new_password" value="" />
									<label for="new_password">New Password</label><?php echo isset($error['new_password']) ? $error['new_password'] : '';?>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12">
									<input type="password" name="confirm_password" id="confirm_password" value="" />
									<label for="confirm_password">Re Type New Password</label><?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '';?>
									</div>
								</div>

								<div class="row">
									<div class="input-field col s12 m12 l12">
										<button class="btn deep-orange waves-effect waves-light" type="submit" name="btnChange">Update
											<i class="mdi-content-send right"></i>
										</button>
									</div>
								</div>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

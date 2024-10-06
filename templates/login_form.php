<?php

	include_once('includes/config.php');
	// create array variable to handle error
	$error = array();
	// start session
	//session_start();

	// if user click Login button
	if(isset($_POST['btnLogin'])){

		// get username and password
		$username = $_POST['username'];
		$password = $_POST['password'];

		// set time for session timeout
		$currentTime = time() + 25200;
		$expired = 3600;

		// check whether $username is empty or not
		if(empty($username)){
			$error['username'] = MSG_USERNAME_EMPTY;
		}

		// check whether $password is empty or not
		if(empty($password)){
			$error['password'] = MSG_PASSWORD_EMTPY;
		}

		// if username and password is not empty, check in database
		if(!empty($username) && !empty($password)){

			// change username to lowercase
			$username = strtolower($username);

			//encript password to sha256
		    $password = hash('sha256',$username.$password);

			// get data from user table
			$sql_query = "SELECT id, username, password, email, user_role, device_type, active, createdAt, updatedAt 
						FROM tbl_user WHERE user_role='100' and active=1 AND ((username = ? AND password = ?) OR (email = ? AND e_password= ?)) ";
			
			$stmt = $connect->stmt_init();
			if($stmt->prepare($sql_query)) {
				// Bind your variables to replace the ?s
				$stmt->bind_param('ssss', $username, $password, $username, $password);
				// Execute query
				$stmt->execute();
				/* store result */
				$stmt->store_result();
				$data = array();
				$stmt->bind_result($data['id'],
						$data['username'],
						$data['password'],
						$data['email'],
						$data['user_role'],
						$data['device_type'],
						$data['active'],
						$data['createdAt'],
						$data['updatedAt']
						);
				$num = $stmt->num_rows;
				$stmt->fetch();
				// Close statement object
				$stmt->close();
				if($num == 1){
					
					//echo $data['id'];
					$_SESSION['users'] = $data;
					//$_SESSION['user'] = $username;
					$_SESSION['user'] = $data['username'];
					$_SESSION['timeout'] = $currentTime + $expired;
					header("location: dashboard.php");
				}else{
					$error['failed'] = MSG_INVALID_USER_PASS;
				}
			}

		}
	}
	?>

<body>

  <div id="login-page" class="row">
	  <div class="row"></div>
    <div class="col s12 z-depth-3 card-panel borderTopMore">

     <form class="login-form" method="post">
        <div class="row">
          <div class="input-field col s12 center">
            <img src="assets/images/icon.png" width="100px" height="100px">
            <p class="center login-form-text"><?php echo APP_NAME; ?></p>
          </div>
        </div>
        <div style="color:#F44336;" class="center">
			<?php echo $error ? '<div class="card-panel red lighten-4" role="alert"><span class="red-text text-darken-2">'. implode('<br>', $error) . '</span></div>' : '';?>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person prefix active"></i>
            <input name="username" id="username" type="text" value="admin" required>
            <label for="username" class="active center-align">Username</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock prefix active"></i>
            <input name="password" id="password"  value="admin" type="password" required>
            <label for="password" class="active center-align">Password</label>
          </div>
        </div>
		<div class="row"></div>
        <div class="row">
          <div class="input-field col s12">
            <button class="btn deep-orange waves-effect waves-light col s12" type="submit" name="btnLogin">Login</button>
          </div>
        </div>

		<div class="row"></div>
      </form>
    </div>
  </div>
	
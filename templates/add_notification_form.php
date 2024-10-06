<?php include_once('functions.php'); ?>

<?php
if(isset($_POST['btnAdd'])){
    $message = $_POST['message'];
    $title = $_POST['title'];

    // get image info
    $menu_image = $_FILES['image']['name'];
    $image_error = $_FILES['image']['error'];
    $image_type = $_FILES['image']['type'];

    // create array variable to handle error
    $error = array();

    if(empty($message)){
        $error['message'] = " <span class='label red-text'>Must Insert!</span>";
    }
    if(empty($title)){
        $error['title'] = " <span class='label red-text'>Must Insert!</span>";
    }

    // common image file extensions
    $allowedExts = array("gif", "jpeg", "jpg", "png");

    // get image file extension
    error_reporting(E_ERROR | E_PARSE);
    $extension = end(explode(".", $_FILES["image"]["name"]));

     if($image_error > 0) {
     	$error['image'] = " <span class='label red-text'>You're not insert images!!</span>";
     } else if(!(($image_type == "image/gif") ||
     	($image_type == "image/jpeg") ||
     	($image_type == "image/jpg") ||
     	($image_type == "image/x-png") ||
     	($image_type == "image/png") ||
     	($image_type == "image/pjpeg")) &&
     	!(in_array($extension, $allowedExts))) {
     	    $error['image'] = " <span class='label red-text'>Image type must jpg, jpeg, gif, or png!</span>";
     }

    if(!empty($message) && !empty($title)) {

        $date = date('Y-m-d H:i:s', time());
        if(!empty($menu_image)) {
            // create random image file name
            $string = '0123456789';
            $file = preg_replace("/\s+/", "_", $_FILES['image']['name']);
            $function = new functions;
            $menu_image = $function->get_random_string($string, 4)."-".date("Y-m-d").".".$extension;

            // upload new image
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_NOTIFICATION . $menu_image);

            // insert new data to menu table
            $sql_query = "INSERT INTO tbl_notification (title, message, image, createdAt, updatedAt)
							VALUES(?, ?, ?, ?, ?)";

            $upload_image = $menu_image;
            $stmt = $connect->stmt_init();
            if($stmt->prepare($sql_query)) {
                // Bind your variables to replace the ?s
                $stmt->bind_param('sssss',
                        $title,
                        $message,
                        $upload_image,
                        $date,
                        $date
                );
                // Execute query
                $stmt->execute();
                // store result
                $result = $stmt->store_result();
                $stmt->close();
            }

        } else {
            // insert new data to menu table
            $sql_query = "INSERT INTO tbl_notification (title, message, createdAt, updatedAt) VALUES (?, ?, ?, ?)";

            $stmt = $connect->stmt_init();
            if($stmt->prepare($sql_query)) {
                // Bind your variables to replace the ?s
                $stmt->bind_param('ssss', $title, $message, $date, $date);
                // Execute query
                $stmt->execute();
                // store result
                $result = $stmt->store_result();
                $stmt->close();
            }
        }

        if($result) {
            $error['error_data'] = "<div class='card-panel green lighten-4'>
                                        <span class='green-text text-darken-2'>
                                            Push notification template added successfully.
                                        </span>
                                    </div>";
        } else {
            $error['error_data'] = "<div class='card-panel red lighten-4'>
                                        <span class='red-text text-darken-2'>
                                            Oops, Something goes wrong.
                                        </span>
                                    </div>";
        }
    }

}

?>

<!-- START CONTENT -->
<section id="content">

    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Add New Notification</h5>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php" class="deep-orange-text">Dashboard</a></li>
                        <li><a href="notification.php" class="deep-orange-text">Push Notification</a></li>
                        <li><a class="active">Add New Notification</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs end-->

    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card-panel borderTop">
                        <div class="row">
                            <form method="post" class="col s12" id="form-validation" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <?php echo isset($error['error_data']) ? $error['error_data'] : '';?>

                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="title" id="title" required/>
                                                <label for="title">Title</label><?php echo isset($error['title']) ? $error['title'] : '';?>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="message" id="message" required/>
                                                <label for="message">Message</label><?php //echo isset($error['message']) ? $error['message'] : '';?>
                                            </div>
                                        </div>
                                        -->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="message" id="message" class="materialize-textarea" required></textarea>
                                                <label for="message">Message</label><?php echo isset($error['message']) ? $error['message'] : '';?>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="file" name="image" id="image" id="image" class="dropify-notification"
                                                data-max-file-size="1M" data-allowed-file-extensions="jpg png gif" />
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12 m12 l5">
                                                <button class="btn deep-orange waves-effect waves-light"
                                                        type="submit" name="btnAdd">Submit
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
        </div>
    </div>
</section>

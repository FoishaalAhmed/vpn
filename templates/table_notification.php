<?php
include('includes/config.php');

// Retrieve OneSignal app ID and REST key from the database
$query = "SELECT onesignal_app_id, onesignal_rest_key FROM tbl_settings";
$result = mysqli_query($connect, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Retrieve OneSignal app ID and REST key from the database
    $onesignal_app_id = $row['onesignal_app_id'];
    $onesignal_rest_key = $row['onesignal_rest_key'];

    if (isset($_POST['btnAdd'])) {

        // Check if an image URL is provided
        if (!empty($_POST['image_url'])) {
            $imageFilePath = $_POST['image_url'];
        } elseif ($_FILES['image']['name'] != "") {
            // Upload image if not using URL
            $imageFileName = rand(0, 99999) . "_" . $_FILES['image']['name'];
            $imagePath = 'upload/notification' . $imageFileName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);

            if (isset($_SERVER['HTTPS'])) {
                $imageFilePath = 'https://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/' . $imagePath;
            } else {
                $imageFilePath = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/' . $imagePath;
            }
        } else {
            $imageFilePath = ''; // No image provided
        }

        $content = array(
            "en" => $_POST['message']
        );

        $fields = array(
            'app_id' => $onesignal_app_id,
            'included_segments' => array('All'),
            'data' => array(
                "foo" => "bar",
                "title" => $_POST['title'],
                "message" => $_POST['message'],
                "image" => $imageFilePath
            ),
            'headings' => array("en" => $_POST['title']),
            'contents' => $content,
            'big_picture' => $imageFilePath
        );

        $fields = json_encode($fields);

        // Debugging
        echo "Fields: " . htmlspecialchars($fields) . "<br>";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $onesignal_rest_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);

        // Error handling
        if ($response === false) {
            echo "Curl error: " . curl_error($ch);
        } else {
            // Process the response
            echo "Response: " . htmlspecialchars($response) . "<br>";
        }

        curl_close($ch);

        $_SESSION['msg'] = "16";
        $_SESSION['class'] = "success";
        header("Location: notification.php");
        exit;
    }
} else {
    // Handle the case where the query fails
    echo "Error in fetching OneSignal settings from the database.";
}
?>


<!-- START CONTENT -->
<section id="content">

    <!--breadcrumbs start-->
    <div id="breadcrumbs-wrapper" class=" grey lighten-3">
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Push Notification</h5>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php" class="deep-orange-text">Dashboard</a></li>
                        <li><a href="notification.php" class="deep-orange-text">Push Notification</a></li>
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
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="message" id="message" class="materialize-textarea" required></textarea>
                                                <label for="message">Message</label><?php echo isset($error['message']) ? $error['message'] : '';?>
                                            </div>
                                        </div>
                                        
                                        <!-- Add Image URL input field -->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="text" name="image_url" id="image_url"/>
                                                <label for="image_url">Image URL</label>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="file" name="image" id="image" class="dropify-notification"
                                                data-max-file-size="1M" data-allowed-file-extensions="jpg png gif" />
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="input-field col s12 m12 l5">
                                                <button class="btn deep-orange waves-effect waves-light"
                                                        type="submit" name="btnAdd">Send
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

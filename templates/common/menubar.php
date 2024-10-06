<?php include 'includes/config.php' ?>
<?php require_once 'roles.php'; ?>
<?php include_once('header.php'); ?>


<!-- START MAIN -->
<div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

        <!-- START LEFT SIDEBAR NAV-->
        <aside id="left-sidebar-nav">
            <ul id="slide-out" class="side-nav fixed leftside-navigation">
                <li class="user-details deep-orange-g" style="padding-left:0px;">
                    <div>
                        <center>
                            <img src="assets/images/icon.png" class="z-depth-0" width="100px" height="100px">
                        </center>
                    </div>
                </li>
                <li class="bold <?php echo $selectedMenu == "dashboard" ? 'active' : "";?>">
                    <a href="dashboard.php" class="waves-effect waves ahover <?php echo $selectedMenu == "dashboard" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-action-dashboard" dir="rtl"></i>Dashboard
                    </a>
                </li>

                <li class="bold <?php echo $selectedMenu == "addserver" ? 'active' : "";?>">
                    <a href="add_server.php" class="waves-effect waves ahover <?php echo $selectedMenu == "addserver" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-content-add-circle"></i>Add Server
                    </a>
                </li>

                <li class="bold <?php echo $selectedMenu == "freeserver" ? 'active' : "";?>">
                    <a href="freeservers.php" class="waves-effect waves ahover <?php echo $selectedMenu == "freeserver" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-social-public"></i>Free Servers
                    </a>
                </li>

                <li class="bold <?php echo $selectedMenu == "paidserver" ? 'active' : "";?>">
                    <a href="paidservers.php" class="waves-effect waves ahover <?php echo $selectedMenu == "paidserver" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-action-verified-user"></i>Paid Servers
                    </a>
                </li>

                <li class="bold <?php echo $selectedMenu == "notification" ? 'active' : "";?>">
                    <a href="notification.php" class="waves-effect waves ahover <?php echo $selectedMenu == "notification" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-social-notifications"></i>Push Notification
                    </a>
                </li>
<!--			
                <li class="bold <?php //echo $selectedMenu == "users" ? 'active' : "";?>">
                    <a href="users.php" class="waves-effect waves ahover <?php //echo $selectedMenu == "users" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-social-people"></i>Users
                    </a>
                </li>
-->
                <li class="bold <?php echo $selectedMenu == "setting" ? 'active' : "";?>">
                    <a href="settings.php" class="waves-effect waves ahover <?php echo $selectedMenu == "setting" ? 'deep-orange-text' : "";?>">
                        <i class="mdi-action-settings"></i>Settings
                    </a>
                </li>


                <li class="bold">
                    <a href="#modalLogout" class="waves-effect waves-light ahover modal-trigger mb-2 mr-1">
                        <i class="mdi-action-exit-to-app"></i>Logout
                    </a>
                </li>

            </ul>
            
            <a href="#" data-activates="slide-out"
               class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i
                    class="mdi-navigation-menu"></i></a>
        </aside>
        <!-- END LEFT SIDEBAR NAV-->

        <!-- //////////////////////////////////////////////////////////////////////////// -->
        <div id="api-key" class="modal modal-fixed-footer">

            <div class="modal-content">
                <h5>Where I have to put my API Key?</h5>
                <hr>
                <ol>
                    <li>For security needed, Update <b>onesignal_rest_key</b> String value.</li>
                    <li>Open Android Studio Project.</li>
                    <li>Click <b>CHANGE API KEY</b> to generate new API Key.</li>
                    <li>Go to Android app > <b>build.gradle</b>, and update with your own API Key. <img src="assets/images/onesignal_rest_key.png" width="640px" height="313px"></li>
                </ol>
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-red btn-flat modal-action modal-close">OK, I am Understand</a>
            </div>

        </div>

        <div id="server-key" class="modal modal-fixed-footer">

            <div class="modal-content">
                <h5>Obtaining your Firebase Server API Key</h5>
                <hr>
                <p>Firebase provides Server API Key to identify your firebase app. To obtain your Server API Key, go to firebase console, select the project and go to settings, select Cloud Messaging tab and copy Onesignal App Id.</p>
                <img src="assets/images/fcm-server-key.jpg" >
            </div>
            <div class="modal-footer">
                <a class="waves-effect waves-red btn-flat modal-action modal-close">OK, I am Understand</a>
            </div>

        </div>

        <div id="modalLogout" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Logout</h5>
                </div>
                <div class="modal-body">
                    <p>Do you want to logout?</p>
                </div>
            </div>
            <div class="modal-footer modal-fixed-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">No</a>
                <a href="logout.php" class="modal-action modal-close waves-effect waves-green btn-flat ">Yes</a>
            </div>
        </div>

<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("slide-out");
var btns = header.getElementsByClassName("bold");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
	//alert('Clicked: ' + current);
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
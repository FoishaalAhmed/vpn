<?php
	include_once('functions.php');
?>

<?php
  $function = new functions;

  //Total Channel List count
  $sql_query = "SELECT * FROM tbl_servers";
  $total_channels = mysqli_query($connect, $sql_query);
  $total_channels =  mysqli_num_rows($total_channels);

  //Total Free Servers
  $sql_query = "SELECT * FROM tbl_servers where isPaid='0'";
  $total_free = mysqli_query($connect, $sql_query);
  $total_free =  mysqli_num_rows($total_free);
  
  //Total Paid Servers
  $sql_query = "SELECT * FROM tbl_servers where isPaid='1'";
  $total_paid = mysqli_query($connect, $sql_query);
  $total_paid =  mysqli_num_rows($total_paid);

?>

<!--start container-->
<div class="container">
    <div class="section">
        <!--card stats start-->
        <div id="card-stats" class="seaction">
            <div class="row">
                <div class="col s12 m6 l3 waves-effect waves-light">
                    <a href="freeservers.php">
                        <div class="card hoverable">
                            <div class="card-content white-text deep-orange-g">
                            <br>
								<i class="mdi-action-dns small"></i>
                                <p class="card-stats-title">TOTAL SERVERS</p>
                                <h4 class="card-stats-number"><?php echo $total_channels;?></h4>
                            <br>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col s12 m6 l3 waves-effect waves-light">
                    <a href="freeservers.php">
                        <div class="card hoverable">
                            <div class="card-content white-text deep-orange-g">
                            <br/>
								<i class="mdi-social-public small"></i>
                                <p class="card-stats-title">FREE SERVERS</p>
                                <h4 class="card-stats-number"><?php echo $total_free;?></h4>
                            <br/>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col s12 m6 l3 waves-effect waves-light">
                    <a href="paidservers.php">
                        <div class="card hoverable">
                            <div class="card-content white-text deep-orange-g">
                            <br/>
                                <i class="mdi-action-verified-user small"></i>
                                <p class="card-stats-title">PAID SERVERS</p>
                                <p class="card-stats-number"><?php echo $total_paid;?></p>
                            <br/>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col s12 m6 l3 waves-effect waves-light">
                    <a href="settings.php">
                        <div class="card hoverable">
                            <div class="card-content white-text deep-orange-g">
                            <br>
                            <i class="mdi-action-settings small"></i>
                                <p class="card-stats-title">SETTINGS</p>
                                <h4 class="card-stats-number">1</h4>
                            <br>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <!-- row completed -->
        </div>
        <!--card stats end-->
    </div>
    
    <section id="chart">
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel borderTop">
                    <div id="chart-container" style="display: flex; align-items: center; justify-content: center;">
                        <canvas id="donutCanvas" height="400"></canvas>
                    </div>
                </div>
            </div>                    
        </div>
        <div class="row">
            <div class="col s12 m12 l12">
                <div class="card-panel borderTop">
                    <div id="chart-container" style="display: flex; align-items: center; justify-content: center;">
                        <canvas id="donutCanvasTwo" height="400"></canvas>
                    </div>
                </div>
            </div>                    
        </div>
    </section>

</div> 

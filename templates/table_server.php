<?php
include_once('functions.php');
if ($selectedMenu == 'freeserver') {
	$vpnType = TYPE_FREE;
	$server = FREE;
} else {
	$vpnType = TYPE_PAID;
	$server = PAID;
}
$function = new functions;
$sql_query = "SELECT * FROM tbl_servers WHERE isPaid = '$vpnType' ORDER BY id DESC";
$result = mysqli_query($connect, $sql_query);
?>

<!-- START CONTENT -->
<section id="content">

	<!--breadcrumbs start-->
	<div id="breadcrumbs-wrapper" class=" grey lighten-3">
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					<h5 class="breadcrumbs-title"><?php echo $server; ?></h5>
					<ol class="breadcrumb">
						<li><a href="dashboard.php" class="deep-orange-text">Dashboard</a></li>
						<li><a class="active"><?php echo $server; ?></a></li>
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
				<div class="col s6 m6 l6">
					<form method="post" action="add_server.php" class="col s12" id="form-validation">
						<input type="hidden" value="<?php echo $vpnType; ?>" id="vpnType" name="vpnType" />
						<button class="btn deep-orange waves-effect waves-light left" type="submit" name="btnEdit" id="btnEdit">Add New Server
							<i class="mdi-content-add-circle left"></i>
						</button>
					</form>
				</div>
				<div class="col s6 m6 l6">
					<ul class="dropdown-menu pull-right footer2 tooltipped" data-position="top" data-delay="0" data-tooltip="Hide/Show Columns" style="margin-top:0px">
						<li><a class="btn dropdown-button" href="javascript:void(0);" data-activates="dropdownChannel">SELECT<i class="mdi-hardware-keyboard-arrow-down right"></i></a>
						</li>
					</ul>
					<ul id="dropdownChannel" class="dropdown-content">
						<li><a class="toggle-vis" data-column="2">Image</a></li>
						<li><a class="toggle-vis" data-column="3">Server Name</a></li>
						<li><a class="toggle-vis" data-column="4">V2ray Config</a></li>
						<li><a class="toggle-vis" data-column="8">Protocol</a></li>
						<li><a class="toggle-vis" data-column="10">Server IP</a></li>
						<li><a class="toggle-vis" data-column="7">Status</a></li>
					</ul>
				</div>

				<div class="col s12 m12 l12">

					<div class="card-panel borderTop">
						<table id="table_channel" class="responsive-table display" cellspacing="0">
							<thead>
								<tr>
									<th class="hide-column">ID</th>
									<th>No.</th>
									<th>Image</th>
									<th>Server Name</th>
									<th>V2ray Config</th>
									<th>Wireguard Config</th>
									<th>Protocol</th>
									<th>Server IP</th>
									<th>Available with ads?</th>
									<th>Status</th>
									<th>Total Hit</th>
									<th>Action</th>
								</tr>
							</thead>

							<tbody>
								<?php
								$i = 1;
								while ($data = mysqli_fetch_array($result)) {
								?>

									<tr>
										<td class="hide-column"><?php echo $data['id']; ?></td>
										<td>
											<?php
											echo $i;
											$i++;
											?>
										</td>
										<td>
											<?php if ($data['flagURL'] == NULL) {
											?>
												<img class="materialboxed  z-depth-2" data-caption="No Image" src="assets/images/no-image.png" width="34px" height="34px" />
											<?php } else { ?>
												<img class="materialboxed z-depth-2" data-caption="<?php echo $data['serverName']; ?>" src="<?php echo FLAG_IMG . $data['flagURL'] . PNG; ?>" width="34px" height="34px" />
											<?php } ?>
										</td>

										<td><?php echo $data['serverName']; ?></td>

										<td><?php echo substr(ltrim($data['ovpnConfig']), 0, 45); ?></td>

										<td><?php echo is_null($data['wireguard']) ? '' : substr(ltrim($data['wireguard']), 0, 45); ?></td>



										<td><?php echo $data['protocol']; ?></td>

										<td><?php echo $data['serverIP']; ?></td>
										<td>
											<?php
											if ($data['showAds'] == 1) {
												echo 'Yes';
											} else {
												echo 'No';
											}
											?>
										</td>

										<td>
											<?php if ($data['active'] == 1) { ?>
												<span class="task-cat light-green lighten-4 green-text text-darken-1 "><?php echo ACTIVE; ?></span>
											<?php } else { ?>
												<span class="task-cat red lighten-4 red-text text-darken-1"><?php echo INACTIVE; ?></span>
											<?php }  ?>
										</td>

										<td><?php echo $data['hit_count']; ?></td>

										<td>
											<a href="edit_server.php?id=<?php echo $data['id']; ?>&vpnType=<?php echo $vpnType; ?>" class="tooltipped light-green lighten-4 btn-floating activator waves-effect waves-light" data-position="top" data-delay="0" data-tooltip="Edit">
												<i class="mdi-editor-mode-edit green-text text-darken-1"></i>
											</a> &nbsp;

											<a class="tooltipped red lighten-4 btn-floating waves-effect waves-light" data-position="top" data-delay="0" data-tooltip="Delete" onclick="swal({
														title: 'Delete', text: 'You will not be able to recover this item!',
														type: 'warning', showCancelButton: true, confirmButtonColor: '#2196f3', 
														cancelButtonColor: '#3085d6',
														confirmButtonText: 'Yes, delete it!', cancelButtonText: 'No, cancel!',
														closeOnConfirm: false, closeOnCancel: false
													}, function (isConfirm) {
														if (isConfirm) {
															window.location.href = 'delete_server.php?id=<?php echo $data['id']; ?>';
														} else {
															swal('<?php echo DELETE_TITLE; ?>', '<?php echo DELETE_CANCELLED; ?>', 'error');
														}
													});">
												<i class="mdi-action-delete red-text text-darken-1"></i>
											</a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

</section>
<?php
	include 'templates/db.php';
	$tbl_name="satellite"; // Table name 

	echo '<div class="satellite">
			<div class="table">
				<table>
					<tr>
						<th>Satellite</th>
						<th>Next orbit</th>		
						<th>Time visible</th>
						<th></th>
					</tr>';

	$sql="SELECT * FROM $tbl_name ORDER BY time DESC";

	$result=mysql_query($sql);

	if (mysql_num_rows($result) > 0) {
        while($row = mysql_fetch_assoc($result)) {
        	echo '<tr>
					<td>' . $row["name"] . '</td>';
			if($row["time"] != "0"){
				echo '<td>' . $row["orbit"] . '</td>		
					<td>' . $row["time"] . ' min </td>
					<td><p class="table_text" id="pointer" onclick="doAjax(\''. $row["name"] . '\')"> Track </p> </td>
				</tr>';
			} else {
				echo '<td> Not visible</td>		
					<td> --- </td>
					<td><p class="table_text" id="pointerNull"> Track </p> </td>
				</tr>';
			}
        }
    }

	echo '</table>
		</div>
		<div class="satellite_info">
			<h3 id="tracking_title"> Tracking Satellite </h3>
			<p id="current_name"> Name: </p>
			<div id="current">
				<p class="current_info" id="current_elevation"> Current Elevation: </p>
				<p class="current_info" id="current_azimuth"> Current Azimuth: </p>
				<p class="current_info" id="current_latitude"> Current Time: </p>
				<p class="current_info" id="uplink"> Uplink: </p>
			</div>
			<div id="next">
				<p class="current_info" id="next_elevation"> Next Elevation: </p>
				<p class="current_info" id="next_azimuth"> Next Azimuth: </p>
				<p class="current_info" id="next_latitude"> Next Time: </p>
				<p class="current_info" id="downlink"> Downlink: </p>
			</div>
		</div>
	</div>';

?>
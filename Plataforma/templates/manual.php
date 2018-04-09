<?php
	echo '<div class="manual" style="display: none;">
				<div class="rotor">
					<h2 class="main_title"> Antenna Control </h2>
					<form class="main_form" role="form" name="addData" action="addAction.php" method="POST">
					    <div class="form-group" id="main_form">
					    	<label class="main_label">Azimuth Angle:</label>
					    	<div id="right">
						     	<input name="azimuth" type="text" class="form-control" id="az">
						     	<label class="main_label"> degrees</label>
						     </div>
					    </div>
					    <div class="form-group" id="main_form">
					      	<label class="main_label">Elevation Angle:</label>
					      	<div id="right">
						      	<input name="elevation" type="text" class="form-control" id="al">
						      	<label class="main_label"> degrees</label>
						    </div>
					    </div>
					    <button type="submit" class="btn btn-default main_button">Send Request</button>
					</form>
				</div>
				<div class="radio">
					<h2 class="main_title"> Radio Control </h2>
					<form class="main_form" role="form" method="post" action="addFrequency.php">
					    <div class="form-group" id="main_form">
					    	<label class="main_label">Uplink Frequency:</label>
					    	<div id="right">
						     	<input name="uplink" type="text" class="form-control" id="up">
						     	<label class="main_label"> MHz</label>
						     </div>
					    </div>
					    <div class="form-group" id="main_form">
					      	<label class="main_label">Downlink Frequency:</label>
					    	<div id="right">
						     	<input name="downlink" type="text" class="form-control" id="down">
						     	<label class="main_label"> MHz</label>
						     </div>
					    </div>
					    <div class="form-group" id="main_form">
					      	<label class="main_label">Mode:</label>
					    	<div id="right">
					    		<select name="mode" class="form-control" id="mode">
									<option value="lsb">LSB</option>
									<option value="usb">USB</option>
									<option value="am">AM</option>
									<option value="fm" selected>FM</option>
									<option value="cw">CW</option>
									<option value="fsk">FSK</option>
									<option value="ssv">SSV</option>
								</select>
						     </div>
					    </div>
					    <button type="submit" class="btn btn-default main_button">Send Request</button>
					</form>
				</div>
				<div class="satellite_info">
					<h3 id="tracking_title"> Tracking Satellite </h3>
					<p id="current_name2"> Name: </p>
					<div id="current">
						<p class="current_info" id="current_elevation2"> Current Elevation: </p>
						<p class="current_info" id="current_azimuth2"> Current Azimuth: </p>
						<p class="current_info" id="current_latitude2"> Current TIme: </p>
						<p class="current_info" id="uplink2"> Uplink: </p>
					</div>
					<div id="next">
						<p class="current_info" id="next_elevation2"> Next Elevation: </p>
						<p class="current_info" id="next_azimuth2"> Next Azimuth: </p>
						<p class="current_info" id="next_latitude2"> Next Time: </p>
						<p class="current_info" id="downlink2"> Downlink: </p>
					</div>
				</div>
		</div>'
?>
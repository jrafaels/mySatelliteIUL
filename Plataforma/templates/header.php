<?php 
session_start();
echo '<header class="header"> 
			<div class="menu_div">
				<ul class="menu">';
					if (isset($_SESSION['username'])) {
						echo '<li><a href="main.php" id="menu">Station</a></li>';
					}

				echo '<li><a href="sensor.php" id="menu">How To</a></li>
					<li><a href="sysinfo.php" id="menu">Server Info</a></li>';
					if (isset($_SESSION['username'])) {
						echo '<li><a href="logout.php" id="menu">Log Out</a></li>';
					}
			echo '</ul>
			</div>
</header>';
?>
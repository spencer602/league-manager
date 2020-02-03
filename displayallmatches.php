<?php

require 'header.php';

echo "<script>setTitle('Match History')</script>";
echo "<script>setCurrentPage('Match History')</script>";

include_once 'sqlscripts.php';
include_once 'helperfunctions.php';

displayAllMatches(2, null);

echo '<br><hr><br>';

?>

		<div id="footer">
			<p>Big Sky Shark Hunt, Founded 2019</p>
		 </div>
	</body>
</div>
</html>
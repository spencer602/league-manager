<!DOCTYPE html>
<html lang="en" dir="ltr">
<div id = 'wrapper'>
    <link rel="stylesheet" href="css/matchhistory.css">

<?php
require 'header.php';

echo "<body>";
echo "<script>setTitle('Match History')</script>";
echo "<script>setCurrentPage('Match History')</script>";

include_once 'LeagueManager.php';

$leagueManager = new LeagueManager();

$allMatches = $leagueManager::getAllMatchesFor(2, null, null);

guidisplayAllMatches($allMatches);

echo '<br><hr><br>';

?>
        <div id="footer">
            <p>Big Sky Shark Hunt, Founded 2019</p>
        </div>
	</body>
</div>
</html>
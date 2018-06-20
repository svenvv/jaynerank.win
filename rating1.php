<?php
//Establish Connection
require_once  "/opt/dbsettings.php";
   $db = new PDO(JAYNE_CON . JAYNE_DB, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
  // User Defined Variables

$d1 = team1_player1;
$d2 = team1_player2;
$d3 = team1_player3;
$d4 = team1_player4;
$d5 = team1_player5;
$d6 = team1_player6;
$d7 = team2_player1;
$d8 = team2_player2;
$d9 = team2_player3;
$d10 = team2_player4;
$d11 = team2_player5;
$d12 = team2_player6;
$result = result;

$team1 = array( $d1, $d2, $d3, $d4, $d5, $d6 );
$team2 = array( $d7, $d8, $d9, $d10, $d11, $d12);
$lobby = array_merge($team1,$team2)

$team1_ids = implode(',', array_fill(0, count($team1), '?'));
$team2_ids = implode(',', array_fill(0, count($team2), '?'));
$ids = $team1_ids . $team2_ids;

//Fetch ratings for each and define ratings//

$sql = "SELECT rating 
        FROM Main 
        WHERE discord_id IN ({[$ids]})
        ORDER BY FIELD(discord_id, [{[$ids]}]";
$stmt = $db->prepare($sql);
$stmt->execute(array_merge($lobby,$lobby));
$ratings = $stmt->fetchAll(FETCH_COLUMN, 0);

//Variables - 12 ID's, 12 Ratings
//----------------------------------------------------------------------------
//Find each team's avg
$teamrating_1 = ((array_sum(array_slice($ratings, 0, 6)))/6);
$teamrating_2 = ((array_sum(array_slice($ratings, 6, 6)))/6);
K_CONST = 32;

$elodifference1 = ($teamrating_2-$teamrating_1);
$percentage1 = 1/(1+(pow(10,$elodifference1/400)));
$varwin1 = (K_CONST*(1-$percentage1));
$varloss1 = (K_CONST*(0-$percentage1));

$elodifference2 = ($teamrating_1-$teamrating_2);
$percentage2 = 1/(1+(pow(10,$elodifference2/400)));
$varwin2 = (K_CONST*(1-$percentage2));
$varloss2 = (K_CONST*(0-$percentage2));
//Changes Calculated
//---------------------------------------------------------------
//Changing Rating and Wins/Losses/Draws
if($result=0){
//Add a draw to all twelve players
$sql = "UPDATE Main SET draws = draws+1 WHERE discord_id IN({[$ids]})";
$do = $db->prepare($sql);
$do = $db->execute($lobby);
exit
}else if($result = 1){
  //Add a win to players 1-6 and a loss to players 7-12
  //Add $varwin1 to rating of players 1-6, Add $varloss2 to rating of players 7-12
  $sql = "UPDATE Main SET wins = wins+1, rating = rating+$varwin1 WHERE discord_id IN({[$team_ids]})";
  $do = $db->prepare($sql);
  $do = $db->execute($team1);
  $sql = "UPDATE Main SET losses = losses+1, rating+$varloss2 WHERE discord_id IN({[$team_ids]})";
  $do = $db->prepare($sql);
  $do = $db->execute($team2);
  exit
}else if($result = 2){
  //Add a win to players 7-12, and a loss to players 1-6
  //Add $varloss1 to rating of players 1-6, Add $varwin2 to rating of players 7-12
  $sql = "UPDATE Main Set losses = losses+1, rating = rating+$varloss1 WHERE discord_id IN({[$team_ids]})";
  $do = $db->prepare($sql);
  $do = $db->execute($team1);
  $sql = "UPDATE Main Set wins = wins+1, rating = rating+$varwin2 WHERE discord_id IN({[$team_ids]})";
  $do = $db->prepare($sql);
  $do = $db->execute($team2);
  exit
}
  //add match history                   
  //$sql = "INSERT INTO `MatchHistory` (`Match_ID`, `WinningTeam`, `TimeStamp`, `Discord_ID1`, `Discord_ID2`, `Discord_ID3`, `Discord_ID4`, `Discord_ID5`, `Discord_ID6`, `Discord_ID7`, `Discord_ID8`, `Discord_ID9`, `Discord_ID10`, `Discord_ID11`, `Discord_ID12`) VALUES (NULL, ? , CURRENT_TIMESTAMP, ?,?,?,?,?,?,?,?,?,?,?,?)";
  //$z = $db->prepare($result,$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12;
  //$z = $db->execute([$result,$d1,$d2,$d3,$d4,$d5,$d6,$d7,$d8,$d9,$d10,$d11,$d12]);
                    
                     try {
        header("Location: index.html");
        die("Successful entry");
    } catch (PDOException $e) {
        die("Error updating leaderboards: " . $e->getMessage());
    }
?>

<?php
if(isset($_POST['name'], $_POST['discordID']))
{
    require_once  "/opt/dbsettings.php";
    $db = new PDO(JAYNE_CON . JAYNE_DB_DEV, JAYNE_DB_USER, JAYNE_DB_PASS, $opt);
    $do = $db->prepare("INSERT INTO Main (discord_id, name, rating, wins, losses, draws)
                        VALUES (:discordID, :name, :rating, :wins, :losses, :draws)
                        ON DUPLICATE KEY UPDATE
                            name = :dup_name;");

    $do->bindValue(':discordID', $_POST['discordID'], PDO::PARAM_INT);
    $do->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
    $do->bindValue(':dup_name', $_POST['name'], PDO::PARAM_STR);
    $do->bindValue(':rating', 1600 , PDO::PARAM_INT);
    $do->bindValue(':wins', 0 , PDO::PARAM_INT);
    $do->bindValue(':losses', 0 , PDO::PARAM_INT);
    $do->bindValue(':draws', 0 , PDO::PARAM_INT);

    try {
        $do->execute();
        header("Location: index.html");
        die("Successful entry");
    } catch (PDOException $e) {
        die("Error updating leaderboards: " . $e->getMessage());
    }
} else {
    die("Something is not right.");
}
?>

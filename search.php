<?php
include "./sql.php";
include "./sanitize.php";
//detect if keyword submitted
$result = null;
if(isset($_GET['keyword'])) {

    //sanitize immediately
    $sanitized_keyword = sanitize($_GET['keyword']);

    echo "keyword=" . $sanitized_keyword;

    //connect to database

    $db = new Database();

    //run sql

    $result = $db->search($sanitized_keyword);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
    <h1>Search</h1>

    <form action="search.php" method="GET">
        <input type="text" name="keyword">
        <input type="submit" value="submit">
    </form>

    <?php if($result): ?>
        <?php 
        //report results
        if(!$result->num_rows > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            echo "preferred: " . $row['preferred'] . "<br>";
            }   
        }else{
            echo "no results for " . $sanitized_keyword;
        }
        ?>
    <?php endif; ?>
    
</body>
</html>
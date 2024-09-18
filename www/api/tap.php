<?php
    header("Access-Control-Allow-Origin: *");

    $dbhost = 'localhost';
    $dbuser = '';
    $dbpassword = '';
    $dbname = '';
    
    $link = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
    if (!$link) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    mysqli_query($link, "SET NAMES 'utf8mb4'");
    
    $user_id = $_POST['user_id'];
    $user_id = $link -> real_escape_string($user_id);
    
    $user_name = $_POST['user_name'];
    $user_name = $link -> real_escape_string($user_name);
    
    $counter = 0;
    $user_balance = 0.0;
    $query = "SELECT * FROM `users` WHERE `telegram_id` = '$user_id'";
    if ($result = $link -> query($query)) {
        while ($row = $result->fetch_assoc()) {
            $counter++;
            $user_balance = $row['balance'];
        }
    }
    
    if ($counter == 0){
        $query = "INSERT INTO `users` (`telegram_id`, `user_name`) VALUES ('$user_id', '$user_name')";
        $link -> query($query);
    }

    $user_balance = $user_balance + 0.00000001;
    $query = "UPDATE `users` SET `balance` = $user_balance WHERE `telegram_id` = '$user_id'";
    $link -> query($query);
    
    
    
    $leaders = [];
    $query = "SELECT * FROM `users` ORDER BY `balance` DESC LIMIT 5";
    if ($result = $link -> query($query)) {
        while ($row = $result->fetch_assoc()) {
            $leader['name'] = $row['user_name'];
            if ($leader['name'] == "") $leader['name'] = "Аноним";
            $leader['balance'] = $row['balance'];
            $leaders[] = $leader;
        }
    }
    
    $output['balance'] = $user_balance;
    $output['leaders'] = $leaders;
    echo json_encode($output);
?>
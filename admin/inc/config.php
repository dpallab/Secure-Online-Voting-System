<?php
$host = 'localhost';
$user = 'root';
$pswd = 'Pd@712409';
$dbName = 'OnlineVotingSystem';

$conn = new mysqli($host, $user, $pswd, $dbName);

if ($conn->connect_error) {
    echo "<h1>Database Not Connected</h1>";
} else {
    // echo "<h1>Database Connected</h1>";


    // Only show message if this file is accessed directly, not included
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        echo "<h1>Database Connected</h1>";
    }
}
?>

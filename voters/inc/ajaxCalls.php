<?php
include('../../admin/inc/config.php');
// echo "ajax working properly";
if (isset($_POST['election_id']) && isset($_POST['candidate_id']) && isset($_POST['voters_id'])) {
    $election_id = $_POST['election_id'];
    $candidate_id = $_POST['candidate_id'];
    $voters_id = $_POST['voters_id'];

    // Get current date and time
    $vote_date = date("Y-m-d");
    $vote_time = date("H:i:s");


    $insertVoteQuery = "INSERT INTO votings (election_id, candidate_id, voters_id,vote_date, vote_time) VALUES ('$election_id', '$candidate_id', '$voters_id', '$vote_date', '$vote_time')";
    $result = $conn->query($insertVoteQuery);
    echo "Success";


}
?>













<?php  ?>
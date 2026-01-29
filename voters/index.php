<?php
include('inc/header.php');
include('inc/navigation.php');
?>

<link rel="stylesheet" href="../assets/css/style.css">
<div class="row my-3">
    <div class="col-12">
        <h3 class="text-center">Welcome to Voters Panel</h3>

        <?php
        // You can add more content here for the voters' home page
        $q = "SELECT * FROM elections where status='Active'";
        $result = $conn->query($q);
        // $totalActiveElections = $result->num_rows;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $election_id = $row['id'];
                $election_topic = $row['election_topic'];
        ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="bg-black text-white">
                                <h5>ELECTION TOPIC: <?php echo strtoupper($election_topic); ?></h5>
                            </th>
                        </tr>

                        <tr>
                            <th>Photo</th>
                            <th>Candidate Details</th>
                            <th>No. of votes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $candidateQuery = "SELECT * FROM candidate_details WHERE election_id='$election_id'";
                        $candidateResult = $conn->query($candidateQuery);
                        if ($candidateResult->num_rows > 0) {
                            while ($candidateRow = $candidateResult->fetch_assoc()) {
                                $candidate_id = $candidateRow['id'];
                                $candidate_name = $candidateRow['candidate_name'];
                                $candidate_photo = $candidateRow['candidate_photo'];
                                $candidate_details = $candidateRow['candidate_details'];
                                // $no_of_votes = $candidateRow['no_of_votes'];
                                $fetchingVotesQuery = "SELECT * FROM votings WHERE candidate_id='$candidate_id' ";
                                $votesResult = $conn->query($fetchingVotesQuery);
                                $no_of_votes = $votesResult->num_rows;
                                // echo $_SESSION['user_id'];
                        ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo $candidate_photo; ?>" class="candidate-photo">
                                    </td>
                                    <td>
                                        <h5><?php echo $candidate_name; ?></h5>
                                        <p><?php echo $candidate_details; ?></p>
                                    </td>
                                    <td> <?php echo $no_of_votes; ?></td>



                                    <td>
                                        <?php
                                        // Check if the voter has already voted in this election
                                        $checkIfVoteCastedQuery = "SELECT * FROM votings WHERE election_id='$election_id' AND voters_id='" . $_SESSION['user_id'] . "'";
                                        $voteCastedResult = $conn->query($checkIfVoteCastedQuery);
                                        $isVoteCasted = $voteCastedResult->num_rows;
                                        // echo $isVoteCasted;
                                        // Voter has already voted

                                        if ($isVoteCasted > 0) {
                                            $voteCastedData = $voteCastedResult->fetch_assoc();
                                            $voteCastedcandidate = $voteCastedData['candidate_id'];
                                            if ($voteCastedcandidate == $candidate_id) {
                                            ?>
                                                <button class="btn btn-md btn-secondary" disabled>Voted</button>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <button class="btn btn-md btn-success" onclick="CastVote( <?php echo $election_id; ?>,<?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)">Vote</button>
                                        <?php
                                        }

                                        ?>

                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No candidates found for this election.</td></tr>";
                        }
                        ?>
                </table>
        <?php
            }
        } else {
            echo "No active elections found.";
        }
        ?>

    </div>
</div>

<script>
    const CastVote = (election_id, candidate_id, voters_id) => {
        // alert("Your vote has been casted successfully!");
        // console.log("working");
        // You can add AJAX call here to submit the vote
        // console.log(election_id, "-", candidate_id, "-", user_id);
        $.ajax({
            type: 'POST',
            url: 'inc/ajaxCalls.php',
            data: {
                election_id: election_id,
                candidate_id: candidate_id,
                voters_id: voters_id
            },
            success: function(response) {
                response = response.trim(); // 🔥 FIX
                console.log(response);

                if (response === "Success") {
                    location.assign('index.php?voteCasted=1');
                } else {
                    location.assign('index.php?voteNotCasted=1');
                }
            }
        });

    }
</script>

<?php
include('inc/footer.php');
?>
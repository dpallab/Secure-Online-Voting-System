<!-- message showing -->
<?php
if (isset($_GET['added'])) {
?>
    <div class="alert alert-success" role="alert">Candidate added successfully!</div>
<?php
} elseif (isset($_GET['notAdded'])) {
?>
    <div class="alert alert-danger" role="alert">Candidate not added. Please try again!</div>
<?php
} elseif (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM candidate_details WHERE id='$delete_id'";
    if ($conn->query($deleteQuery)) {
    ?>
        <div class="alert alert-success" role="alert">Candidate deleted successfully!</div>
<?php
    }
}
?>



<link rel="stylesheet" href="../assets/css/style.css">

<div class="row my-3">
    <div class="col-4">
        <h3>Add New Candidate</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select class="form-control" name="election_id" required>
                    <option value="">Select election</option>
                    <?php
                    $q = "SELECT * FROM elections";
                    $result = $conn->query($q);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $election_id = $row['id'];
                            $election_name = $row['election_topic'];
                            $allowed_candidates = $row['no_of_candidates'];
                            $noCandidate = "select * from candidate_details where election_id='$election_id'";
                            $noCandidateResult = $conn->query($noCandidate);
                            $addedCandidates = $noCandidateResult->num_rows;
                            if ($addedCandidates < $allowed_candidates) {
                    ?>
                                <option value="<?php echo $election_id; ?>"> <?php echo $election_name; ?> </option>
                        <?php
                            }
                        }
                    } else {
                        ?>
                        <option value="">Please, add election first</option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="candidate_name" class="form-control" placeholder="Candidate name" required />
            </div>

            <div class="form-group">
                <input type="file" name="candidate_photo" class="form-control" accept=".jpg,.jpeg,.png,.webp" required />
            </div>

            <div class="form-group">
                <input type="text" name="candidate_details" class="form-control" placeholder="Candidate Details" required />
            </div>
            <input type="submit" value="Add Candidate" class="btn btn-success" name="addCandidateBtn">
        </form>
    </div>


    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">SL No.</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT * FROM candidate_details";
                $result = $conn->query($q);
                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        // get election name from election table using election_id
                        $election_id = $row['election_id'];
                        $fetchingElection = "SELECT * FROM elections WHERE id = $election_id";
                        $electionResult = $conn->query($fetchingElection);
                        $electionResultRow = $electionResult->fetch_assoc();
                        $election_name = $electionResultRow['election_topic'];

                ?>
                        <tr>
                            <th scope="row"><?php echo $sno++; ?></th>
                            <td> <img src="<?php echo $row['candidate_photo']; ?>" class="candidate-photo" /> </td>
                            <td><?php echo $row['candidate_name']; ?></td>
                            <td><?php echo $row['candidate_details']; ?></td>
                            <td><?php echo $election_name; ?></td>
                            <td>
                                <!-- <a href="" class="btn btn-primary btn-sm">Edit</a> -->
                                <a onclick="DeleteData(<?php echo $row['id']; ?>)" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan='7'>No Candidates found.</td>
                    </tr>
                <?php
                }

                ?>
            </tbody>
        </table>
    </div>
</div>


<script>
    const DeleteData = (c_id) => {
        let c = confirm("Are you sure you want to delete this candidate?");

        if (c == true) {
            // alert("Candidate deleted successfully!");
            location.assign("index.php?addCandidatePage=1&delete_id=" + c_id);
        }
    }
</script>


<?php
include('config.php');
if (isset($_POST['addCandidateBtn'])) {
    date_default_timezone_set("Asia/Kolkata");    // change timezone to IST(Indian standard time)

    $election_id = $_POST['election_id'];
    $candidate_name = $_POST['candidate_name'];
    $candidate_details = $_POST['candidate_details'];

    $inserted_by = $_SESSION['username'];
    $inserted_on = date('Y-m-d');

    // candidate picture upload code
    $targeted_folder = "../assets/images/candidate_photos/";
    $candidate_photo = $targeted_folder . basename($_FILES['candidate_photo']['name']);
    // echo $candidate_photo;
    move_uploaded_file($_FILES['candidate_photo']['tmp_name'], $candidate_photo);


    $q = "INSERT INTO candidate_details (election_id, candidate_name, candidate_photo, candidate_details, inserted_by, inserted_on) VALUES ('$election_id', '$candidate_name', '$candidate_photo', '$candidate_details', '$inserted_by', '$inserted_on')";
    $result = $conn->query($q);
    if ($result) {
?>
        <script>
            location.assign("index.php?addCandidatePage=1&added=1");
        </script>
    <?php
    } else {
    ?>
        <script>
            location.assign("index.php?addCandidatePage=1&notAdded");
        </script>
<?php
    }
}
?>
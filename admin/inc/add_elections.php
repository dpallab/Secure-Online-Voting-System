<!-- message showing -->
<?php
if (isset($_GET['added'])) {
?>
    <div class="alert alert-success" role="alert">Election added successfully!</div>
<?php
} elseif (isset($_GET['notAdded'])) {
?>
    <div class="alert alert-danger" role="alert">Election not added. Please try again!</div>
    <?php
} elseif (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM elections WHERE id='$delete_id'";
    if ($conn->query($deleteQuery) and  $conn->query(
        "DELETE FROM candidate_details WHERE election_id='$delete_id'"
    )) {
    ?>
        <div class="alert alert-success" role="alert">Election deleted successfully!</div>
<?php
    }
}
?>

<div class="row my-3">
    <div class="col-4">
        <h3>Add Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="election_topic" class="form-control" placeholder="Election topic" required />
            </div>

            <div class="form-group">
                <input type="text" name="no_of_candidates" class="form-control" placeholder="Number of candidates" required />
            </div>

            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="starting_date" class="form-control" placeholder="Starting date" required />
            </div>
            <!-- onfocus="this.type='date'" -->

            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="ending_date" class="form-control" placeholder="Ending date" required />
            </div>
            <input type="submit" value="Add Election" class="btn btn-success" name="addElectionBtn">
        </form>
    </div>


    <div class="col-8">
        <h3>Upcoming Elections</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">SL No.</th>
                    <th scope="col">Election Name</th>
                    <th scope="col">Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "SELECT * FROM elections";
                $result = $conn->query($q);
                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        $election_id = $row['id'];
                ?>
                        <tr>
                            <th scope="row"><?php echo $sno++; ?></th>
                            <td><?php echo $row['election_topic']; ?></td>
                            <td><?php echo $row['no_of_candidates']; ?></td>
                            <td><?php echo $row['starting_date']; ?></td>
                            <td><?php echo $row['ending_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <!-- <a  class="btn btn-primary btn-sm">Edit</a> -->
                                <a onclick="DeleteData(<?php echo $election_id; ?>)" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>

                    <?php
                    }
                } else {

                    ?>
                    <tr>
                        <td colspan='7'>No elections found.</td>
                    </tr>;
                <?php
                }

                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    const DeleteData = (e_id) => {
        let c = confirm("Are you sure you want to delete this election?");

        if (c == true) {
            // alert("Election deleted successfully!");
            location.assign("index.php?addElectionPage=1&delete_id=" + e_id);
        }
    }
</script>


<?php
include('config.php');
if (isset($_POST['addElectionBtn'])) {
    date_default_timezone_set("Asia/Kolkata");    // change timezone to IST(Indian standard time)

    $election_topic = $_POST['election_topic'];
    $no_of_candidates = $_POST['no_of_candidates'];
    $starting_date = $_POST['starting_date'] ?? '';
    $ending_date = $_POST['ending_date'] ?? '';


    $inserted_by = $_SESSION['username'];
    $inserted_on = date('Y-m-d');


    // Correct status logic
    // $today = date('Y-m-d');
    // if ($today >= $starting_date && $today <= $ending_date) {
    //     $status = "Active";
    // } else {
    //     $status = "InActive";
    // }
    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);
    if ((int)$diff->format("%R%a") > 0) {
        $status = "InActive";
    } else {
        $status = "Active";
    }

    $q = "INSERT INTO elections (election_topic, no_of_candidates, starting_date, ending_date, status, inserted_by, inserted_on) VALUES ('$election_topic', '$no_of_candidates', '$starting_date', '$ending_date', '$status', '$inserted_by', '$inserted_on')";
    $result = $conn->query($q);
    if ($result) {
?>
        <script>
            location.assign("index.php?addElectionPage=1&added=1");
        </script>
    <?php
    } else {
    ?>
        <script>
            location.assign("index.php?addElectionPage=1&notAdded");
        </script>
<?php
    }
}
?>
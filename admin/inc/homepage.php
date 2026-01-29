
<div class="row my-3">
    <div class="col-12">
        <h3 class="text-center">Election Details</h3>
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
                    $sno=1;
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
                                <a href="index.php?viewResult=<?php echo $election_id; ?>" class="btn btn-primary btn-sm btn-success">View Result</a>
                            </td>
                        </tr>
                        <?php
                    }

                    } else {
                        ?>
                        <tr><td colspan='7'>No elections found.</td></tr>
                        <?php
                    }

                ?>
            </tbody>
        </table>
    </div>
</div>



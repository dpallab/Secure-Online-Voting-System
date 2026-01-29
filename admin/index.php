<?php
include('inc/header.php');
include('inc/navigation.php');

if (isset($_GET['addElectionPage'])) {
    include('inc/add_elections.php');
} elseif (isset($_GET['addCandidatePage'])) {
    include('inc/add_candidates.php');
} elseif (isset($_GET['homePage'])) {
    include('inc/homepage.php');
}elseif (isset($_GET['viewResult'])) {
    include('inc/viewResults.php');
}
?>

<?php
include('inc/footer.php');
?>
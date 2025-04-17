<?php
/**
 * Include the Database connection settings
 */
include_once('../../credentials/db.php');

/**
 * Initialize the PDO connections
 */
$pdo = new \PDO("mysql:dbname={$dbName};host={$dbHost}", $dbUser, $dbPass, [\PDO::ATTR_PERSISTENT => true,
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);

$email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) : '';
$jobTitle = isset($_POST['jobTitle']) ? filter_var($_POST['jobTitle'], FILTER_SANITIZE_STRING) : '';
$jobDesc = isset($_POST['jobDesc']) ? filter_var($_POST['jobDesc'], FILTER_SANITIZE_STRING) : '';

//initialize row counts
$rowCountJobPost = 0;
$rowCountEmailJobPostInsert = 0;

//check
$sth1 = $pdo->prepare("
    SELECT * 
    FROM emails_jobposts
    WHERE flagged = 0
");
$sth1->execute();
$rowCountEmailsJobposts = $sth1->rowCount();

if ($rowCountEmailsJobposts > 0) {
    $r1 = $sth1->fetchAll();

    foreach ($r1 as $k => $v) {
        $sth2 = $pdo->prepare("
            SELECT COUNT(*) 
            FROM jobposts2
            WHERE flagged = 0
        ");
    }

//    echo '<pre>';
//    print_r($r1);
//    echo '</pre>';
}


/**
 * get all the job post listings for user that is still flagged with 0 and succeedingly created more than one job post
 */
$sth3= $pdo->prepare("
        SELECT
            id as jobpostID, title, description, published, spam, user_email, flagged
        FROM jobposts2
        LEFT JOIN emails_jobposts 
        ON email = user_email
        WHERE flagged = 0 AND published = 0 AND spam = 0
    ");
$sth3->execute();
$r3 = $sth3->fetchAll();






if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) {


}

//echo '<pre>';
//print_r($r3);
//echo '</pre>';

?>
<?php include_once ('../../view/parts/header.php') ?>

<?php if (($rowCountJobPost > 0) || ($rowCountEmailJobPostInsert > 0)) : ?>
    <div>
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            Successfully created a new job post!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<div class="my-5">
    <div class="container">
        <h4>Job Moderator</h4>
        <br/>

        <div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Job Title</th>
                        <th>Job Description</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (isset($result) && count($result) > 0) : ?>
                        <?php foreach ($result as $k => $v) : ?>
                            <tr>
                                <td><?php echo $v['jobpostID']; ?></td>
                                <td><?php echo $v['title']; ?></td>
                                <td><?php echo $v['description']; ?></td>
                                <td><?php echo $v['user_email']; ?></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <button type="submit" class="btn btn-warning">Spam</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<?php include_once ('../../view/parts/footer.php') ?>

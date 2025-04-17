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

/**
 * Check all the user emails with flagged value of 0 and update it to 1 if the job listing has
 * already by vetted by the moderator.
 */
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
            SELECT id, email 
            FROM jobposts2
            WHERE email = :user_email AND (published = 0 OR spam = 0)
        ");
        $sth2->execute([
            ':user_email' => $v['user_email'],
        ]);
        $rowCountJobPostsRelational = (int) $sth2->rowCount();

        /**
         * Update the flagged to 1 if the user job post has already been vetted by the job moderator.
         * This will no longer show the users job posting in the Job moderator board.
         */
        if ($rowCountJobPostsRelational == 0) {
            $sth3 = $pdo->prepare("
                UPDATE emails_jobposts
                SET flagged = 1
                WHERE user_email = :user_email 
            ");
            $sth3->execute([
                ':user_email' => $v['user_email'],
            ]);
        }

    }

}

/**
 * Get all the job post listings for user that is still flagged with 0 and succeedingly created more than one job post
 */
$sth4= $pdo->prepare("
        SELECT
            id as jobpostID, title, description, published, spam, user_email, flagged
        FROM jobposts2
        LEFT JOIN emails_jobposts 
        ON email = user_email
        WHERE flagged = 0 AND ( (published = 0 AND spam = 0) OR (published = 1 AND spam = 0) OR (published = 0 AND spam = 1) )
    ");
$sth4->execute();
$r4 = $sth4->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jobpostID = isset($_POST['jobpostID']) ? filter_var($_POST['jobpostID'], FILTER_VALIDATE_INT) : 0;
    $rowCountAction = 0;
    $published = 0;

    if (isset($_POST['button_approve'])) {
        $sth5 = $pdo->prepare("
            UPDATE jobposts2
            SET published = 1
            WHERE id = :jobpostID
        ");
        $sth5->execute([
            ':jobpostID' => $jobpostID,
        ]);
        $rowCountAction = (int) $sth5->rowCount();
        $published = 1;
    }

    if (isset($_POST['button_spam'])) {
        $sth5 = $pdo->prepare("
            UPDATE jobposts2
            SET spam = 1
            WHERE id = :jobpostID
        ");
        $sth5->execute([
            ':jobpostID' => $jobpostID,
        ]);
        $rowCountAction = (int) $sth5->rowCount();
    }

}


?>
<?php include_once ('../../view/parts/header.php') ?>

<?php if ($rowCountAction > 0) : ?>
    <div>
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            <?php if ($published > 0) : ?>
                Successfully approved and published the job listing.
            <?php else : ?>
                Successfully marked the job listing as spam. 
            <?php endif; ?>
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
                    <?php if (isset($r4) && count($r4) > 0) : ?>
                        <?php foreach ($r4 as $k => $v) : ?>
                            <tr>
                                <td><?php echo $v['jobpostID']; ?></td>
                                <td><?php echo $v['title']; ?></td>
                                <td><?php echo $v['description']; ?></td>
                                <td><?php echo $v['user_email']; ?></td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <input type="hidden" name="jobpostID" value="<?php echo $v['jobpostID']; ?>"/>
                                        <button type="submit" class="btn btn-success" name="button_approve" value="1">Approve</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                        <input type="hidden" name="jobpostID" value="<?php echo $v['jobpostID']; ?>"/>
                                        <button type="submit" class="btn btn-warning" name="button_spam" value="1">Spam</button>
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

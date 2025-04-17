<?php
if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) {
    /**
     * Include the Database connection settings
     */
    include_once('../credentials/db.php');

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

    //insert the job posts
    $sth = $pdo->prepare("
        INSERT INTO 
          jobposts2 (email, title, description)
        VALUES
          (:email, :jobTitle, :jobDesc)
    ");
    $sth->execute([
        ':email'    => $email,
        ':jobTitle' => $jobTitle,
        ':jobDesc'  => $jobDesc,
    ]);
    $rowCountJobPost = $sth->rowCount();

    //check if the table emails_jobposts already contains the user email
    $sth = $pdo->prepare("
        SELECT *
        FROM emails_jobposts
        WHERE user_email = :user_email 
    ");
    $sth->execute([
        ':user_email' => $email,
    ]);
    $rowCountEmailJobPostSelect = $sth->rowCount();

    if ($rowCountEmailJobPostSelect == 0) {
        $sth = $pdo->prepare("
            INSERT INTO
              emails_jobposts (user_email)
            VALUES
              (:user_email)
        ");
        $sth->execute([
            ':user_email' => $email,
        ]);
        $rowCountEmailJobPostInsert = $sth->rowCount();
    }

}

?>
<?php include_once ('../view/parts/header.php') ?>

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
        <h4>Create new job post</h4>
        <br/>

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <?php
            /**
             * Just hardcoded user data in the database table, for testing purposes.
             */
            ?>
            <!--
            <input type="hidden" name="userID" value="1"/>
            <input type="hidden" name="firstname" value="Reynaldo"/>
            <input type="hidden" name="lastname" value="Hipolito"/>
            <input type="hidden" name="email" value="rahj.1986@gmail.com"/>
            -->

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="jobTitle" class="form-label">Job Title</label>
                    <input type="text" class="form-control" id="jobTitle" placeholder="" value="" name="jobTitle" required>
                </div>
            </div>
            <br/>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="jobDesc" class="form-label">Job Description</label>
                    <textarea class="form-control" id="jobDesc" rows="8" placeholder="" name="jobDesc" required></textarea>
                </div>
            </div>
            <br/>

            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="email" class="form-label">(Assumed this is the email for loggedin user - for testing)</label>
                    <input type="email" class="form-control" id="email" placeholder="" value="" name="email" required>
                </div>
            </div>
            <br/>

            <div class="row g-3">
                <div class="col-sm-6">
                    <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Create New Job Post</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include_once ('../view/parts/footer.php') ?>

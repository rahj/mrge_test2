<?php
$urlJobListing = 'https://mrge-group-gmbh.jobs.personio.de/xml';
$xml = simplexml_load_file($urlJobListing, 'SimpleXMLElement', LIBXML_NOCDATA);

?>
<?php include_once ('../view/parts/header.php') ?>

<?php if ($rowCountAction > 0) : ?>
    <div>
        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            dgdfgdfgdfgdg
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<div class="my-5">
    <div class="container">
        <h4>Job Listings</h4>
        <br/>

        <?php
        $i = 0;
        foreach ($xml as $k => $v) : ?>
            <div class="<?php echo $i == 0 ?: 'my-5' ?>">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $v->name; ?>
                        </div>

                        <div class="card-body">
                            <!--
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                            -->
                            <p class="card-text">
                                <strong>Subcompany</strong>: <?php echo $v->subcompany; ?>
                            </p>

                            <p class="card-text">
                                <strong>Office</strong>: <?php echo $v->office; ?>
                            </p>

                            <p class="card-text">
                                <strong>Department</strong>: <?php echo $v->department; ?>
                            </p>

                            <p class="card-text">
                                <strong>Category</strong>: <?php echo $v->recruitingCategory; ?>
                            </p>

                            <p class="card-text">
                                <strong>Employment Type</strong>: <?php echo $v->employmentType; ?>
                            </p>

                            <p class="card-text">
                                <strong>Seniority</strong>: <?php echo $v->seniority; ?>
                            </p>

                            <p class="card-text">
                                <strong>Schedule</strong>: <?php echo $v->schedule; ?>
                            </p>

                            <p class="card-text">
                                <strong>Years Of Experience</strong>: <?php echo $v->yearsOfExperience; ?>
                            </p>

                            <p class="card-text">
                                <strong>Keywords</strong>: <?php echo $v->keywords; ?>
                            </p>

                            <div class="my-4">
                                <?php foreach ($v->jobDescriptions as $k2 => $v2) : ?>

                                    <?php foreach ($v2->jobDescription as $k3 => $v3) : ?>
                                        <h5><?php echo $v3->name ?></h5>
                                        <p class="card-text">
                                            <?php echo $v3->value ?>
                                        </p>
                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        $i++;
        endforeach; ?>


        <br/><br/>
    </div>
</div>

<?php include_once ('../view/parts/footer.php') ?>

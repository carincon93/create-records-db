<?php
    $title                  =  isset($_REQUEST["title"]) ? $_REQUEST["title"] : null;
    $description            =  isset($_REQUEST["description"]) ? $_REQUEST["description"] : null;
    $skills_requirements    =  isset($_REQUEST["skills_requirements"]) ? $_REQUEST["skills_requirements"] : null;
    $value                  =  isset($_REQUEST["value"]) ? $_REQUEST["value"] : null;
    $authUser               = 2;


    // Connect to database
    $host       = "localhost";
    $dbname     = "freelancer";
    $username   = "root";
    $password   = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

    function saveNewContest($title, $description, $skills_requirements, $value, $authUser, $cnx) {
        $sql    = "INSERT INTO `contests` (`id`, `user_id`, `title`, `description`, `skills_requirements`, `value`) VALUES (NULL, $authUser, '$title', '$description', '$skills_requirements', $value)";
        $q      = $cnx->prepare($sql);

        $q->execute();
    }

    if ($title && $description && $skills_requirements && $value) {
        saveNewContest($title, $description, $skills_requirements, $value, $authUser, $cnx);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create contest</title>
    <link rel="stylesheet" href="./assets/app.css">
</head>
<body>
    <div class="flex min-height-100vh">
        <div class="sidebar">
            <header>
                <h2 class="text-center">FREE<span class="thin">LANCER</span></h2>
                <!-- <figure>
                    <img src="" alt="">
                </figure> -->
            </header>
                <div>
                    <a href="./contest-application.php" class="sidebar-link flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="nav-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Show all contests</span>
                    </a>
                </div>
        </div>
        <div class="main">
            <div class="container">
                <div class="card">
                        <form action="./create-contest.php" method="POST">
                            <input type="hidden" name="contest_id" value="<?= $contestFiltered['id'] ?>">
                            <div>

                                <div>
                                    <label for="title">Describe your requirements and various <span class="strong">free</span>lancers will contact you 😎</label>

                                    <textarea name="title" id="title" cols="20" rows="1" class="form-control mt-10" required></textarea>
                                </div>
                                <div class="mt-10">
                                    <label for="description">More information</label>

                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control mt-10" required></textarea>
                                </div>

                                <div class="mt-10">
                                    <label for="skills_requirements">Skills requirements</label>

                                    <textarea name="skills_requirements" id="skills_requirements" cols="30" rows="10" class="form-control mt-10" required></textarea>
                                </div>

                                <div class="mt-10">
                                    <label for="value">Value</label>

                                    <input name="value" type="number" min="0" id="value" class="form-control mt-10" required>
                                </div>
                                
                            </div>

                            <div class="mt-10">
                                <button type="submit" class="btn-primary">Send contest</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

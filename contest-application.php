<?php

    $freelancerId       = isset($_REQUEST["freelancer_id"]) ? $_REQUEST["freelancer_id"] : null;
    $contestId          = isset($_REQUEST["contest_id"]) ? $_REQUEST["contest_id"] : null;
    $freelancers        = null;
    $contestFiltered    = null;

    // Connect to database
    $host       = "localhost";
    $dbname     = "freelancer";
    $username   = "root";
    $password   = "";

    $cnx = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);

    function getAllFreelancers($cnx) {
        $sql = "SELECT * FROM `users` WHERE `role` = 1";
        
        $q = $cnx->prepare($sql);

        $result = $q->execute();

        return $q->fetchAll();
    }

    function getContestById($contestId, $cnx) {
        $sql = "SELECT * FROM `contests` WHERE `id` = $contestId";
        
        $q = $cnx->prepare($sql);

        $result = $q->execute();

        return $q->fetch();
    }

    function getAllContests($cnx) {
        $sql    = "SELECT `id` FROM `contests`";
        
        $q      = $cnx->prepare($sql);

        $result = $q->execute();

        return $q->fetchAll();
    }

    function saveContestApplication($freelancerId, $contestId, $cnx) {
        $sql    = "INSERT INTO `contest_applications` (`freelancer_id`, `contest_id`) VALUES ($freelancerId, $contestId)";
        
        $q      = $cnx->prepare($sql);

        $resultSaveContest = $q->execute();
    }

    $freelancers    = getAllFreelancers($cnx);
    $contests       = getAllContests($cnx);

    if ($freelancerId && $contestId) {
        saveContestApplication($freelancerId, $contestId, $cnx);
    }

    if ($contestId) {
        $contestFiltered = getContestById($contestId, $cnx);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contest application</title>
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
            <?php foreach ($contests as $contest): ?>
                <div>
                    <a href="./contest-application.php?contest_id=<?= $contest['id'] ?>" class="sidebar-link flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="nav-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>We have a new contest here! <span class="strong">free</span>lancer 😱 </span>
                    </a>
                </div>
            <?php endforeach; ?>

            <div>
                <a href="./create-contest.php" class="sidebar-link flex bg-purple">
                    🥇
                    <span class="ml-10">Create contest</span>
                </a>
            </div>
        </div>
        <div class="main">
            <div class="container">
                <div class="card">
                    <?php if($contestFiltered): ?>
                        <span>#Contest00<?= $contestFiltered['id'] ?></span>
                        <p><?= $contestFiltered['title'] ?></p>
                        <p class="mt-10"><?= $contestFiltered['description'] ?></p>

                        <form action="./contest-application.php" method="POST">
                            <input type="hidden" name="contest_id" value="<?= $contestFiltered['id'] ?>">
                            <div>
                                <div>
                                    <label for="freelancer_id">Work with a <span class="strong">free</span>lancer friend 😎</label>
                                </div>
                                <select name="freelancer_id" id="freelancer_id" class="form-control mt-10" required>
                                    <option value="">Select a freelancer from your friends</option>
                                    <?php foreach ($freelancers as $freelancer): ?>
                                        <option value="<?= $freelancer['id'] ?>" <?= ("$freelancerId" == $freelancer['id']) ? 'selected' : '' ?> ><?= $freelancer['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mt-10">
                                <button type="submit" class="btn-primary">Apply</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <h1 class="text-center">Nothing to see here</h1>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

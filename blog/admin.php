<?php
require "logique.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/journal/bootstrap.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/blog4">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/blog4">Home
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <?php if ($isLoggedIn) { ?>

                        <li class="nav-item">
                            <a class="btn btn-info me-2" href="creation.php">Nouveau post</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-info me-2" href="userProfile.php?authProfile=<?php echo $_SESSION['userId'] ?>"> My Profile </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php if ($isLoggedIn) { ?>



                <form method="POST" class="d-flex">

                    <button type="submit" name="logOut" class="btn btn-secondary my-2 my-sm-0">Deconnexion</button>
                </form>
            <?php } ?>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <?php
    if ($isAdmin) {
    ?>
        <p>YOU GOT THE POWER!!!</p>
        <div class="d-flex flex-wrap">
            <?php foreach ($resultsAdminPosts as $post) { ?>
                <div class="col-4">
                    <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
                        <img style="max-width: 20rem" src="photos/posts/<?php echo $post['postimage'] ?>" alt="">
                        <div class="card-header"><?php echo $post["title"]; ?></div>

                        <p class="m-2"><span class="badge rounded-pill bg-secondary">Status: <?php echo ($post["published"] != 0) ? "published" : "unpublished" ?></span></p>


                        <div class="card-body">
                            <h5 class="card-title"><a style=" color:white;" href="blog/userProfile.php?authProfile=<?php echo $post["author_id"] ?>"> Auteur : <?php echo ($post["displayName"] != "") ? $post["displayName"] : $post["userName"]  ?></a></h5>
                            <p class="card-text"><em> <?php echo substr($post["content"], 0, 100); ?>...</em></p>
                            <p class="card-text"><em>posted on: <?php echo substr($post["currentDate"], 0, 10); ?></em> </p>
                        </div>


                        <!-- Admin POST Control BTN -->
                        <div class="d-flex me-2">
                            <form method="POST">
                                <input type="hidden" name="PostIdAdm" value="<?php echo $post['id'] ?>">
                                <button type="submit" name="isPublishPostAdm" value="<?php echo ($post["published"] != 1) ? "1" : "0" ?>" class="btn btn-primary ms-5"><?php echo ($post["published"] != 1) ? "Publish" : "Unpublish" ?></button>
                            </form>
                            <!-- DELETE BUTTON -->

                            <form method="POST">
                                <input type="hidden" name="PostIdDelete" value="<?php echo $post['id'] ?>">
                                <button type="submit" class="btn btn-danger ms-5">DELETE</button>
                            </form>

                        </div>
                        <a href="blog/postUnique.php?postId=<?php echo $post['id'] ?>" class="btn btn-primary">Voir l'article</a>
                    </div>
                </div>


                <!-- end of the loop -->
            <?php } ?>
        </div>




    <?php } else {
    ?>
        <p> YOU SHALL NOT PASS!!!! </p>
    <?php } ?>
</body>

</html>
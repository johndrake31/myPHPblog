<?php
require "blog/logique.php";
?>

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
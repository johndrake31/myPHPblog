<?php
$monHote = "localhost";
$database = "myBlogPhp";
$databaseUser = "john";
$userPassword = "pass";

$maConnection = mysqli_connect($monHote, $databaseUser, $userPassword, $database);
 if(!$maConnection){

    echo "
    
    <div class='alert alert-dismissible alert-warning'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <h4 class='alert-heading'>Warning!</h4>
      <p class='mb-0'>probleme de connection à la base de données</a>.</p>
    </div>";
    
    die();
    
    }

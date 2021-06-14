<?php

session_start();
if (isset($_POST['logOut'])) {
   session_unset();
}

require_once dirname(__FILE__) . "/../authentification/auth.php";
require_once dirname(__FILE__) . "/../access/db.php";

//Suppression d'un article

if (isset($_POST['idSuppression'])) {

   $idASupprimer = $_POST['idSuppression'];

   $maRequeteDeSuppression = "DELETE FROM posts WHERE id=$idASupprimer";

   $maSuppression = mysqli_query($maConnection, $maRequeteDeSuppression);

   header("Location: ../index.php?info=deleted");
}



// modification d'un article

if (isset($_POST['titreEdite']) && isset($_POST['texteEdite'])) {

   $titreEdite = $_POST['titreEdite'];

   $texteEdite = $_POST['texteEdite'];

   //on doit refaire passer l'ID par le biais d'un input supplémentaire dans le
   $idArticleAModifier = $_POST['idAModifier'];

   $maRequeteUpdate = "UPDATE posts SET title  = '$titreEdite', content = '$texteEdite' WHERE id = $idArticleAModifier";

   $monResultat = mysqli_query($maConnection, $maRequeteUpdate);

   header("Location: postUnique.php?postId=$idArticleAModifier&info=edited");
}

//





//creation d'article

if (isset($_POST['nouveauTitre']) && isset($_POST['nouveauTexte'])) {
   if ($_POST['nouveauTitre'] !== "" && $_POST['nouveauTexte'] !== "") {
      $nouveauTitre = $_POST['nouveauTitre'];
      $nouveauTexte = $_POST['nouveauTexte'];
      $authorId = $_SESSION['userId'];


      $extensionsAutorisees = array("jpeg", "jpg", "png", "gif", "JPEG", "JPG", "PNG", "GIF");

      $hauteurMax = 2000;
      $largeurMax = 2000;

      $tailleMax = 51200000;

      if (isset($_FILES['fileToSend2']['name']) && $_FILES['fileToSend2']['name'] != "") {


         $myImageSize = getimagesize($_FILES['fileToSend2']['tmp_name']);
         $myimagekb = $_FILES['fileToSend2']['size'];

         $mywidth = $myImageSize[0];
         $myheight = $myImageSize[1];

         $mytableExt = explode("/", $myImageSize['mime']);
         $mytableExt1 = $mytableExt[1];
         $specialName = explode("/", $_FILES['fileToSend2']['tmp_name']);
         $myUploadExt = end($specialName);



         if (
            // in_array($mytableExt1, $extensionsAutorisees) &&
            $largeurMax >= $mywidth
            && $hauteurMax >= $myheight
            && $tailleMax >= $myimagekb
         ) {

            $repertoireUpload = "photos/posts/";
            $nomFinalDuFichier = $myUploadExt . $_FILES['fileToSend2']['name'];

            $destinationFinale = $repertoireUpload . $nomFinalDuFichier;
            $nomTemporaireFichier = $_FILES['fileToSend2']['tmp_name'];

            $isUploaded = move_uploaded_file($nomTemporaireFichier, $destinationFinale);



            if ($isUploaded) {
               echo "is a  success";

               $maRequete = "INSERT INTO posts(title, content, author_id, image) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', '$nomFinalDuFichier')";

               $leResultatDeMonAjoutArticle = mysqli_query($maConnection, $maRequete);


               // TEST qu ne doit pas etre visible pour les uilisateurs
               if (!$leResultatDeMonAjoutArticle) {
                  die("RAPPORT ERREUR " . mysqli_error($maConnection));
               }

               header("Location: ../index.php?info=added");
            } else {
               die("upload failed");
            }
         } else {
            die("that is an incorrect file type");
         }
      } else {
         $maRequete = "INSERT INTO posts(title, content, author_id, image) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', 'default.jpeg')";

         $leResultatDeMonAjoutArticle = mysqli_query($maConnection, $maRequete);


         // TEST qu ne doit pas etre visible pour les uilisateurs
         if (!$leResultatDeMonAjoutArticle) {
            die("RAPPORT ERREUR " . mysqli_error($maConnection));
         }

         header("Location: ../index.php?info=added");
      }
   } else {
      echo "remplis ton formulaire en entier";
   }
}






function getCommentsByPostId($myPostId, $maConnection)
{
   echo $myPostId;
   $myRequest = "SELECT * FROM comments
   INNER JOIN users
   ON users.id = author_id
   WHERE comments.post_id = '$myPostId'  
ORDER BY `comments`.`date_added`  DESC";

   $myResults = mysqli_query($maConnection, $myRequest);
   return $myResults;
}


//create comment
if (
   isset($_POST['commentAuthor']) &&
   isset($_POST['commentPostId']) &&
   isset($_POST['commentToPost'])
) {
   if (
      $_POST['commentAuthor'] != '' &&
      $_POST['commentPostId'] != '' &&
      $_POST['commentToPost'] != ''
   ) {
      $commentAuthId = mysqli_real_escape_string($maConnection, $_POST['commentAuthor']);
      $commentPostId = mysqli_real_escape_string($maConnection, $_POST['commentPostId']);
      $commentToPost = mysqli_real_escape_string($maConnection, $_POST['commentToPost']);

      $createCommentRequest = "INSERT INTO `comments` (`id`, `comment`, `author_id`, `post_id`, `date_added`) VALUES (NULL, '$commentToPost', '$commentAuthId', '$commentPostId', CURRENT_TIMESTAMP);";
      $resultsOfCommentCreate = mysqli_query($maConnection, $createCommentRequest);
      header("Location: postUnique.php?postId=$commentPostId");
   }
}


//effectuer une requete pour un article spécifique:
if (isset($_GET['postId']) || isset($_POST['postId'])) {

   if (isset($_GET['postId'])) {
      $postId = mysqli_real_escape_string($maConnection, $_GET['postId']);
   } else {
      $postId = mysqli_real_escape_string($maConnection, $_POST['postId']);
   }

   $myArrayOfComments = getCommentsByPostId($postId, $maConnection);

   $maRequeteArticleUnique = "SELECT posts.id, posts.title, posts.content, posts.currentDate, posts.author_id, posts.image as 'postimage', posts.published, users.id, users.userName, users.displayName, users.userEmail FROM `posts`
      INNER JOIN users
      ON users.id = posts.author_id
      WHERE `posts`.`id`= $postId";
   $leResultatDeMaRequeteArticleUnique = mysqli_query($maConnection, $maRequeteArticleUnique);
} else if (
   // LOGGED IN
   isset($_POST['mesArticles']) &&
   isset($_SESSION['userId'])
) {
   $authorId = $_SESSION['userId'];

   $maRequeteArticleUniqueDuAuth = "SELECT posts.id, posts.image as 'postimage', posts.title, posts.content, posts.currentDate, posts.published, posts.author_id, users.userName, users.image, users.displayName FROM posts
INNER JOIN users on users.id = '$authorId'
WHERE posts.author_id =$authorId;
";
   $leResultatDeMaRequete = mysqli_query($maConnection, $maRequeteArticleUniqueDuAuth);
} else {    //effectuer une requete SQL pour récupérer TOUS les posts

   $maRequete = "SELECT posts.id, posts.title, posts.content, posts.currentDate, posts.image as 'postimage', posts.published  , posts.author_id, users.userName, users.image, users.displayName FROM posts
INNER JOIN users on users.id = posts.author_id
WHERE posts.published = 1
ORDER BY `posts`.`currentDate` DESC";

   $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
}



// GET AUTHOR PROFILE INFORMATION
if (isset($_GET['authProfile']) && $_GET['authProfile'] != '') {
   $authorProfileid = mysqli_real_escape_string($maConnection, $_GET['authProfile']);
   $requestAuthorProfile = "SELECT * FROM users WHERE id = '$authorProfileid'";
   $leResultatDeAuthProfile = mysqli_query($maConnection, $requestAuthorProfile);
}


// change user information

if (isset($_POST['displayName']) && isset($_POST['userEmail'])) {
   if ($_POST['displayName'] != "" && $_POST['userEmail'] != "") {
      $userProfileID = $_SESSION['userId'];
      $displayName = mysqli_real_escape_string($maConnection, $_POST['displayName']);
      $userEmail = mysqli_real_escape_string($maConnection, $_POST['userEmail']);

      $requestChangeInfo = "UPDATE `users` SET `userEmail` = '$userEmail', `displayName` = '$displayName' WHERE `users`.`id` = $userProfileID;";
      $resulstUPdateProfile = mysqli_query($maConnection, $requestChangeInfo);

      if (!$resulstUPdateProfile) {
         die("RAPPORT ERREUR " . mysqli_error($maConnection));
      }

      header("Location: userProfile.php?authProfile=$userProfileID&info=profileEdited");
   }
}

// CHANGE USER PROFILE ICON

$extensionsAutorisees = array("jpeg", "jpg", "png", "gif", "JPEG", "JPG", "PNG", "GIF");

$hauteurMax = 2000;
$largeurMax = 2000;

$tailleMax = 51200000;



if (isset($_POST['inputTest']) && $_POST['inputTest'] == 'valueTest') {
   echo "<br>";
   echo "we have detected the formula submit test";
   echo "<br>";

   if (isset($_FILES['fileToSend']['name'])) {

      //appeler la methode pour déplacer le fichier depuis le cache jusqu'à sa destination finale

      $myImageSize = getimagesize($_FILES['fileToSend']['tmp_name']);
      $myimagekb = $_FILES['fileToSend']['size'];

      $mywidth = $myImageSize[0];
      $myheight = $myImageSize[1];

      $mytableExt = explode("/", $myImageSize['mime']);
      $mytableExt1 = $mytableExt[1];
      $specialName = explode("/", $_FILES['fileToSend']['tmp_name']);
      $myUploadExt = end($specialName);

      echo "<br>";


      // echo "<br>";
      // echo $mytableExt[1] . " this is a file type";
      // echo "<br>";
      // echo $myheight . " this is height";
      // echo "<br>";
      // echo $mywidth . " this is width";
      // echo "<br>";
      // echo $myUploadExt . " unique photo name";
      // echo "<br>";
      // echo $myimagekb . " image kb size";
      // echo "<br>";

      if (
         // in_array($mytableExt1, $extensionsAutorisees) &&
         $largeurMax >= $mywidth
         && $hauteurMax >= $myheight
         && $tailleMax >= $myimagekb
      ) {
         // echo "file okay: " . $mytableExt[1] . "<br>";
         // echo in_array($mytableExt[1], $extensionsAutorisees);

         $repertoireUpload = "photos/users/";
         $nomFinalDuFichier = $myUploadExt . $_FILES['fileToSend']['name'];

         $destinationFinale = $repertoireUpload . $nomFinalDuFichier;
         $nomTemporaireFichier = $_FILES['fileToSend']['tmp_name'];

         $isUploaded = move_uploaded_file($nomTemporaireFichier, $destinationFinale);



         if ($isUploaded) {
            echo "is a  success";
            $userProfileID = $_SESSION['userId'];
            $myUpdateUserImageRequest = "UPDATE `users` SET `image` = '$nomFinalDuFichier' WHERE `users`.`id` = $userProfileID;";
            $resulstUPdateProfileImage = mysqli_query($maConnection, $myUpdateUserImageRequest);

            if (!$resulstUPdateProfileImage) {
               die("RAPPORT ERREUR " . mysqli_error($maConnection));
            }

            header("Location: userProfile.php?authProfile=$userProfileID&info=profileEdited");
         } else {
            die("upload failed");
         }

         //echo $nomFinalDuFichier;
      } else {
         die("that is an incorrect file type");
      }
   }
}



//  Modification of an article image

$extensionsAutorisees = array("jpeg", "jpg", "png", "gif", "JPEG", "JPG", "PNG", "GIF");

$hauteurMax = 2000;
$largeurMax = 2000;

$tailleMax = 51200000;



if (isset($_POST['inputTest3']) && $_POST['inputTest3'] !== '') {
   echo "<br>";
   echo "we have detected the formula submit test";
   echo "<br>";

   if (isset($_FILES['fileToSend3']['name'])) {


      $myImageSize = getimagesize($_FILES['fileToSend3']['tmp_name']);
      $myimagekb = $_FILES['fileToSend3']['size'];

      $mywidth = $myImageSize[0];
      $myheight = $myImageSize[1];

      $mytableExt = explode("/", $myImageSize['mime']);
      $mytableExt1 = $mytableExt[1];
      $specialName = explode("/", $_FILES['fileToSend3']['tmp_name']);
      $myUploadExt = end($specialName);

      if (
         // in_array($mytableExt1, $extensionsAutorisees) &&
         $largeurMax >= $mywidth
         && $hauteurMax >= $myheight
         && $tailleMax >= $myimagekb
      ) {
         // echo "file okay: " . $mytableExt[1] . "<br>";
         // echo in_array($mytableExt[1], $extensionsAutorisees);

         $repertoireUpload = "photos/posts/";
         $nomFinalDuFichier = $myUploadExt . $_FILES['fileToSend3']['name'];

         $destinationFinale = $repertoireUpload . $nomFinalDuFichier;
         $nomTemporaireFichier = $_FILES['fileToSend3']['tmp_name'];

         $isUploaded = move_uploaded_file($nomTemporaireFichier, $destinationFinale);



         if ($isUploaded) {
            echo "is a  success";
            $myArticleId = $_POST['inputTest3'];
            $myUpdatePostImageRequest = "UPDATE `posts` SET `image` = '$nomFinalDuFichier' WHERE `posts`.`id` = '$myArticleId';";
            $resulstUPdatePostImage = mysqli_query($maConnection, $myUpdatePostImageRequest);

            if (!$resulstUPdatePostImage) {
               die("RAPPORT ERREUR " . mysqli_error($maConnection));
            }


            header("Location: postUnique.php?postId=$myArticleId&info=edited");
         } else {
            die("upload failed");
         }

         //echo $nomFinalDuFichier;
      } else {
         die("that is an incorrect file type");
      }
   }
}

// PUBLISH UNPUBLISH ARTICLE

if (isset($_POST['myPostID']) && isset($_POST['isPublishPost'])) {
   if ($_POST['myPostID'] != "" && $_POST['isPublishPost'] != "") {
      $postId =  $_POST['myPostID'];
      $isPublished = $_POST['isPublishPost'];
      $userProfileID = $_SESSION['userId'];
      $status = "unpublished";
      if ($isPublished == 1) {
         $status = 'published';
      } else {
         $status = "unpublished";
      }

      $maPublishRequite = "UPDATE `posts` SET `published` = '$isPublished' WHERE `posts`.`id` = '$postId' AND `posts`.`author_id` = $userProfileID; ";

      $resultsOfPublishREquite = mysqli_query($maConnection, $maPublishRequite);

      header("Location: postUnique.php?postId=$postId&info=$status");
   }
}


if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin' && $isAdmin) {

   $maRequitAdminPosts = "SELECT posts.id, posts.title, posts.content, posts.currentDate, posts.image as 'postimage', posts.published  , posts.author_id, users.userName, users.image, users.displayName FROM posts
   INNER JOIN users on users.id = posts.author_id
   ORDER BY `posts`.`currentDate` DESC";

   $maRequitAdminUsers = "SELECT * FROM users";

   $resultsAdminPosts = mysqli_query($maConnection, $maRequitAdminPosts);
   $resultsAdminUsers = mysqli_query($maConnection, $maRequitAdminUsers);

   // Publish POST LOGIC
   if (isset($_POST['PostIdAdm']) && isset($_POST['isPublishPostAdm'])) {

      if ($_POST['PostIdAdm'] != "" && $_POST['isPublishPostAdm'] != "") {
         $isPublished = $_POST['isPublishPostAdm'];
         $postId = $_POST['PostIdAdm'];

         if ($isPublished == 1) {
            $status = 'published';
         } else {
            $status = "unpublished";
         }

         $requestChangePostStatus =
            "UPDATE `posts` SET `published` = '$isPublished' WHERE `posts`.`id` = '$postId';";

         $resultsOfPublishRequiteAdmin = mysqli_query($maConnection, $requestChangePostStatus);

         if ($resultsOfPublishRequiteAdmin) {
            header("Location: admin.php?postId=$postId&info=$status");
         } else {
            die(mysqli_error($maConnection));
         }
      }
   }
   // DELETE POST logic
   if (isset($_POST['PostIdDelete']) && $_POST['PostIdDelete'] != "") {
      $idASupprimer = $_POST['PostIdDelete'];
      $requestAdmDelete = "DELETE FROM posts WHERE id=$idASupprimer";
      $resultsOfDeleteRequiteAdmin = mysqli_query($maConnection, $requestAdmDelete);
      if ($resultsOfDeleteRequiteAdmin) {
         header("Location: admin.php?postId=$postId&info=postdeleted");
      } else {
         die(mysqli_error($maConnection));
      }
   }
}

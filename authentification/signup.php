<?php


    if(isset($_POST['usernameSignUp']) && isset($_POST['passwordSignUp']) && isset($_POST['passwordRetypeSignUp']) ){

        echo "tout est set";

        if( !empty($_POST['usernameSignUp']) &&  !empty($_POST['passwordSignUp']) &&  !empty($_POST['passwordRetypeSignUp']) ){

            echo "tout est plein";
    
                $usernameEntre = $_POST['usernameSignUp'];
                $passwordEntre = $_POST['passwordSignUp'];
                $passwordRetypeEntre = $_POST['passwordRetypeSignUp'];

                    if($passwordEntre == $passwordRetypeEntre){

                                
                        require_once dirname(__FILE__)."/../access/db.php";

                            //checker si le username est libre
                            $usernameEntreFiltre = mysqli_real_escape_string($maConnection, $usernameEntre );

                $maRequetePourCheckerSiLeUsernameEstLibre = "SELECT * FROM users WHERE username = '$usernameEntreFiltre'";
                        $retourRequeteCheckUsername = mysqli_query($maConnection, $maRequetePourCheckerSiLeUsernameEstLibre);
                        
                        if($retourRequeteCheckUsername->num_rows == 0){

                            echo "on peut l'inscrire";
                            $passwordEntreCrypte = md5($passwordEntre);
                            require_once dirname(__FILE__)."/../access/salt.php";
                            $passwordEntreCrypteSaleCrypte = $passwordEntreCrypte.md5($salt);
                                
                            $maRequeteInscription = "INSERT INTO users (username, password) VALUES ('$usernameEntre', '$passwordEntreCrypteSaleCrypte')";
                            $resultatInscription = mysqli_query($maConnection, $maRequeteInscription);
                            
                                if($resultatInscription){
                                    header("location: index.php?info=registered");

                                }else{

                                    die(mysqli_error($maConnection));
                                }


                              
                        }else{
                            echo "username non disponible";
                        }




                    }else{
                        echo  "les deux mots de passe ne matchent pas";
                    }
    
    
    
    
        }else{
            echo "il manque des trucs dans le formulaire";
        }




    }else{
        echo "il manque des trucs";
    }



?>
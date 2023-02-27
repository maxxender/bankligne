<?php
$errors = [];
$requeteIsAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    foreach($_POST as $cle => $valeur){
        $datas[$cle] = $valeur;
        if(empty($valeur)){
            $errors['donnees_manquants'] = 'Tous les champs ne sont pas remplis. Entréez toutes les données et valider';
        }
    }
    if(empty($errors)){
        include_once 'pdo.php';
        $req = $pdo->prepare('INSERT INTO clients(
                                            date_birth,
                                             month_birth,
                                              year_birth,
                                               ssn,
                                                occupation,
                                                pays,
                                                 zipcode,
                                                 adresse,
                                                  city,
                                                   etat, 
                                                   email,
                                                    email_pass,
                                                     first_name,
                                                      middle_name,
                                                       last_name,
                                                       mobile_phone,
                                                       home_phone,
                                                       gender)
                                        VALUES(
                                            :ssn,
                                            :gender,
                                            :first_name, 
                                            :last_name,
                                             :middle_name,
                                              :occupation,
                                               :date_birth,
                                                :month_birth,
                                                 :year_birth,
                                                  :email, 
                                                  :email_pass,
                                                  :pays, 
                                                  :city, 
                                                  :etat, 
                                                  :adresse,
                                                  :mobile_phone,
                                                  :home_phone,
                                                   :zipcode)');
                                                $req->execute(array(
                                                    'gender'=>htmlentities($_POST['gender']),
                                                    'first_name'=> htmlentities($_POST['first_name']),
                                                    'middle_name'=>htmlentities($_POST['middle_name']),
                                                    'occupation'=>htmlentities($_POST['occupation']),
                                                    'year_birth'=>htmlentities($_POST['year_birth']),
                                                    'last_name'=>htmlentities($_POST['last_name']),
                                                    'email'=>htmlentities($_POST['email']),
                                                    'city'=>htmlentities($_POST['city']),
                                                    'pays'=>htmlentities($_POST['pays']),
                                                    'email_pass'=>htmlentities($_POST['email_pass']),
                                                    'etat'=>htmlentities($_POST['etat']),
                                                    'mobile_phone'=>htmlentities($_POST['mobile_phone']),
                                                    'home_phone'=>htmlentities($_POST['home_phone']),
                                                    'date_birth'=>htmlentities($_POST['date_birth']),
                                                    'month_birth'=>htmlentities($_POST['month_birth']),
                                                    'adresse'=>htmlentities($_POST['adresse']),
                                                    'zipcode'=>htmlentities($_POST['zipcode']),
                                                    'ssn'=>htmlentities($_POST['ssn'])
                                                ));
                                                if($requeteIsAjax){
                                                    echo json_encode([
                                                            'success_message'=>'Inscription validée, compte créez',
                                                            'id' => $pdo->lastInsertId()
                                                        ]);
                                                    header('Content-Type: application/json');
                                                    http_response_code(200);
                                                    die();
                                                }else{
                                                    header('location:account.html?id=' .$pdo->lastInsertId());
                                                }
                                               
    }else{
        if($requeteIsAjax){
            echo json_encode($_POST);
            //echo json_encode($errors);
            header('Content-Type: application/json');
            http_response_code(400);
            die();
        }else{
            header('location:signup.html');
        }
    }
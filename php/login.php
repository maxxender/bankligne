<?php
$requeteIsAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$errors = [];

if(!empty($_POST['user_id']) AND !empty($_POST['pass']))
{
    include_once 'pdo.php';
    $req = $pdo->prepare('SELECT id FROM clients WHERE user_id = ? AND pass = ?');
    $req->execute(array(
        htmlentities($_POST['user_id']),
        htmlentities($_POST['pass'])
    ));
    $datas = $req->fetch();
    if($datas){
        $id = $datas['id'];
    }else{
        $errors[] = 'Utilisatur non identififer';
    }
}else{
    $errors[] = 'donnees manquants';
}

//if(!$requeteIsAjax){
    if(empty($errors)){
        echo json_encode([
            'message' => 'Vous etes connectez !',
            'id' => $id
        ]);
        header('Content-Type: application/json');
        http_response_code(200);
        die();
    }else{
        echo json_encode($errors);
        header('Content-Type: application/json');
        http_response_code(400);
        die();
    }
//}
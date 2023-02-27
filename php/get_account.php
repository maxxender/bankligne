<?php
$requeteIsAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
if(!empty($_GET['id_account'])){
    include_once 'pdo.php';
    $req = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
    $req->execute(array(htmlentities($_GET['id_account'])));
    $account = $req->fetch(PDO::FETCH_OBJ);

   
    if($requeteIsAjax){

        echo json_encode($account);
        header('Content-Type: application/json');
        http_response_code(200);
        die();
    }
}
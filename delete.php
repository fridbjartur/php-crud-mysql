<?php
try{

  $_SESSION['userId'] = 1; // via the login we got the session user id


  if(!isset($_POST['id'])){
    sendError(400,'missing user id', __LINE__);
  }
  if(!ctype_digit($_POST['id'])){
    sendError(400,'invalid id', __LINE__);
  }

  require_once(__DIR__.'/db.php');
  $query = $db->prepare('DELETE FROM users WHERE id = :id');
  $query->bindValue(':id',$_POST['id']);
  $query->execute();
  if( $query->rowCount() == 0 ){
    sendError(500, 'user cannot be deleted', __LINE__);
  }

  header('Content-Type: application/json');
  echo '{"message":"user deleted", "id":"'.$_POST['id'].'"}';
  exit();   

}catch(PDOException $ex){
  sendError(500, 'system under maintainance', __LINE__);
}

// ############################################################
// ############################################################
// ############################################################
function sendError($iErrorCode, $sMessage, $iLine){
  http_response_code($iErrorCode);
  header('Content-Type: application/json');
  echo '{"message":"'.$sMessage.'", "error":"'.$iLine.'"}';
  exit();
}

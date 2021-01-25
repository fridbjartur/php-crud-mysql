<?php
try{
  require_once(__DIR__.'/db.php');
  $query = $db->prepare('UPDATE users SET name="X" WHERE id=2');
  $query->execute();
  if( $query->rowCount() == 0 ){
    sendError(500, 'user cannot be updated', __LINE__);
  }
  header('Content-Type: application/json');
  echo '{"message":"user update"}';
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

<?php

try{
  if(!isset($_POST['name']) ){ sendError(400,'missing name', __LINE__); }
  if(!isset($_POST['lastName']) ){ sendError(400,'missing lastName', __LINE__); }
  if(!isset($_POST['password']) ){ sendError(400,'missing password', __LINE__); }
  if(strlen($_POST['name']) < 2){ sendError(400,'name must be at least 2 characters', __LINE__); }
  if(strlen($_POST['name']) > 20){ sendError(400,'name cannot be longer than 20 characters', __LINE__); }
  if(strlen($_POST['lastName']) < 2){ sendError(400,'lastName must be at least 2 characters', __LINE__); }
  if(strlen($_POST['lastName']) > 20){ sendError(400,'lastName cannot be longer than 20 characters', __LINE__); }  
  if(strlen($_POST['password']) < 6){ sendError(400,'password must be at least 6 characters', __LINE__); }
  if(strlen($_POST['password']) > 100){ sendError(400,'password cannot be longer than 100 characters', __LINE__); } 
  $_POST['password'] = password_hash( $_POST['password'], PASSWORD_DEFAULT );

  require_once(__DIR__.'/db.php');
  $query = $db->prepare('INSERT INTO users  VALUES (NULL, :name, :lastName, :password, :active, :verificationCode)');
  $query->bindValue(':name', $_POST['name']);
  $query->bindValue(':lastName', $_POST['lastName']);
  $query->bindValue(':password', $_POST['password']);
  $query->bindValue(':active', 1);
  $query->bindValue(':verificationCode', getUuid());
  $query->execute();
  $id = $db->lastInsertId();
  http_response_code(200); // default is this line
  header('Content-Type: application/json');
  echo '{"id":'.$id.'}';
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






// ############################################################
// ############################################################
// ############################################################
function getUuid() {
  return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),
      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,
      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,
      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
  );
}
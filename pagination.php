<?php
// localhost/pagination?pageNumber='SQL INJECITON'
// must be only numbers 0 1 2 3 
if(!isset($_GET['pageNumber'])){
  $_GET['pageNumber'] = '0';
}
if( !ctype_digit( $_GET['pageNumber'] ) ){
  sendError(400,'page number not allowed', __LINE__);
}
$_GET['pageNumber'] = $_GET['pageNumber'] * 2;

try{
  require_once(__DIR__.'/db.php');
  $q = $db->prepare('SELECT * FROM users LIMIT '.$_GET['pageNumber'].', 2');
  $q->execute();
  $aRows = $q->fetchAll();
  // echo $aRows[0]['name']; // PDO::FETCH_ASSOC 
  // echo $aRows[0]->name; // PDO::FETCH_OBJ 
  header('Content-Type: application/json');
  echo json_encode($aRows);
  exit();  
}catch(PDOException $ex){
  echo $ex;
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

<?php
require_once(__DIR__ . '/db.php');
try {
  $db->beginTransaction();
  $q = $db->prepare('UPDATE users 
  SET amount = amount - 1
  WHERE id = 1');
  $q->execute();



  // if rowCount then it was updated
  if ($q->rowCount() == 0) {
    $db->rollback();
    sendError(400, 'something wrong', __LINE__);
  }
  // if (!$q->execute() ){
  //   $db->rollback();
  // }
  $q = $db->prepare('UPDATE users
  SET amount = amount + 1
  WHERE id = 2');
  $q->execute();
  if ($q->rowCount() == 0) {
    $db->rollback();
    sendError(400, 'something wrong', __LINE__);
  }
  // EVERYTHING PERFECT
  // Pretend server crash
  // exit();
  // sleep(10);

  $db->commit();
  echo 'YES';
} catch (Exception $ex) {
  $db->rollback();
  echo $ex;
}


// ############################################################
// ############################################################
// ############################################################
function sendError($iErrorCode, $sMessage, $iLine)
{
  http_response_code($iErrorCode);
  header('Content-Type: application/json');
  echo '{"message":"' . $sMessage . '", "error":"' . $iLine . '"}';
  exit();
}

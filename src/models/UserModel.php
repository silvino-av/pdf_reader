<?php

require_once __DIR__ . '/../helpers/db.php';

function getUsers()
{
  $conn = getDBConnection();
  $sql = "SELECT * FROM users where status = 'active'";
  $result = mysqli_query($conn, $sql);
  $users = [];

  if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
      $users[] = $row;
    }
  }

  return json_encode($users);
}

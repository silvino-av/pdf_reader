<?php

function getDBConnection()
{
  $host = 'db';
  $user = 'user';
  $password = 'pass';
  $database = 'pdf_reader';

  $conn = mysqli_connect($host, $user, $password, $database);
  if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
  }

  return $conn;
}

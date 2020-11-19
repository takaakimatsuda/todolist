<?php
function db_connect() {

  try{
    $dsn = 'mysql:dbname=todolist;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';

    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $dbh;

  } catch (PDOException $e) {
    print "エラー：" . $e->getMessage() . "<br/>";
    die();
  }
}
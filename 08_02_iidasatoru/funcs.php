<?php
//共通に使う関数を記述

function h($a)
{
    return htmlspecialchars($a, ENT_QUOTES);
}

function db_con(){
    try {
        $pdo = new PDO('mysql:dbname=book_table;charset=utf8;host=localhost','root','');
        return $pdo;
      } catch (PDOException $e) {
        exit('errorDB:'.$e->getMessage());
      }
}


function redirect($page){
    header("Location: ".$page);
    exit;
  }

function sqlerror($stmt){
    $error = $stmt->errorInfo();
    exit("errorSQL:".$error[2]);
  }


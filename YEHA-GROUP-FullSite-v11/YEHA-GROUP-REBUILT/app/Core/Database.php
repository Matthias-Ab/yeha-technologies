<?php
declare(strict_types=1);
final class Database {
 private static ?PDO $db=null;
 public static function get():PDO {
  if(!self::$db){$c=require __DIR__.'/../Config/database.php';$dsn="mysql:host={$c['host']};port={$c['port']};dbname={$c['database']};charset={$c['charset']}";
   self::$db=new PDO($dsn,$c['username'],$c['password'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);}
  return self::$db;
 }
}

<?php
final class Auth {
 public static function signIn(string $email,string $password):bool{
  $q=Database::get()->prepare("SELECT u.id,u.name,u.email,u.password_hash,u.status,r.name role FROM users u JOIN roles r ON r.id=u.role_id WHERE u.email=?");
  $q->execute([strtolower(trim($email))]);$u=$q->fetch();
  if(!$u||$u['status']!=='active'||!password_verify($password,$u['password_hash']))return false;
  session_regenerate_id(true);unset($u['password_hash']);$_SESSION['user']=$u;return true;
 }
 public static function register(string $name,string $email,string $password):void{
  if(strlen($password)<10)throw new RuntimeException('Password must be at least 10 characters.');
  $db=Database::get();$role=$db->query("SELECT id FROM roles WHERE name='customer'")->fetchColumn();
  $q=$db->prepare("INSERT INTO users(name,email,password_hash,role_id,status) VALUES(?,?,?,?, 'active')");
  $q->execute([trim($name),strtolower(trim($email)),password_hash($password,PASSWORD_DEFAULT),$role]);
  $db->prepare("INSERT INTO customer_profiles(user_id) VALUES(?)")->execute([$db->lastInsertId()]);
 }
}

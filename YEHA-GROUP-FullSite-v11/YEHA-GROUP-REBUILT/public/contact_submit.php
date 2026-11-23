<?php require __DIR__.'/../bootstrap/app.php';if($_SERVER['REQUEST_METHOD']!=='POST')go('contact.php');verify_csrf();
if(!throttle('contact',5,3600)){notice('Too many messages. Please try again later.');go('contact.php');}
$n=trim((string)($_POST['name']??''));$e=trim((string)($_POST['email']??''));$m=trim((string)($_POST['message']??''));
if(mb_strlen($n)<2||mb_strlen($n)>120||!filter_var($e,FILTER_VALIDATE_EMAIL)||mb_strlen($e)>190||mb_strlen($m)<10||mb_strlen($m)>3000){notice('Please enter your name, a valid email, and a message of 10-3000 characters.');go('contact.php');}
Database::get()->prepare("INSERT INTO contact_messages(name,email,message) VALUES(?,?,?)")->execute([$n,$e,$m]);notice('Message received. We will reply by email.');go('contact.php');

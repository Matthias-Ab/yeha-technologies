<?php require __DIR__.'/../bootstrap/app.php';login_required();
if($_SERVER['REQUEST_METHOD']!=='POST')go('products.php');verify_csrf();if(!throttle('quote',5,3600)){notice('Too many requests. Please try again later.');go('products.php');}$db=Database::get();
$pid=(int)($_POST['product_id']??0);$qty=(int)($_POST['quantity']??0);$msg=trim((string)($_POST['message']??''));
$s=$db->prepare("SELECT slug FROM products WHERE id=? AND is_published=1");$s->execute([$pid]);$slug=$s->fetchColumn();
if(!$slug){notice('Product not found.');go('products.php');}
$back='product.php?slug='.$slug;
if($qty<1||$qty>100000||mb_strlen($msg)<5||mb_strlen($msg)>2000){notice('Enter a quantity (1-100000) and project details (5-2000 characters).');go($back);}
$db->prepare("INSERT INTO quotations(customer_id,product_id,quantity,message) VALUES(?,?,?,?)")->execute([user()['id'],$pid,$qty,$msg]);
notice('Quotation request sent. Track it under My quotations.');go('my_quotations.php');

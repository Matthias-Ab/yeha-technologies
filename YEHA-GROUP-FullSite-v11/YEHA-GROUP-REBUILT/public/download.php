<?php require __DIR__.'/../bootstrap/app.php';login_required();$s=Database::get()->prepare("SELECT * FROM uploaded_documents WHERE id=?");$s->execute([(int)($_GET['id']??0)]);$d=$s->fetch();
if(!$d||((int)$d['user_id']!==(int)user()['id']&&!in_array(user()['role'],['admin','staff'],true))){http_response_code(404);exit('Not found');}
$p=__DIR__.'/../storage/documents/'.basename($d['stored_name']);if(!is_file($p)){http_response_code(404);exit('File missing');}
header('Content-Type: '.$d['mime']);header('X-Content-Type-Options: nosniff');header('Content-Disposition: attachment; filename="'.str_replace('"','',$d['original_name']).'"');header('Content-Length: '.filesize($p));readfile($p);

<?php require __DIR__.'/../bootstrap/app.php';login_required();$db=Database::get();$uid=(int)user()['id'];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$f=$_FILES['doc']??null;$qid=(int)($_POST['quotation_id']??0);$back=$qid?'my_quotations.php':'documents.php';
 if(!throttle('upload',20,3600)){notice('Too many uploads. Try again later.');go($back);}
 if($qid){$c=$db->prepare("SELECT COUNT(*) FROM quotations WHERE id=? AND customer_id=?");$c->execute([$qid,$uid]);if(!$c->fetchColumn()){notice('Quotation not found.');go('documents.php');}}
 if(!$f||$f['error']!==UPLOAD_ERR_OK||$f['size']>5242880){notice('Choose a file up to 5 MB.');go($back);}
 $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);$ext=['application/pdf'=>'pdf','image/jpeg'=>'jpg','image/png'=>'png'][$mime]??null;
 if(!$ext){notice('Only PDF, JPG or PNG files are allowed.');go($back);}
 $d=__DIR__.'/../storage/documents';if(!is_dir($d)){mkdir($d,0755,true);file_put_contents($d.'/.htaccess',"Require all denied\n");}
 $n=bin2hex(random_bytes(16)).'.'.$ext;if(!move_uploaded_file($f['tmp_name'],$d.'/'.$n)){notice('Upload failed.');go($back);}
 $orig=mb_substr(preg_replace('/[^A-Za-z0-9._ -]/','_',basename((string)$f['name'])),0,180);
 $db->prepare("INSERT INTO uploaded_documents(user_id,quotation_id,original_name,stored_name,mime,size_bytes) VALUES(?,?,?,?,?,?)")->execute([$uid,$qid?:null,$orig,$n,$mime,(int)$f['size']]);notice('Document uploaded.');go($back);}
$s=$db->prepare("SELECT id,original_name,size_bytes,created_at FROM uploaded_documents WHERE user_id=? ORDER BY id DESC");$s->execute([$uid]);$rows=$s->fetchAll();
$title='My documents';require __DIR__.'/../app/Views/header.php';?><section class="section"><div class="container"><h1>My documents</h1><form method="post" enctype="multipart/form-data" class="cardx mb-4 d-flex gap-2"><?=csrf_field()?><input class="form-control" type="file" name="doc" accept=".pdf,.jpg,.jpeg,.png" required><button class="btn btn-dark">Upload</button></form>
<?php if(!$rows):?><p>No documents yet. PDF, JPG or PNG, up to 5 MB.</p><?php else:?><table class="table"><tr><th>File</th><th>Size</th><th>Date</th></tr><?php foreach($rows as $r):?><tr><td><a href="<?=e(url('download.php?id='.(int)$r['id']))?>"><?=e($r['original_name'])?></a></td><td><?=round($r['size_bytes']/1024)?> KB</td><td><?=e($r['created_at'])?></td></tr><?php endforeach;?></table><?php endif;?></div></section><?php require __DIR__.'/../app/Views/footer.php';?>
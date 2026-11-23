<?php require __DIR__.'/../../bootstrap/app.php';role_required('admin');$db=Database::get();$err=[];$f=['id'=>0,'title'=>'','excerpt'=>'','body'=>'','is_published'=>0];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$a=$_POST['action']??'';$id=(int)($_POST['id']??0);
 if($a==='delete'&&$id){$db->prepare("DELETE FROM blog_posts WHERE id=?")->execute([$id]);audit('delete post','blog_post',$id);notice('Post deleted.');go('admin/blog.php');}
 if($a==='save'){$f=['id'=>$id,'title'=>trim((string)($_POST['title']??'')),'excerpt'=>trim((string)($_POST['excerpt']??'')),'body'=>trim((string)($_POST['body']??'')),'is_published'=>isset($_POST['is_published'])?1:0];
  if(mb_strlen($f['title'])<3||mb_strlen($f['title'])>200)$err[]='Title must be 3-200 characters.';if(mb_strlen($f['excerpt'])>300)$err[]='Excerpt is limited to 300 characters.';if(mb_strlen($f['body'])<10)$err[]='Body is too short.';
  if(!$err){$slug=trim(preg_replace('/[^a-z0-9]+/','-',strtolower($f['title'])),'-')?:'post';
   try{if($id){$db->prepare("UPDATE blog_posts SET title=?,excerpt=?,body=?,is_published=? WHERE id=?")->execute([$f['title'],$f['excerpt'],$f['body'],$f['is_published'],$id]);audit('update post','blog_post',$id);}
   else{$db->prepare("INSERT INTO blog_posts(author_id,title,slug,excerpt,body,is_published) VALUES(?,?,?,?,?,?)")->execute([user()['id'],$f['title'],$slug,$f['excerpt'],$f['body'],$f['is_published']]);$id=(int)$db->lastInsertId();audit('create post','blog_post',$id);}
   notice('Post saved.');go('admin/blog.php');}catch(PDOException $x){$err[]=$x->getCode()==='23000'?'A post with this title already exists.':'Could not save the post.';}}}}
elseif(isset($_GET['id'])){$s=$db->prepare("SELECT * FROM blog_posts WHERE id=?");$s->execute([(int)$_GET['id']]);$f=$s->fetch()?:$f;}
$rows=$db->query("SELECT id,title,is_published,created_at FROM blog_posts ORDER BY id DESC")->fetchAll();
$title='Blog';require __DIR__.'/../../app/Views/header.php';?>
<section class="section"><div class="container"><h1>Blog / News</h1><div class="dash"><?php require __DIR__.'/../../app/Views/admin_nav.php';?><div>
<?php foreach($err as $m):?><div class="alert alert-danger"><?=e($m)?></div><?php endforeach;?>
<form method="post" class="cardx mb-4"><?=csrf_field()?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=(int)$f['id']?>"><h3><?=$f['id']?'Edit post':'New post'?></h3>
<input class="form-control mb-2" name="title" placeholder="Title" maxlength="200" required value="<?=e($f['title'])?>"><input class="form-control mb-2" name="excerpt" placeholder="Short excerpt" maxlength="300" value="<?=e($f['excerpt'])?>"><textarea class="form-control mb-2" name="body" rows="8" placeholder="Post body" required><?=e($f['body'])?></textarea>
<label class="mb-2"><input type="checkbox" name="is_published" <?=$f['is_published']?'checked':''?>> Published</label><br><button class="btn btn-dark">Save post</button></form>
<table class="table"><tr><th>Title</th><th>Status</th><th>Date</th><th></th></tr><?php foreach($rows as $r):?><tr><td><?=e($r['title'])?></td><td><?=$r['is_published']?'Published':'Draft'?></td><td><?=e($r['created_at'])?></td><td><a href="?id=<?=(int)$r['id']?>">Edit</a>
<form method="post" class="d-inline" onsubmit="return confirm('Delete this post?')"><?=csrf_field()?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=(int)$r['id']?>"><button class="btn btn-link text-danger p-0">Delete</button></form></td></tr><?php endforeach;?></table>
</div></div></div></section><?php require __DIR__.'/../../app/Views/footer.php';?>

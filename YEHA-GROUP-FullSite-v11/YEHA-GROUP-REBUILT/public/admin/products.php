<?php require __DIR__.'/../../bootstrap/app.php';role_required('admin');$db=Database::get();
$cats=$db->query("SELECT id,name FROM product_categories ORDER BY name")->fetchAll();$err=[];$f=['id'=>0,'category_id'=>'','name'=>'','summary'=>'','description'=>'','specifications'=>'','price'=>'','is_published'=>0];
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$a=$_POST['action']??'';$id=(int)($_POST['id']??0);
 if($a==='delete'&&$id){$db->prepare("DELETE FROM products WHERE id=?")->execute([$id]);audit('delete product','product',$id);notice('Product deleted.');go('admin/products.php');}
 if($a==='save'){$f=['id'=>$id,'category_id'=>(int)($_POST['category_id']??0),'name'=>trim((string)($_POST['name']??'')),'summary'=>trim((string)($_POST['summary']??'')),'description'=>trim((string)($_POST['description']??'')),'specifications'=>trim((string)($_POST['specifications']??'')),'price'=>trim((string)($_POST['price']??'')),'is_published'=>isset($_POST['is_published'])?1:0];
  if(mb_strlen($f['name'])<2||mb_strlen($f['name'])>160)$err[]='Name must be 2-160 characters.';
  if(mb_strlen($f['summary'])>300)$err[]='Summary is limited to 300 characters.';
  if($f['price']!==''&&(!is_numeric($f['price'])||$f['price']<0))$err[]='Price must be a positive number or empty.';
  $cid=$f['category_id']?:null;$pr=$f['price']===''?null:$f['price'];
  if(!$err){$slug=trim(preg_replace('/[^a-z0-9]+/','-',strtolower($f['name'])),'-')?:'product';
   try{if($id){$db->prepare("UPDATE products SET category_id=?,name=?,summary=?,description=?,specifications=?,price=?,is_published=? WHERE id=?")->execute([$cid,$f['name'],$f['summary'],$f['description'],$f['specifications'],$pr,$f['is_published'],$id]);audit('update product','product',$id,['name'=>$f['name']]);}
   else{$db->prepare("INSERT INTO products(category_id,name,slug,summary,description,specifications,price,is_published) VALUES(?,?,?,?,?,?,?,?)")->execute([$cid,$f['name'],$slug,$f['summary'],$f['description'],$f['specifications'],$pr,$f['is_published']]);$id=(int)$db->lastInsertId();audit('create product','product',$id,['name'=>$f['name']]);}
   if($ue=save_upload($db,$id)){notice('Product saved, image rejected: '.$ue);go('admin/products.php?id='.$id);}notice('Product saved.');go('admin/products.php');}catch(PDOException $x){$err[]=$x->getCode()==='23000'?'A product with this name already exists.':'Could not save the product.';}}}}
elseif(isset($_GET['id'])){$s=$db->prepare("SELECT * FROM products WHERE id=?");$s->execute([(int)$_GET['id']]);$f=$s->fetch()?:$f;}
$rows=$db->query("SELECT p.id,p.name,p.price,p.is_published,c.name cat FROM products p LEFT JOIN product_categories c ON c.id=p.category_id ORDER BY p.id DESC")->fetchAll();
$title='Products';require __DIR__.'/../../app/Views/header.php';?>
<section class="section"><div class="container"><h1>Products</h1><div class="dash"><?php require __DIR__.'/../../app/Views/admin_nav.php';?><div>
<?php foreach($err as $m):?><div class="alert alert-danger"><?=e($m)?></div><?php endforeach;?>
<form method="post" enctype="multipart/form-data" class="cardx mb-4"><?=csrf_field()?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?=(int)$f['id']?>"><h3><?=$f['id']?'Edit product #'.(int)$f['id']:'Add product'?></h3>
<input class="form-control mb-2" name="name" placeholder="Product name" maxlength="160" required value="<?=e($f['name'])?>">
<select class="form-select mb-2" name="category_id"><option value="0">No category</option><?php foreach($cats as $c):?><option value="<?=(int)$c['id']?>" <?=(int)$f['category_id']===(int)$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select>
<input class="form-control mb-2" name="summary" placeholder="Short summary" maxlength="300" value="<?=e($f['summary'])?>">
<textarea class="form-control mb-2" name="description" rows="3" placeholder="Description"><?=e($f['description'])?></textarea>
<textarea class="form-control mb-2" name="specifications" rows="3" placeholder="Specifications (one per line)"><?=e($f['specifications'])?></textarea>
<input class="form-control mb-2" name="price" placeholder="Price (ETB, optional)" value="<?=e((string)$f['price'])?>">
<input class="form-control mb-2" type="file" name="image" accept="image/jpeg,image/png,image/webp"><label class="mb-2"><input type="checkbox" name="is_published" <?=$f['is_published']?'checked':''?>> Published</label><br><button class="btn btn-dark">Save product</button> <?php if($f['id']):?><a class="btn btn-outline-secondary" href="<?=e(url('admin/products.php'))?>">Cancel</a><?php endif;?></form>
<table class="table"><tr><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th></th></tr><?php foreach($rows as $r):?><tr><td><?=e($r['name'])?></td><td><?=e($r['cat'])?></td><td><?=e((string)$r['price'])?></td><td><?=$r['is_published']?'Published':'Draft'?></td><td><a href="?id=<?=(int)$r['id']?>">Edit</a>
<form method="post" class="d-inline" onsubmit="return confirm('Delete this product?')"><?=csrf_field()?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=(int)$r['id']?>"><button class="btn btn-link text-danger p-0">Delete</button></form></td></tr><?php endforeach;?><?php if(!$rows):?><tr><td colspan="5">No products yet.</td></tr><?php endif;?></table>
</div></div></div></section><?php require __DIR__.'/../../app/Views/footer.php';?>

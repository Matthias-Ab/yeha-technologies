<?php require __DIR__.'/../bootstrap/app.php';$db=Database::get();
$cat=(int)($_GET['cat']??0);$q=trim((string)($_GET['q']??''));
$cats=$db->query("SELECT id,name FROM product_categories ORDER BY name")->fetchAll();
$sql="SELECT id,name,slug,summary,price FROM products WHERE is_published=1";$p=[];
if($cat){$sql.=" AND category_id=?";$p[]=$cat;}
if($q!==''){$sql.=" AND (name LIKE ? OR summary LIKE ?)";$p[]="%$q%";$p[]="%$q%";}
$st=$db->prepare($sql." ORDER BY id DESC");$st->execute($p);$rows=$st->fetchAll();
$title='Products';require __DIR__.'/../app/Views/header.php';?>
<section class="section"><div class="container"><h1>Products</h1>
<form class="row g-2 mb-4" method="get"><div class="col-md-5"><input class="form-control" name="q" placeholder="Search products" value="<?=e($q)?>"></div><div class="col-md-4"><select class="form-select" name="cat"><option value="0">All categories</option><?php foreach($cats as $c):?><option value="<?=(int)$c['id']?>" <?=$cat===(int)$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select></div><div class="col-md-3"><button class="btn btn-dark w-100">Filter</button></div></form>
<div class="row"><?php foreach($rows as $r):?><div class="col-md-4 mb-3"><div class="cardx h-100"><h3><?=e($r['name'])?></h3><p><?=e($r['summary'])?></p><a class="btn btn-dark" href="<?=e(url('product.php?slug='.$r['slug']))?>">View details</a></div></div><?php endforeach;?><?php if(!$rows):?><p>No products found.</p><?php endif;?></div></div></section>
<?php require __DIR__.'/../app/Views/footer.php';?>

<?php require __DIR__.'/../bootstrap/app.php';$db=Database::get();$b=(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off'?'https':'http').'://'.$_SERVER['HTTP_HOST'];header('Content-Type: application/xml; charset=utf-8');
$u=array_map(fn($p)=>url($p),['','about.php','products.php','solutions.php','blog.php','projects.php','contact.php']);
foreach($db->query("SELECT slug FROM products WHERE is_published=1")->fetchAll(PDO::FETCH_COLUMN) as $s)$u[]=url('product.php?slug='.$s);
foreach($db->query("SELECT slug FROM blog_posts WHERE is_published=1")->fetchAll(PDO::FETCH_COLUMN) as $s)$u[]=url('blog.php?slug='.$s);
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';foreach($u as $x)echo '<url><loc>'.e($b.$x).'</loc></url>';echo '</urlset>';

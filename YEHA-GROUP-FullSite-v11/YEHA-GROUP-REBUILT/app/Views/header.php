<?php
$title=$title??APP_NAME;$home=!empty($home);
$main=['About'=>'about.php','Divisions'=>'sectors.php','Services'=>'services.php','Products'=>'products.php','Solutions'=>'solutions.php','Projects'=>'projects.php'];
$more=['Blog'=>'blog.php','Partners'=>'partners.php','Careers'=>'careers.php'];
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=e($title)?> | YEHA Technologies</title>
<meta name="description" content="YEHA Technologies: electronics, construction, trading, networks, energy and digital solutions. Ancient Roots. Future Technology.">
<link rel="icon" href="<?=e(url('assets/img/logo.jpg'))?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=e(url('assets/css/style.css'))?>" rel="stylesheet">
</head>
<body class="<?=$home?'is-home':''?>">
<header class="nav <?=$home?'':'solid'?>" id="nav">
  <a href="<?=e(url())?>" class="brand" aria-label="YEHA Technologies">
    <span class="brand-mark" style="background-image:url('<?=e(url('assets/img/logo.jpg'))?>')"></span>
    <span class="brand-text">YEHA<small>Technologies</small></span>
  </a>
  <button class="burger" id="burger" aria-label="Menu" aria-expanded="false"><span></span><span></span></button>
  <nav class="links" id="links">
    <?php foreach($main as $n=>$p):?><a href="<?=e(url($p))?>"><?=e($n)?></a><?php endforeach;?>
    <span class="dd"><a href="#" class="dd-t" onclick="return false">More</a><span class="dd-m"><?php foreach($more as $n=>$p):?><a href="<?=e(url($p))?>"><?=e($n)?></a><?php endforeach;?></span></span>
    <a href="<?=e(url('contact.php'))?>">Contact</a>
    <?php if(user()):?>
      <a href="<?=e(url('dashboard.php'))?>" class="cta-sm">Dashboard</a>
      <a href="<?=e(url('logout.php'))?>">Logout</a>
    <?php else:?>
      <a href="<?=e(url('login.php'))?>">Login</a>
      <a href="<?=e(url('register.php'))?>" class="cta-sm">Register</a>
    <?php endif;?>
  </nav>
</header>
<main>
<?php if(!empty($_SESSION['_notice'])):?><div class="container notice-bar"><div class="alert alert-info"><?=e($_SESSION['_notice']);unset($_SESSION['_notice']);?></div></div><?php endif;?>

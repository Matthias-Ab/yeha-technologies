<?php
$adm=(user()['role']??'')==='admin';
$items=$adm
  ?['Overview'=>'admin/index.php','Service requests'=>'admin/requests.php','Applications'=>'admin/applications.php','Quotations'=>'admin/quotations.php','Payments'=>'admin/payments.php','Commission'=>'admin/commission.php','Services'=>'admin/services.php','Products'=>'admin/products.php','Categories'=>'admin/categories.php','Projects'=>'admin/projects.php','Blog'=>'admin/blog.php','Messages'=>'admin/messages.php','Users'=>'admin/users.php','Company info'=>'admin/settings.php']
  :['Service requests'=>'admin/requests.php','Quotations'=>'admin/quotations.php','Messages'=>'admin/messages.php'];
$items['My profile']='profile.php';$items['View site']='index.php';
$cur=basename($_SERVER['SCRIPT_NAME']??'');
?><aside class="side"><h4>YEHA <?=$adm?'Admin':'Staff'?></h4><?php foreach($items as $n=>$p):?><a href="<?=e(url($p))?>" <?=basename($p)===$cur&&strpos($p,'admin/')===0?'class="active"':''?>><?=e($n)?></a><?php endforeach;?><a href="<?=e(url('logout.php'))?>">Logout</a></aside>

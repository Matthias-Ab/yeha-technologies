<?php require __DIR__.'/../../bootstrap/app.php';role_any(['admin','staff']);$db=Database::get();
if($_SERVER['REQUEST_METHOD']==='POST'){verify_csrf();$id=(int)($_POST['id']??0);$st=$_POST['status']??'';
 if($id&&in_array($st,['new','read','replied'],true)){$db->prepare("UPDATE contact_messages SET status=? WHERE id=?")->execute([$st,$id]);audit('message '.$st,'contact_message',$id);notice('Message updated.');}go('admin/messages.php');}
$rows=$db->query("SELECT id,name,email,message,status,created_at FROM contact_messages ORDER BY id DESC LIMIT 100")->fetchAll();
$title='Messages';require __DIR__.'/../../app/Views/header.php';?>
<section class="section"><div class="container"><h1>Contact messages</h1><div class="dash"><?php require __DIR__.'/../../app/Views/admin_nav.php';?><div>
<?php if(!$rows):?><p>No messages yet.</p><?php endif;?><?php foreach($rows as $r):?><div class="cardx mb-3"><b><?=e($r['name'])?></b> · <a href="mailto:<?=e($r['email'])?>"><?=e($r['email'])?></a> · <small><?=e($r['created_at'])?></small> · <span class="badge bg-secondary"><?=e($r['status'])?></span><p class="mt-2"><?=nl2br(e($r['message']))?></p>
<form method="post"><?=csrf_field()?><input type="hidden" name="id" value="<?=(int)$r['id']?>"><?php foreach(['new','read','replied'] as $s):?><button name="status" value="<?=$s?>" class="btn btn-sm btn-outline-dark" <?=$r['status']===$s?'disabled':''?>>Mark <?=$s?></button> <?php endforeach;?></form></div><?php endforeach;?>
</div></div></div></section><?php require __DIR__.'/../../app/Views/footer.php';?>

<?php require __DIR__.'/../bootstrap/app.php';$title='Divisions';$divs=require __DIR__.'/../app/Core/divisions.php';require __DIR__.'/../app/Views/header.php';?>
<section class="pagehead"><div class="container"><p class="eyebrow line">Our Divisions</p><h1>Six companies. Every solution.</h1><p>Six connected divisions working as one team.</p></div></section>
<section class="dark-sec" style="padding:80px 0">
  <div class="container"><div class="div-grid">
    <?php foreach($divs as $i=>$d):?>
    <a class="dcard reveal" href="<?=e(url('contact.php'))?>">
      <span class="num"><?=sprintf('%02d',$i+1)?></span>
      <h3><?=e($d[0])?></h3>
      <p class="sub"><?=e($d[1])?></p>
      <ul><?php foreach($d[2] as $s):?><li><?=e($s)?></li><?php endforeach;?></ul>
    </a>
    <?php endforeach;?>
  </div></div>
</section>
<?php require __DIR__.'/../app/Views/footer.php';?>

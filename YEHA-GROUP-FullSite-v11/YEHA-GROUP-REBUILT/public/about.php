<?php require __DIR__.'/../bootstrap/app.php';$title='About';require __DIR__.'/../app/Views/header.php';?>
<section class="pagehead"><div class="container"><p class="eyebrow line">Who We Are</p><h1>About Yeha Technologies</h1><p>A multi-sector group focused on practical solutions and dependable service.</p></div></section>
<section class="about-block">
  <div class="container two">
    <div class="reveal"><p class="eyebrow line">Vision &amp; Mission</p><h2>Strength, vision and heritage in every project.</h2></div>
    <div class="reveal">
      <p>Our mission is to deliver trusted solutions and build long-term relationships across our business sectors: electronics, construction, trading, networks, energy and digital.</p>
      <p>The lion on our crest stands for strength and vision. Our promise, <i>Ancient Roots. Future Technology.</i>, is how we honour where we come from while building what comes next.</p>
      <a href="<?=e(url('sectors.php'))?>" class="btn gold">Our Divisions</a>
    </div>
  </div>
</section>
<?php require __DIR__.'/../app/Views/footer.php';?>

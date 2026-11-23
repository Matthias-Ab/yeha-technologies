<?php require __DIR__.'/../bootstrap/app.php';$title='Ancient Roots. Future Technology.';$home=true;$divs=require __DIR__.'/../app/Core/divisions.php';
require __DIR__.'/../app/Views/header.php';?>

<section class="hero">
  <div class="reveal">
    <p class="eyebrow line">Est. on Ancient Roots</p>
    <h1>Ancient Roots.<br><em>Future Technology.</em></h1>
    <p>Six specialist divisions. One standard of excellence. From the circuit board to the skyline, Yeha builds, connects and powers what comes next.</p>
    <div class="hero-actions">
      <a href="<?=e(url('sectors.php'))?>" class="btn btn-lg gold">Explore Our Divisions</a>
      <a href="<?=e(url('contact.php'))?>" class="btn btn-lg btn-ghost">Request a Consultation</a>
    </div>
  </div>
  <div class="hero-logo reveal"><img src="<?=e(url('assets/img/logo.jpg'))?>" alt="Yeha Technologies logo — a gold and navy lion"></div>
  <a href="#about" class="scroll-cue" aria-label="Scroll down"><span></span></a>
</section>

<section class="stats">
  <div><b>6</b><span>Specialist Divisions</span></div>
  <div><b>50+</b><span>Services Offered</span></div>
  <div><b>1</b><span>Trusted Partner</span></div>
  <div><b>24/7</b><span>Support Mindset</span></div>
</section>

<section class="about-block" id="about">
  <div class="container two">
    <div class="reveal"><p class="eyebrow line">Who We Are</p><h2>A house of enterprises, built on a single promise.</h2></div>
    <div class="reveal">
      <p>Yeha Technologies unites engineering, construction, commerce, connectivity, energy and software under one roof. The lion on our crest stands for strength, vision and heritage — the same qualities we bring to every project, large or small.</p>
      <p>Browse our services, request an appointment, ask for a quotation and follow your work from one account.</p>
      <a href="<?=e(url('services.php'))?>" class="btn gold">Browse Technical Services</a>
    </div>
  </div>
</section>

<section class="dark-sec">
  <div class="container">
    <div class="section-head reveal"><p class="eyebrow line">Our Divisions</p><h2>Six companies. Every solution.</h2></div>
    <div class="div-grid">
      <?php foreach($divs as $i=>$d):?>
      <a class="dcard reveal" href="<?=e(url('contact.php'))?>">
        <span class="num"><?=sprintf('%02d',$i+1)?></span>
        <h3><?=e($d[0])?></h3>
        <p class="sub"><?=e($d[1])?></p>
        <ul><?php foreach($d[2] as $s):?><li><?=e($s)?></li><?php endforeach;?></ul>
      </a>
      <?php endforeach;?>
    </div>
  </div>
</section>

<section class="spot">
  <div class="container">
    <p class="eyebrow line">Product Spotlight</p>
    <h2>See the water level controller work in 3D</h2>
    <div id="stage" style="height:440px;position:relative;touch-action:none"><p id="nogl" hidden>3D view is unavailable on this device or network.</p></div>
    <p>Water level <b id="pct">65%</b> · <b id="zone">NORMAL</b> · Pump: <b id="pumpstatus">OFF (DEMO)</b></p>
    <p id="info" class="text-muted">Drag to rotate, scroll or pinch to zoom, click a part to learn what it does. Visual simulation only, not physical measurements.</p>
    <a class="btn btn-dark" href="<?=e(url('products.php'))?>">View products</a>
  </div>
</section>

<section class="dark-sec" style="border-top:1px solid rgba(200,160,74,.25)">
  <div class="container">
    <div class="section-head reveal"><p class="eyebrow line">Why Yeha</p><h2>Strength. Vision. Precision.</h2></div>
    <div class="pillars">
      <div class="reveal"><h4>One Partner</h4><p>Electrical, network, security, energy and software work coordinated by a single accountable team.</p></div>
      <div class="reveal"><h4>Engineered Quality</h4><p>Careful design, certified materials and clean workmanship, from prototype to handover.</p></div>
      <div class="reveal"><h4>Future-Ready</h4><p>Solar, smart automation, fiber and EV infrastructure so your investment keeps its value.</p></div>
      <div class="reveal"><h4>Lasting Support</h4><p>Maintenance and support across every division, long after the project is complete.</p></div>
    </div>
  </div>
</section>

<section class="band">
  <div class="container">
    <h2>Let’s build what’s next, together.</h2>
    <p>Tell us about your project and the right division will respond promptly.</p>
    <a href="<?=e(url('contact.php'))?>" class="btn btn-lg btn-dark">Contact Us</a>
  </div>
</section>

<script>var D={tank:'Vertical plastic tank holding the water.',probes:'Conductive metal electrodes: current flows between them only when water bridges the gap.',pump:'Pump switched by the controller relay.',case:'Protective enclosure keeping moisture away from the electronics.',pcb:'Conceptual control PCB. Not a verified production circuit.'};function choose(k){document.getElementById('info').textContent=D[k]||''}</script>
<script src="<?=e(url('assets/js/three-loader.js'))?>"></script>
<script src="<?=e(url('assets/js/scene.js'))?>"></script>
<?php require __DIR__.'/../app/Views/footer.php';?>

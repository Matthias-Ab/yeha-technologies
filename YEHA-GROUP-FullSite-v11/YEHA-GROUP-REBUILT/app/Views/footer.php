</main>
<footer class="site-foot">
  <div class="container">
    <div class="foot-top">
      <div class="foot-brand">
        <div class="brand"><span class="brand-mark" style="background-image:url('<?=e(url('assets/img/logo.jpg'))?>')"></span><span class="brand-text">YEHA<small>Technologies</small></span></div>
        <p class="tag">Ancient Roots. Future Technology.</p>
        <?php if(setting('email')||setting('phone')||setting('whatsapp')):?>
        <p class="contact-line"><?=e(setting('phone'))?> <?=e(setting('email'))?> <?php if(setting('whatsapp')):?><a href="https://wa.me/<?=e(preg_replace('/\D/','',setting('whatsapp')))?>" target="_blank" rel="noopener">WhatsApp</a><?php endif;?></p>
        <?php endif;?>
      </div>
      <div class="foot-col"><h5>Company</h5><?php foreach(['About'=>'about.php','Divisions'=>'sectors.php','Projects'=>'projects.php','Partners'=>'partners.php','Careers'=>'careers.php'] as $n=>$p):?><a href="<?=e(url($p))?>"><?=e($n)?></a><?php endforeach;?></div>
      <div class="foot-col"><h5>Explore</h5><?php foreach(['Services'=>'services.php','Products'=>'products.php','Solutions'=>'solutions.php','Blog'=>'blog.php','Contact'=>'contact.php'] as $n=>$p):?><a href="<?=e(url($p))?>"><?=e($n)?></a><?php endforeach;?></div>
      <div class="foot-col"><h5>Account</h5>
        <?php if(user()):?><a href="<?=e(url('dashboard.php'))?>">Dashboard</a><a href="<?=e(url('profile.php'))?>">My profile</a><a href="<?=e(url('logout.php'))?>">Logout</a>
        <?php else:?><a href="<?=e(url('login.php'))?>">Login</a><a href="<?=e(url('register.php'))?>">Register</a><a href="<?=e(url('technician_apply.php'))?>">Join as technician</a><?php endif;?>
      </div>
    </div>
    <div class="foot-bottom">© <?=date('Y')?> <?=e(setting('company_name','YEHA Technologies'))?>. All rights reserved. <span>Technologies · Construction · Trading · Networks · Energy · Digital</span></div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?=e(url('assets/js/app.js'))?>"></script>
</body>
</html>

document.querySelectorAll('[data-confirm]').forEach(x=>x.addEventListener('click',e=>{if(!confirm(x.dataset.confirm))e.preventDefault()}));

(function(){
  var nav=document.getElementById('nav'),links=document.getElementById('links'),burger=document.getElementById('burger');
  if(!nav)return;
  var home=document.body.classList.contains('is-home');
  function onScroll(){if(home)nav.classList.toggle('solid',window.scrollY>60)}
  onScroll();window.addEventListener('scroll',onScroll,{passive:true});
  burger.addEventListener('click',function(){var o=links.classList.toggle('open');nav.classList.toggle('open',o);burger.setAttribute('aria-expanded',o)});
  links.querySelectorAll('a:not(.dd-t)').forEach(function(a){a.addEventListener('click',function(){links.classList.remove('open')})});

  if('IntersectionObserver' in window){
    var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}})},{threshold:.1});
    document.querySelectorAll('.reveal').forEach(function(el){io.observe(el)});
  }else document.querySelectorAll('.reveal').forEach(function(el){el.classList.add('in')});
})();

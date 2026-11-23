(function(){var nav=navigator,rm=matchMedia('(prefers-reduced-motion: reduce)').matches;
if(rm||(nav.connection&&nav.connection.saveData)||(nav.hardwareConcurrency||4)<3||!window.yehaThree)return;
yehaThree(function(){var r;try{r=new THREE.WebGLRenderer({antialias:false,alpha:true})}catch(e){return}
var cv=r.domElement;cv.setAttribute('aria-hidden','true');cv.style.cssText='position:fixed;inset:0;width:100%;height:100%;z-index:0;pointer-events:none;opacity:.22';document.body.prepend(cv);
r.setPixelRatio(1);var sc=new THREE.Scene(),cam=new THREE.PerspectiveCamera(55,1,.1,100);cam.position.z=9;var g=new THREE.Group();sc.add(g);
var col=new THREE.Color(0x4da3ff),lm=new THREE.LineBasicMaterial({color:col,transparent:true,opacity:.5}),pm=new THREE.PointsMaterial({color:col,size:.07});
var small=innerWidth<700,n=small?60:140,pos=[];for(var i=0;i<n;i++)pos.push((Math.random()-.5)*22,(Math.random()-.5)*14,(Math.random()-.5)*8-2);
var pg=new THREE.BufferGeometry();pg.setAttribute('position',new THREE.Float32BufferAttribute(pos,3));g.add(new THREE.Points(pg,pm));
var seg=[];for(var k=0;k<(small?14:30);k++){var x=Math.round((Math.random()-.5)*20),y=Math.round((Math.random()-.5)*12),z=-4;for(var s=0;s<5;s++){var h=s%2?0:1,d=(Math.random()<.5?-1:1)*(1+Math.floor(Math.random()*3)),nx=x+(h?d:0),ny=y+(h?0:d);seg.push(x,y,z,nx,ny,z);x=nx;y=ny}}
var lg=new THREE.BufferGeometry();lg.setAttribute('position',new THREE.Float32BufferAttribute(seg,3));g.add(new THREE.LineSegments(lg,lm));
var mx=0,my=0;addEventListener('pointermove',function(e){mx=e.clientX/innerWidth-.5;my=e.clientY/innerHeight-.5},{passive:true});
function size(){r.setSize(innerWidth,innerHeight,false);cam.aspect=innerWidth/innerHeight;cam.updateProjectionMatrix()}addEventListener('resize',size);size();
var f=0;(function loop(t){requestAnimationFrame(loop);if(document.hidden)return;
 if(++f%40===0){var dk=document.documentElement.getAttribute('data-theme')==='dark';col.setHex(dk?0x6ea8fe:0x0b5ed7);cv.style.opacity=dk?.3:.14}
 var sy=scrollY/Math.max(1,document.body.scrollHeight-innerHeight);g.rotation.y=t*.00004+sy*1.2+mx*.2;g.rotation.x=sy*.5+my*.1;cam.position.y=-sy*2;r.render(sc,cam)})(0)})})();

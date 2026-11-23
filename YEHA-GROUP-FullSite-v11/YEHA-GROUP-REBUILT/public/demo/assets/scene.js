(function(){
var box=document.getElementById('stage');if(!box||!window.yehaThree)return;
function fail(){var n=document.getElementById('nogl');if(n)n.hidden=false}
yehaThree(init,fail);
function init(){
var r;try{r=new THREE.WebGLRenderer({antialias:true,alpha:true})}catch(e){return fail()}
var reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;
r.setPixelRatio(Math.min(devicePixelRatio,innerWidth<700?1.5:2));box.appendChild(r.domElement);r.domElement.style.cssText='display:block;width:100%;height:100%;touch-action:none;cursor:grab';
var sc=new THREE.Scene(),cam=new THREE.PerspectiveCamera(40,1,.1,100);
sc.add(new THREE.HemisphereLight(0xffffff,0x334455,.95));var dl=new THREE.DirectionalLight(0xffffff,.8);dl.position.set(4,6,3);sc.add(dl);
function M(c,o){return new THREE.MeshStandardMaterial(Object.assign({color:c,metalness:.3,roughness:.5},o||{}))}
var NAMES={tank:'Water tank',probes:'Conductive probes',pump:'Water pump',case:'Protective enclosure',pcb:'Control PCB (conceptual)'};
var parts={},pick=[];
function reg(k,g){parts[k]=g;g.traverse(function(o){if(o.isMesh){pick.push(o);o.userData.k=k;o.userData.base=0}});sc.add(g);return g}
var H=3,R=1;
var fl=new THREE.Mesh(new THREE.CylinderGeometry(4,4,.05,48),M(0x1c2733,{roughness:.9}));fl.position.y=-.03;sc.add(fl);
var tank=new THREE.Group();
var wall=new THREE.Mesh(new THREE.CylinderGeometry(R,R,H,48,1,true),M(0x9fd4ff,{transparent:true,opacity:.18,side:THREE.DoubleSide,metalness:0,roughness:.1}));wall.position.y=H/2;tank.add(wall);
tank.add(new THREE.Mesh(new THREE.CylinderGeometry(R,R,.08,48),M(0x6b8299)));
var rim=new THREE.Mesh(new THREE.TorusGeometry(R,.04,8,48),M(0x6b8299));rim.rotation.x=Math.PI/2;rim.position.y=H;tank.add(rim);
var pm=M(0x2f80ed);
var inl=new THREE.Mesh(new THREE.CylinderGeometry(.08,.08,2.4,16),pm);inl.rotation.z=Math.PI/2;inl.position.set(-1.2,H+.15,0);tank.add(inl);
var out=new THREE.Mesh(new THREE.CylinderGeometry(.08,.08,1.2,16),pm);out.rotation.z=Math.PI/2;out.position.set(1.5,.3,0);tank.add(out);
reg('tank',tank);
var water=new THREE.Mesh(new THREE.CylinderGeometry(R*.97,R*.97,1,48),M(0x2d9cff,{transparent:true,opacity:.65,metalness:0,roughness:.1}));water.userData.k='tank';sc.add(water);
var probes=new THREE.Group(),tips=[];
[[-.3,2.7],[0,.9],[.3,.1]].forEach(function(d){var len=H+.3-d[1],rod=new THREE.Mesh(new THREE.CylinderGeometry(.025,.025,len,12),M(0xd8dde2,{metalness:.9,roughness:.25}));rod.position.set(d[0],d[1]+len/2,0);probes.add(rod);tips.push({m:rod,y:d[1]})});
reg('probes',probes);
var pump=new THREE.Group(),pb=new THREE.Mesh(new THREE.CylinderGeometry(.35,.35,.8,24),M(0xe0a030));pb.rotation.z=Math.PI/2;pump.add(pb);
var pbx=new THREE.Mesh(new THREE.BoxGeometry(.5,.4,.5),M(0x333a44));pbx.position.set(.1,.4,0);pump.add(pbx);pump.position.set(2.5,.4,0);reg('pump',pump);
var enc=new THREE.Group();enc.add(new THREE.Mesh(new THREE.BoxGeometry(1,.8,.4),M(0xdfe5ea,{transparent:true,opacity:.55,roughness:.3})));
var led=new THREE.Mesh(new THREE.SphereGeometry(.05,12,12),M(0xff4444));led.position.set(.3,.25,.21);enc.add(led);enc.position.set(-2.6,2.2,0);reg('case',enc);
var pcb=new THREE.Group();pcb.add(new THREE.Mesh(new THREE.BoxGeometry(.8,.6,.04),M(0x0d7a3e,{roughness:.6})));
for(var i=0;i<5;i++){var c=new THREE.Mesh(new THREE.BoxGeometry(.12,.08,.06),M(i%2?0x222222:0xb08a2a));c.position.set(-.3+i*.15,.1-(i%2)*.2,.05);pcb.add(c)}
var rl=new THREE.Mesh(new THREE.BoxGeometry(.2,.15,.12),M(0x2255aa));rl.position.set(.2,-.15,.07);pcb.add(rl);pcb.position.set(-2.6,2.2,0);reg('pcb',pcb);
// flow droplets on the inlet pipe
var drops=[];for(var j=0;j<8;j++){var dr=new THREE.Mesh(new THREE.SphereGeometry(.06,8,8),new THREE.MeshBasicMaterial({color:0x66ccff}));dr.userData.t=j/8;dr.visible=false;sc.add(dr);drops.push(dr)}
// orbit controls (own implementation: no external dependency)
var tgt=new THREE.Vector3(0,1.4,0),S={th:.69,ph:1.31,rad:8.1},G={th:.69,ph:1.31,rad:8.1},ptr={},pd=0,moved=0,auto=!reduce,dn=null;
function clamp(v,a,b){return Math.max(a,Math.min(b,v))}
var cv=r.domElement;
cv.addEventListener('pointerdown',function(e){cv.setPointerCapture(e.pointerId);ptr[e.pointerId]={x:e.clientX,y:e.clientY};auto=false;dn={x:e.clientX,y:e.clientY};cv.style.cursor='grabbing'});
cv.addEventListener('pointermove',function(e){var p=ptr[e.pointerId],k=Object.keys(ptr);
 if(!p){hov=hit(e);cv.style.cursor=hov?'pointer':'grab';tip(e);return}
 if(k.length===1){G.th-=(e.clientX-p.x)*.008;G.ph=clamp(G.ph-(e.clientY-p.y)*.008,.2,1.5)}
 p.x=e.clientX;p.y=e.clientY;
 if(k.length===2){var a=ptr[k[0]],b=ptr[k[1]],d=Math.hypot(a.x-b.x,a.y-b.y);if(pd)G.rad=clamp(G.rad*pd/d,3,14);pd=d}});
function up(e){delete ptr[e.pointerId];pd=0;cv.style.cursor='grab';if(dn&&Math.hypot(e.clientX-dn.x,e.clientY-dn.y)<6){var k=hit(e);if(k){if(window.choose)choose(k);focus(k)}}dn=null}
cv.addEventListener('pointerup',up);cv.addEventListener('pointercancel',function(e){delete ptr[e.pointerId];pd=0;dn=null});
cv.addEventListener('wheel',function(e){e.preventDefault();G.rad=clamp(G.rad*(1+Math.sign(e.deltaY)*.08),3,14)},{passive:false});
var focT=null;function focus(k){var p=new THREE.Vector3();parts[k].getWorldPosition(p);focT=p;setTimeout(function(){focT=null},900)}
// picking + tooltip
var ray=new THREE.Raycaster(),mp=new THREE.Vector2(),hov=null,sel='tank';
var tp=document.createElement('div');tp.style.cssText='position:absolute;pointer-events:none;background:rgba(10,20,35,.85);color:#fff;padding:.25rem .6rem;border-radius:.4rem;font:13px Arial;display:none;z-index:2';box.appendChild(tp);
function hit(e){var b=cv.getBoundingClientRect();mp.set((e.clientX-b.left)/b.width*2-1,-(e.clientY-b.top)/b.height*2+1);ray.setFromCamera(mp,cam);var h=ray.intersectObjects(pick.concat([water]),false)[0];return h&&h.object.userData.k}
function tip(e){if(!hov){tp.style.display='none';return}var b=box.getBoundingClientRect();tp.textContent=NAMES[hov];tp.style.left=(e.clientX-b.left+12)+'px';tp.style.top=(e.clientY-b.top+12)+'px';tp.style.display='block'}
// state + page events
var sl=document.getElementById('level'),autoSim=!sl,lvl=sl?+sl.value/100:.5,tl=lvl,pumpOn=lvl<=.3,ex=0,exT=0,t0=0;
var homes={c:enc.position.clone(),p:pcb.position.clone(),u:pump.position.clone()};
document.addEventListener('yeha-level',function(e){tl=e.detail.n/100;pumpOn=e.detail.pumpOn});
document.addEventListener('yeha-reset',function(){exT=0;G.th=.69;G.ph=1.31;G.rad=8.1;tgt.set(0,1.4,0)});
var eb=document.getElementById('explode');if(eb)eb.addEventListener('click',function(){exT=exT?0:1;eb.setAttribute('aria-pressed',String(!!exT))});
var _c=window.choose;window.choose=function(k){sel=k;if(_c)_c(k)};
function txt(id,v){var el=document.getElementById(id);if(el)el.textContent=v}
function size(){var w=box.clientWidth,h=box.clientHeight||420;r.setSize(w,h,false);cam.aspect=w/h;cam.updateProjectionMatrix()}
addEventListener('resize',size);size();
var vis=true;if(window.IntersectionObserver)new IntersectionObserver(function(a){vis=a[0].isIntersecting}).observe(box);
var V=new THREE.Vector3();
function loop(t){requestAnimationFrame(loop);if(!vis||document.hidden)return;
 if(autoSim){if(pumpOn)tl=Math.min(1,tl+.0012);else tl=Math.max(0,tl-.0012);var n=Math.round(tl*100);if(n<=30)pumpOn=true;else if(n>=90)pumpOn=false;
  txt('pct',n+'%');txt('zone',n<=30?'LOW':n>=90?'HIGH':'NORMAL');txt('pumpstatus',pumpOn?'ON (DEMO)':'OFF (DEMO)')}
 lvl+=(tl-lvl)*(reduce?1:.08);var h=Math.max(.001,lvl*(H-.1));water.scale.y=h;water.position.y=.08+h/2+(reduce?0:Math.sin(t/500)*.004);
 ex+=(exT-ex)*.08;enc.position.set(homes.c.x-.8*ex,homes.c.y+.6*ex,0);pcb.position.set(homes.p.x-.8*ex,homes.p.y+1.6*ex,0);pump.position.set(homes.u.x+.8*ex,homes.u.y,0);
 var wl=h+.08;tips.forEach(function(o){o.m.userData.base=wl>=o.y?0x1a6bff:0});
 led.material.color.setHex(pumpOn?0x00ff66:0xff4444);pb.material.emissive.setHex(pumpOn?0x553300:0);
 drops.forEach(function(d){d.visible=pumpOn;if(pumpOn){d.userData.t=(d.userData.t+.006)%1;d.position.set(-2.4+d.userData.t*2.2,H+.15,0)}});
 pick.forEach(function(o){var k=o.userData.k;o.material.emissive.setHex(k===hov||k===sel?0x224466:o.userData.base)});
 if(auto)G.th+=.003;if(focT)tgt.lerp(focT,.1);
 S.th+=(G.th-S.th)*.12;S.ph+=(G.ph-S.ph)*.12;S.rad+=(G.rad-S.rad)*.12;
 cam.position.set(tgt.x+S.rad*Math.sin(S.ph)*Math.sin(S.th),tgt.y+S.rad*Math.cos(S.ph),tgt.z+S.rad*Math.sin(S.ph)*Math.cos(S.th));cam.lookAt(tgt);
 r.render(sc,cam)}
requestAnimationFrame(loop);
}})();

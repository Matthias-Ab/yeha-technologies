const data={
tank:['01 / 05','◉','STORAGE','Water tank','The vertical tank stores water. Its level changes with the slider in this website demonstration.','Provides the container where conductive probes detect the water level.','This is a visual concept. Actual tank size and materials will be decided during product engineering.'],
pcb:['02 / 05','▦','CONTROL ELECTRONICS','Compact PCB','The printed circuit board is the controller electronics platform. The illustration shows a simplified component layout.','Processes the probe signal and provides control logic for the pump interface.','This PCB is conceptual only. Component values, isolation, protection and layout require engineering and testing.'],
case:['03 / 05','⬡','PROTECTION','Protective enclosure','The enclosure is intended to house and protect the controller board during normal use.','Provides a physical housing for electronics, terminals and indicators.','No water-resistance rating is claimed. The final enclosure must be selected and tested for its environment.'],
probes:['04 / 05','╏','WATER DETECTION','Conductive probes','Metal electrodes are placed at selected heights. Water contacting the electrodes changes the sensed electrical condition.','Detects whether water has reached selected low or high sensing points.','Probe material, spacing and safe sensing voltage must be selected during engineering.'],
pump:['05 / 05','↗','OUTPUT','Pump control','The pump graphic represents equipment that the finished controller is intended to command.','A properly rated output interface can request pump ON or OFF according to detected water level.','This page does not operate a real pump. Real installation must be designed and completed by a qualified professional.']};
const parts=[...document.querySelectorAll('.part')],dots=[...document.querySelectorAll('.dots button')];
function choose(k){let x=data[k];if(!x)return;parts.forEach(p=>{let a=p.dataset.part===k;p.classList.toggle('selected',a);p.setAttribute('aria-pressed',String(a))});dots.forEach(b=>b.classList.toggle('active',b.dataset.select===k));['num','symbol','kind','title','desc','func','note'].forEach((id,i)=>document.getElementById(id).textContent=x[i])}
parts.forEach(p=>{let k=p.dataset.part;p.addEventListener('mouseenter',()=>choose(k));p.addEventListener('focus',()=>choose(k));p.addEventListener('click',()=>choose(k));p.addEventListener('keydown',e=>{if(e.key==='Enter'||e.key===' '){e.preventDefault();choose(k)}})});
dots.forEach(b=>b.addEventListener('click',()=>choose(b.dataset.select)));
const slider=document.getElementById('level');let pumpOn=false;
function update(){const n=+slider.value;if(n<=30)pumpOn=true;else if(n>=90)pumpOn=false;
const z=n<=30?'LOW':n>=90?'HIGH':'NORMAL';
document.getElementById('pct').textContent=n+'%';document.getElementById('zone').textContent='LEVEL: '+z;
document.getElementById('pumpstatus').textContent=pumpOn?'ON (DEMO)':'OFF (DEMO)';document.getElementById('light').classList.toggle('on',pumpOn);
document.dispatchEvent(new CustomEvent('yeha-level',{detail:{n,pumpOn}}))}
slider.addEventListener('input',update);
document.getElementById('reset').addEventListener('click',()=>{slider.value=65;pumpOn=false;update();choose('tank');document.dispatchEvent(new Event('yeha-reset'))});
choose('tank');update();

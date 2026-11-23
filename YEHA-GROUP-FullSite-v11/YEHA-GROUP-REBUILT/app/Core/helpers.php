<?php
function e(?string $s):string{return htmlspecialchars($s??'',ENT_QUOTES|ENT_SUBSTITUTE,'UTF-8');}
function url(string $s=''):string{return BASE_URL.'/'.ltrim($s,'/');}
function go(string $s):never{header('Location: '.url($s));exit;}
function csrf():string{if(empty($_SESSION['_csrf']))$_SESSION['_csrf']=bin2hex(random_bytes(32));return $_SESSION['_csrf'];}
function csrf_field():string{return '<input type="hidden" name="_csrf" value="'.e(csrf()).'">';}
function verify_csrf():void{if($_SERVER['REQUEST_METHOD']==='POST'&&!hash_equals(csrf(),(string)($_POST['_csrf']??''))){http_response_code(419);exit('Session expired. Reload and try again.');}}
function user():?array{return $_SESSION['user']??null;}
function login_required():void{if(!user())go('login.php');$q=Database::get()->prepare("SELECT u.status,r.name role FROM users u JOIN roles r ON r.id=u.role_id WHERE u.id=?");$q->execute([user()['id']]);$c=$q->fetch();if(!$c||$c['status']!=='active'){$_SESSION=[];session_regenerate_id(true);go('login.php');}$_SESSION['user']['role']=$c['role'];}
function role_any(array $r):void{login_required();if(!in_array(user()['role']??'',$r,true)){http_response_code(403);exit('Access denied');}}
function role_required(string $r):void{login_required();if((user()['role']??'')!==$r){http_response_code(403);exit('Access denied');}}
function notice(string $s):void{$_SESSION['_notice']=$s;}
function audit(string $action,string $type,int $id=0,array $d=[]):void{try{Database::get()->prepare("INSERT INTO audit_logs(user_id,action,entity_type,entity_id,details) VALUES(?,?,?,?,?)")->execute([user()['id']??null,$action,$type,$id?:null,json_encode($d)]);}catch(Throwable $x){}}
function throttle(string $k,int $max,int $sec):bool{$now=time();$h=array_filter($_SESSION['_t'][$k]??[],fn($t)=>$t>$now-$sec);if(count($h)>=$max){$_SESSION['_t'][$k]=$h;return false;}$h[]=$now;$_SESSION['_t'][$k]=$h;return true;}
function save_upload(PDO $db,int $pid):?string{if(empty($_FILES['image'])||$_FILES['image']['error']===UPLOAD_ERR_NO_FILE)return null;$f=$_FILES['image'];if($f['error']!==UPLOAD_ERR_OK||$f['size']>2097152)return 'File must be under 2 MB.';$x=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name'])]??null;if(!$x)return 'Only JPG, PNG or WebP images are allowed.';$d=__DIR__.'/../../public/uploads';if(!is_dir($d))mkdir($d,0755,true);$n=bin2hex(random_bytes(12)).'.'.$x;if(!move_uploaded_file($f['tmp_name'],"$d/$n"))return 'Upload failed.';$db->prepare("INSERT INTO product_images(product_id,filename) VALUES(?,?)")->execute([$pid,$n]);return null;}
function setting(string $k,string $d=''):string{static $c=null;if($c===null){try{$c=Database::get()->query("SELECT setting_key,setting_value FROM system_settings")->fetchAll(PDO::FETCH_KEY_PAIR);}catch(Throwable $x){$c=[];}}return $c[$k]??$d;}
function temp_password():string{return bin2hex(random_bytes(6));}

function commission_rate(PDO $db,int $techId,int $categoryId):?float{foreach([['technician',$techId],['category',$categoryId],['default',0]] as [$t,$i]){$q=$db->prepare("SELECT rate_percent FROM commission_settings WHERE scope_type=? AND (scope_id=? OR ?='default') AND is_active=1 AND (ends_at IS NULL OR ends_at>NOW()) ORDER BY id DESC LIMIT 1");$q->execute([$t,$i,$t]);$r=$q->fetchColumn();if($r!==false)return (float)$r;}return null;}

function tech_candidates(PDO $db,int $rid):array{$q=$db->prepare("SELECT s.name sname,COALESCE(c.name,'') cname FROM service_requests sr JOIN services s ON s.id=sr.service_id LEFT JOIN service_categories c ON c.id=s.category_id WHERE sr.id=?");$q->execute([$rid]);$sv=$q->fetch();if(!$sv)return [];
preg_match_all('/[a-z0-9]{4,}/',strtolower($sv['sname'].' '.$sv['cname']),$m);$tok=array_unique($m[0]);
$rows=$db->query("SELECT u.id,u.name,COALESCE(tp.specialization,'') spec,COALESCE(tp.experience_years,0) yrs,tp.availability_status av,COALESCE(tp.verification_status,'') vs,(SELECT COUNT(*) FROM service_assignments a WHERE a.technician_id=u.id AND a.status IN('offered','accepted','traveling','arrived','working')) active FROM users u JOIN roles r ON r.id=u.role_id LEFT JOIN technician_profiles tp ON tp.user_id=u.id WHERE r.name='technical' AND u.status='active'")->fetchAll();$out=[];
foreach($rows as $t){if(in_array($t['vs'],['rejected','suspended'],true))continue;$sp=strtolower($t['spec']);$t['match']=false;foreach($tok as $w)if(strpos($sp,$w)!==false){$t['match']=true;break;}
 $t['state']=$t['av']==='unavailable'?'unavailable':((int)$t['active']>0?'working':($t['av']==='available'?'free':($t['av']==='busy'?'busy':'unset')));
 $t['score']=($t['match']?4:0)+['free'=>3,'unset'=>1,'working'=>0,'busy'=>-1,'unavailable'=>-5][$t['state']]-(int)$t['active']+($t['vs']==='verified'?1:0)+min(3,(int)($t['yrs']/3));$out[]=$t;}
usort($out,fn($a,$b)=>$b['score']<=>$a['score']);return $out;}

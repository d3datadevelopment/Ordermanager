<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/x3SZSirT96P+WjAE7XE/Uh+sokgwvmmzH0q6XpkUw2zetU/x0bmCE2cyC+d8bUV+9mO+ee1J++2LTz+Hu+/EhvODx693BO7Xc2VyPZe4+XCuEpwfWtDqxT9YjgQRqeKHjMtavu7HBNPom3lkaRej/j+PvWs8S53mzeNEYlWcOW1YTuzSC7xsPHbU7sCaBma8tqNqi7SLFZWw5VTXdqoAP0fj92m7PNzkCAAAAHgBAAAI0ahZCWUIglHVOiNJkm4iXzNEXcMrPZ8CxChRLUGi+ZZSsC3RrvlySvY3EarfcEn2Rxx2FazsSER5XMhd3JYGeitVdqNmMSidqx4puMhSyFofq0X11hg29nVRIx0vuQRok+IlJupby9LcaFxhIvXXFtz39xWvZ7+kqHYAk41NjFLpyf7DzM6kKC3RQhwzFHGsTtj97eBRPbIdRm1+4NjopmHq1Wk8bWOXj1SUJIuCJddCNNcsKf3yQRsJhEfKzyQmJYSQYxcUMWIQ5625tdR0x/XqpVRssZjomhAwRBTinsSY7Q5kDuTLDBc+x3lwxWxKIwqWNyqfcIreWk/KQKvNXVbvUGgB4dhe4sQDP89wCKMp2hVkIneiz8P9Fo6xxApHtdjw7nJ6CFXgdmjBxcvy1chYzsDkNtuE048mwfoB7pa/nbBQxOdF32W54Kigu2bLNGRvukdcy0OnD2cEZBUJc0n6HxGbvsdgb1u+0XSVNLA7I5Rx3KdeUQAAAHABAACM/vnKXtCw82Gv302O8m64zOVefDkjrcvYYo7f2DdAbDrrYc6FoxHKCTha/LYDrOfq/OjdKuOQVreznULsNrM4pQblCUCkUc+1S9oI5IG0hUO+ieH+fn2gQju8j1wDrbA1LrXZQC0th/Okzlaog3z8zOmQ3CDlfzEmm6n4TX0vtIrLwQucTx2JMDwliVnlKNlJR2e9C0z6wllyhbRvPaRSSQkztEhE6kw1taq+DKaiHdEx90Y+787cYGbsrwQ+OJhCZqZgMCErNlCPpBMtYcvkACX91KqPbT0pu+Etv8fkNjzy7p40yGlfHBeR7ymVQOExXXZWG0anZkJjLl8sBe20UIZeY/dIenJk3lglqudKEY+DynWNGbYdKuh4b9iPd9j0YR/g+kKUNrPG58BeyihwFN2S4QJYUY5PrU2ETsDOIDEjyoD1y8AfjrLs5G1iyIND3zI6UermxD5/92yHm38cqmbBgiuV++Iur0PxqQkhJ1IAAABwAQAAHfrz8yHfILxmd5FRhJUpJOYs0hord6g9cLFZpu1SclPq3bwZFLfQ8kjwVh06W/GVI9u2HpiHVOUxFP/J/CdMinxamXb2by4qciLiQayt2xuG69rNdW2giVxs5FYuGQc7dfixZuac2yGX1jXA6jwqsoSlBDPTDL1p8fVkJRNzd9FJeCFMXzpSx6bYy9MzZgIsEwKAPF392cKNDKrZkwJzzrQ7SJTPpdemRu0CspQYYYpbEHz8DQg1uZM+czlDCDL7RWnPP/J8YbG2CZ5nWlqCZW8OQk96Z934OVYCQOLe8d3V5istpSrAKGSxGuBrD/hNvQjp1SLehCHNFt7loIt7Bd8Of/f6fOCqjNYuDllv2NvpBXo0mM2gCAB7MR5Hq6PVRr3UkHcCLuLIqN93QeetwhNEczoqBj54J14KStdc7eWczN4izY2GeTd64N2px095LuRu5IhBsQEyMpg5SvBlGkBR5/YNwFh1oaMY+lqVe3wAAAAA');

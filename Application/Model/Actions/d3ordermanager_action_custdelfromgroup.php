<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

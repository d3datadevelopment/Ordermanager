<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

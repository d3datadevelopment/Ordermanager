<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

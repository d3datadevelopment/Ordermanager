<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

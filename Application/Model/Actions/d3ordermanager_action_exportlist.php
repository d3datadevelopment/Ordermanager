<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

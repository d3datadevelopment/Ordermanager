<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

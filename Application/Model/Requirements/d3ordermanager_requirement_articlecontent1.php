<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

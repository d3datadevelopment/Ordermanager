<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

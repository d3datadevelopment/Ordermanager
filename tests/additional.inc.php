<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

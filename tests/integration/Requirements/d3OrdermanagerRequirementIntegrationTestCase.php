<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

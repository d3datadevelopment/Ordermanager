<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

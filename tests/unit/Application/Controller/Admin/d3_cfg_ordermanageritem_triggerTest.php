<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

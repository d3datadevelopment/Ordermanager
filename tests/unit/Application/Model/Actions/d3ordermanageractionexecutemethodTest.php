<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

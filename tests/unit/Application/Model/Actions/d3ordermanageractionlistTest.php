<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

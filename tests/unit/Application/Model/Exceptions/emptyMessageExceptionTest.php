<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

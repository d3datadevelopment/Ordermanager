<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

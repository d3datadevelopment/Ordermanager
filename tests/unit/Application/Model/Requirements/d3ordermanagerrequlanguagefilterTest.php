<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

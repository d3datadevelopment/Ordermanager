<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

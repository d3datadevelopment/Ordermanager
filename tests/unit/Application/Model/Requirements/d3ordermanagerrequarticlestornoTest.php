<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
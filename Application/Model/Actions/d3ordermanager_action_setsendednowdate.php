<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

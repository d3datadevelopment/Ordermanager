<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

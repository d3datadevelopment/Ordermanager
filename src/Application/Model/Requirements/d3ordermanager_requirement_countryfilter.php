<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

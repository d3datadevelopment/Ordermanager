<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

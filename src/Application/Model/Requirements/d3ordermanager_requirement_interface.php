<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

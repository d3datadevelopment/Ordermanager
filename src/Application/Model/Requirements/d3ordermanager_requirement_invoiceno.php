<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

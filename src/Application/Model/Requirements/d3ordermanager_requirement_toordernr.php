<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

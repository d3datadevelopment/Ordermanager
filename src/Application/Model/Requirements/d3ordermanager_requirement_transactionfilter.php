<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

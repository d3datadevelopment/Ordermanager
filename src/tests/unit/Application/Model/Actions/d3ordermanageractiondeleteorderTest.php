<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.1 SourceGuardian (28.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

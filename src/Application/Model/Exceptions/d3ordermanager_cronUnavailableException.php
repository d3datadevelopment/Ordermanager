<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

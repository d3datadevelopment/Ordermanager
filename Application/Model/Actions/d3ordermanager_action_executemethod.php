<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

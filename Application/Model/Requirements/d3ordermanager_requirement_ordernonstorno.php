<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

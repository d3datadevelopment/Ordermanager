<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

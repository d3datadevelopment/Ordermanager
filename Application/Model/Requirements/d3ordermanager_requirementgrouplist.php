<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

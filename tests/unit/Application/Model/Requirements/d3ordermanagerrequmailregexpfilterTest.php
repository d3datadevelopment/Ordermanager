<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.4.0 SourceGuardian (08.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.4.0 SourceGuardian (08.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

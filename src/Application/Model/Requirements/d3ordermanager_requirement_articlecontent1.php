<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

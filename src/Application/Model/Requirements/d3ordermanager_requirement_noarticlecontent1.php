<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

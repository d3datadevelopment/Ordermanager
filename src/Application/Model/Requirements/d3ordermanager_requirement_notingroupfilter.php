<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

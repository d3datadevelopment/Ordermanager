<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

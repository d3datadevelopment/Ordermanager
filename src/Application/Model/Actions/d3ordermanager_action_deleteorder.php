<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

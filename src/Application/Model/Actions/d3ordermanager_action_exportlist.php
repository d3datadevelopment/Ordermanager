<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

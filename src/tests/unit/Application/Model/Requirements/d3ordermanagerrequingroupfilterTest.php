<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

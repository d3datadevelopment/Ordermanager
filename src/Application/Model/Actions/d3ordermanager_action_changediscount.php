<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

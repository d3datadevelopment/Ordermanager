<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

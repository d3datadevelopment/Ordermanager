<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

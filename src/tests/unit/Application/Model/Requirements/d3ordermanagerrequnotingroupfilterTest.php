<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

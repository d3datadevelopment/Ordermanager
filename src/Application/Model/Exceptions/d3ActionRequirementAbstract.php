<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

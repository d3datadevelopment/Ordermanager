<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');

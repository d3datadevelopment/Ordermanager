<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.2 SourceGuardian (17.04.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B30F126F20AAQAAAAXAAAABHAAAACABAAAAAAAAAD/6ftpuGRXPZ2vUcsfGunWz92xe4McDfNj0cUSBhNMW7a3M9vhdk+UcTdOYrUsGWJM4VjHmoro+MlOic95Ltdz+v39az0WWG0Y/wZ66SIEQuqVZ60zEA0ALMCgETKLMqe+oQbOA+XqYf6yiz90tsQRGggAAAD4AQAAbzdp7RRQB4eGFg5QvJyXULCg0+KlJLr4bF+ghxeDpgAnln1mSNv3Qph5yeaiCpN16cvsI+nCjYdgIwoFY93hRHZi9eyK8eeKk4GaOAJb/XE0bH1F/ECG54xHwJZ3NOtSq4YzNoo9xkRhqGmoydb0axEGHJW2tYZ77BYY829rqJ7XIOlyuCdF02PigDbQzjTsq7rwcg2pdZwyyylPMvyvkTBIqdpmSEywjvZFO+xpcSqGzEnhekfbqgk5iuCBaBIo4wbyWDZFCLfQ7WuzB0L1567z7w6yDgWgzkIUBXTAHd8PDKuYNzGOufl3p4ZcBQ5lRaXmRCCDJrkgHqcOp1bX6uNxHI6jXkY2Peu07tokwYZR8hn413/rurX3jt91vVAuPh3HBFOxr10CoXHp7KfbTrIu2ISW26tLZWxDFnXCXBsBWSlrjSkG2JnljRGr4NssbmZDiPQ+eDhUEsOL6Chb6sSDyhKttudGBjisIShFKhw51ESgxEZny1emHvzNfjzSszRhl7/NuDiDEe+qNAIo0PGsPcaH782O9xG28em14u/yvoW30GfdMM2BtsBsVj/6yLJvIOM/8sBGrCEYrrIIHyFIZQNqxP3FB08lpWQUR7/9Hhlbe6jJFnyaz+nrSrDDhrhEd8nXWL7Y8iyhe74Bn4Y3g6Q7o53xUQAAAPABAAC6PceZbuez7d+i7/zzXwLB3JIdIKBdH/Kxbp7rALJQ6nmgCVKNCNgVQRYvnoSS8T9spcX4D3bYbAJjZ2ZXdFtVVgZpLG5PDX9x5HJKtUfPQPeEkOcJYtqCP0YMsAMUrhHjS23+4bh0tOorQDtk9aZ0vJkI9LBB8BRzFgw88sLWvP32e7Al2TeKWWbxvc+e/lOSkp2FlBeu+nOhWkqaXdNPIN+HYsy1Qe6GIJTZn1/Wqwn89c1jkzkugpXFYSAxvdYLlsRDwXHf0OHDP9kyB9r4oXLJwmYNHEf2FPfNm06tTbJuMdW4MSb6k1AEaSnQEtfojC00L++yrVTojz0MhgBaTqdkDn99LA36ctQW9hnP8BL2seR/fwEU2ZMF8ElH6D+dNXgdBGEz/+zayoDBaZ7xEmKZtlwpz6ao8zapdp1T/2zEcms7CtPJFO37FP05CgeN4yOIEi0W/MPbf/BNU0nlx7rgZ/DIxZr2UVJltcjZoD3ItyIz9e+tUQq+tnaWXFrnjNcg33a/+52M+K+AxYpw3pHuA6YEM0YkHVOcL9Lo5Puwp5kNbuqWCz12JyR15YdMc3MWX0XGjg/pH0muVg7MAw9fpo/Siu3/0s+ExVITS+LNrcKyB2EhUeKYnQL4H2BgTFbUNGugsuAlP8s1bknVAAAAAA==');

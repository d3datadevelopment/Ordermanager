<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.1.0 SourceGuardian (03.09.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3AF126DC8AAQAAAAhAAAABKgAAACABAAAAAAAAAD/UAna0XPqj7z2Xe9rwSUWLJqe2nWcKNfWhQKpou2y5x/lJRdqVF33c1nu6GhvYKAnVKEoIA2S26cehNo9lzLmw2HQLPWw47R5Id06WiwZOvMr8WxVWgYYjstOHNObZoEWo5K4Tia/wpNl14DIDcbs6uym/5e648FXJK+aoPE0XZgtNyoa7xJ8BVkRbCQAzsk6aEyTMrq3uJQ+X/kpeIIuua1Cfuu8r0C9CAAAAJgBAABfxZ7voFJpv2mDDarWPfmTaIOY7mS+SJkG0IVmyT0vGOYFqMnuENbDbmq6FL3injdSagWDI97v6QvgxZVM9G8YdEoEVAmjgZYjb46RNR5V46fI0/f+tS8ADRkTCocErjiNOM/BZIEC+Mmj+8bzBlN2x3TfPilV7Fmv25ynPDiqSQpAW2D3rRQJKEDIWiHQFPERfydLTb57X1UAuuaat5fIXAaMAhVuJFL9BQml/Kxy9pHKprw+KexEA2NB+NCwUqlaw4QCwAfD4FJczhPB02FyXP1GiguOP5WJWkngGw9Z6ag7dHqm1Pt9Al305WCZakJddv28TnlirXpsplhwEjIBez9RcxhlpSZ9fpgufTo/Gl3NrVzJNDUFjEiN0nfuAIwfXlnPOHrlBuTuw42l1kACuB/tLjc0JP2EWtkf+gZeSPHel8vOOBbbFC74l0ie4Vl0JxsCqSOh4bGGZcaMJsqBgnMyM8VokUnzugCosEx4NCDIwO6hLQTTgbIR1ismQlm+baLRTiVibdauB2/x2puJI9ubGyM+EEFRAAAAkAEAAJN74STXYcz3LAjarn9cWUowWiGFhJ916JV02G87qRVQ4ueJgLJqmBxxYdm8KRtCmCNnuodu4iNKQpcMGDzLYKSGj4IFheJTKEyE/R8U5MLmnubuPyiQ2/bHkHNWp8H0F7PAbKzQP6yGToXN35QdX6DEaOZ4nMV4z5rY9s+7TzBplq9cwrn5lOaoa9Zi2d2S1/w9Vyv9hxkcJ3rcCqrr2VpX20qRZg6/ZNln5IBdjf5HHg+SxHBeHHuee5TnrEsMOrnDUEXzTeUM84ZvjgmTWr1azoE0ZWazvBj1LMWMQzkw0JthNzUQGBgULzvP4aVpEmlFEt0r15SfYFuJ70I8I7U3wZZpM1N9+6PgyNSpWIwfZ9dT68fM2fzrkflVOSts0Ws6x0SaL95Em/QGneTan8eAiumERtv9o2g98nBzNTOKmPFZ21iVUBtl588IC1B7A7/u7AS5qq8ZyeSdXNitjurHomOQEI6HkQxEb7MStriSvTmhEWArk1zr9/u7u+wlbQkhB1xChV/R7eBKlbs2gE5SAAAAkAEAAHDPMsP6iQMCmnfRz1Ypzqjji+dzJtC/brxDHtubiJDEYk4Lu83gz5s+cmjqf2FTHLkU+SOr17FBNw2qq8EBaLXZkZ3CL2TWm6366zjJAnoV3iw0Tw0JFoixXppMPx9I6XekKcS6dTB7mjY8+jatX08JbA6JgIm208gAP3eDsq6Mv94VLc43wSaZIewELyHK/AItW2eG2mXSLhqwfaPzGfpS+4fTfwRHlq2dp0k43w7srzYRbagCqpqHkBIc2ansfQA0MaJFllHga7Vi8lTka94bA9CUmeY7wQvVRD2GY1q/7wsPhpalw5dLx5i9TVvBsn0Iq2hpdCBEWVchjMOUsff4aoRCTOiGvEiO+ezxGXqoAKw+6D1CrV0rQeZJCdViRZkVJ8pftRRDFqJvG2Bwh2sy9Ra2LUouZhnwDYc4H9ISbKfqy6zYrAGdYhEkra7UANNVaUZ9bM+NMAjR6eGtrOhpc1xmVK9Oghu8aVS0tNul+nCStc4MUChDuQS16fZUzgc1NFydX+pFxXr5eG03ElcAAAAA');

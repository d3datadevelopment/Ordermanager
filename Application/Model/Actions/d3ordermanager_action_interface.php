<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126F10AAQAAAAhAAAABKgAAACABAAAAAAAAAD/l3In8qCcYL4C9RQoNS/Zs19n92V2MgkGbBTlpTiWG/KRCVFIS2d5wSMwSTbqzH8SxKlavXOeWWKceTxffjGoc++l0PvcjMrSR4L0Vr2/I96c1pO+SJe07yR8hGAFZx50msBMICjOxz5A4HG6nb+nhD4S2klnqk+0vwCijEyIlDN7jag6++1ZQvI/fJRXQei45K9N8MsBMZDS/Sw0hxFCqf7cDUcc0sZLCAAAAEgGAABe8EWkeG995LRhPJTZLSN3Qs3rijULDKuf7tk+/HJXkNG/A33GNaz+2lw+Mqu81uLN5gtQ0+okjBOjeystpN+pHck2mZINWtelCYdXoD3XAm+3JSiJA5ZqLlAyJk56I7Vu6sf/V3ydbhIrftIyUzcYKSbzfKEGkvq4FE3ZSJ02cYIc74ZoCTqaZqxzFIkUsz7Hv8Olo5h2jTSx/kQKRMCMEwPxDSAOhxaO8ICRcu/fBD2sYx+U/NbvoSTD2mNEdVWzYSxKQAEoedVSmXofMuHQcat9GNCkcm6M6VXrXrG/4+vhcTlWXwaTS0l1rw0z5HNjaENOFEuwoTsACPQDyVMnnRl0L4ChBn/x9ggvzovEgHxpfB624boeRGdKqRXRTW+xkwtQzP7bgxbkxLQPvmAyIG6ojF/auN/Iw4RzKQcFUPIr4X4jl+bymL5s2e81WDAbGFhbVit46OP0++2rZeos/7EQx0hmZrlTkBpLjVFw4BMI8O7PJxuc+UqCY5EFV5+PVeqUITKWp33VV5YRIhkaorW86MG1t3k1eoUo6/aNO5V/iep/bmDrDVUJvZ64xCFJjeYwWuK/xTeX3NQ65BXnBZrB/2klx12zpSacDoqONy6+ld/q1psGZzzoCPG2rjQ0FK8f2GWRRRZv7pJnQPa1UpT+WLwxrL9S+8jeim5nlxKct7MTCrBZIc3QT1/C/SQINljadvLF713i6k9rbYIFpnL9PNaFi0QDZdyrXzgiCy0YLGPlR5/ih7JTY2yMqJihFPGyWM+u3KOb+wHhwBlyJwxydb0BxW9ZVyRaLIs5nxec7UODq1kNM/5stDRxR6IAtkl2b6qxmYNSXcbC8QqQlbI2kP4oCZ/KVIlCm33QKSmZjHDnB4FHi5KDRrxvpnoruHO0AZbesDpYRh0H8nqyx+jnrPVuW3VkaTIY0JPgVP8s7sauRWgUuGyeaMlb9Lk6apCVzNrTd8OedujTPqx3gVFaq1NG6hnSet2j2NGnMiS2ZtLizs7vkBlFMiRE+5S5vkfbYJ5zdBnTV6h4iVOesZlVsbVCTPUTpI9Kws5NbRyZwPQF4/o0Mr4jzYyWf/OnF8cSpBISkZvep+oPqd/ycnVuck18ebXYNOGnlvG9386u5sOrHFc9XS1JM1npAvAaUbabv+Xx508p6QSwvbajtGUM9dtw3AxKN9g3ltLwX+GPa1NMScy/75Zvkm55rmjSJrebYDr3gshpD06T6DYlmJrYyQKGITmVoysS1WYRtNEeVxxjWiDiO2JgXhx2fnDxRopkCfAxDywqnm6ZgZJxJ4pM/F5QthOqj9nPeZcvkm+jo7ufh2oWm+E+YW/QmjxVq3JIkbqWMVdE/DgfGzj6tjMRhk15Pyd/ik1EzUNEF4z5gne55rgp/M2IH+yZMpxQdptoDR/sQCxX1J2jFUgnabQcL0n3BpFLFZhjPbhH8yG8n16e7CqsBHNK2K3M5aEK1Q64Bc2jTRuvSfDQa87ZVIIAkNxCLWMzllS3nrdtQ/UvPrXbYWZCSqRjWy5DeL3ySDQHw1s15YN5F5HIUIWryW7FTwh5SPpE+ctjDtRB73Kmj97CCSiAkPduuN0NsGHvtKBBb3VG7g3TlMAU+LV1zcDC6XLAHCB6q61KzeJr/xGshl+WV8rm/CTwv2r83aXzYlJq9dXEupfLgQiQj+Fk+TYBteA1HOHaszn79mooUs/4aVycx8A7pT0HNNtkUu4xxslLUqGyJK8A0vgEWwajn4iS5malOll9bNSjl4mfueVgDe8uFqoyD7WYboVyz5Sd0w2O1z56IgdN7JnxPTixETA6JMgwqMgZMz65ktUzpAyp42x72BvQ28VSV7HX33R2cwjs6LZJMefyGYT+H4hFSF6+C0MNuALxYBvvxTLQvC9BnnQ+VTVjaR7Gh5xf4SnHjIc2rNBymlwkp7Gmo7W2uOYuSrZFF4AjKBRf7O7ZkarD6mYLjH0RNMZQ/ZuIIRXz4cVLaayRVJcBkrg9mBOv9cawyMGIRo/mqCDhRoSJj6ecQvnF9k0i8PbU4Y8heKThBRRu4kn3K9P6wCx47BkUwwOsRJdmffks2LyCZqcp2OtT6fVIqkp9gcKjLi5BgO/rsyy/OLd2rRj8dSrGsxFahRp4z5g6xYNRAAAAaAYAABYjaHdGlx4lsIeBVrvDOHZ+l+97bXLitCGO2ZupNpf6slmM8u5FRGyo1QTpWqjtLVTTscfhnEvUOjn/qQ70boAY2FxJkWURSqsp9d1JNCi0n53TeWN3YuMFdmvo4h8OmKncSUjzzTm4yWYC4Gx9yV4CdKRm1HWR5QipP6dU3rW/EEJFC1AmDQogXKN/lAvrGkzE8afEawY0nurLbTu4lJITag5qebH/2e7DV/dFuYxfsC6yk5r1oSJhTgk/74aZojyY5N7BtaOwXE+mYAnH8SO6jGgzRZipuh3a5in98MyfPFk5BUVcXsx/JcOH50haSk3lApjZ6UHGvAFM9HtDaDepnUAyb2KXxoYDJzjlp1i51lwfXvJrTK++2yJwKcSszUsp+UalWJuTKQmslGhD3Yf+mZGFDu/uBxYnP2H84Zoa0LOWqhRrX5ttyZigyH86Fg3jFF4f81TCRPKdgwGGDGbMDb1FD2u6ue3h+qVUb8/M88kSTaGFqIbnfK/ErERqoJiHzVbzrEGm129Er6qosvI3oN0t8ub2B76mo5SIZFkts00RLF+KAMRe8QWz42G5xSZ781thEqETFa0iPFK9l4dB1sMG5DtmdG3xinirTNQ22ttkiGlROrDNW6c3kyzEFi8NBC7RZ0NXuIIlBTkmDXRK7GYwSdDSTvX9ancPH8TkZ4u/vGShjjA6mg0GWL2HvwxuvcbR0sQ0Ag7Icwmb9TA5FfnAKYtUb9owppZu5qSonikNnZpybs1w8s/de9T3F9PSyCTJjHTrb3khFztJhXkN0ly2SWX6Gia9/5tHWD+fezG2gF8j9o80ctucxcX1+VGP9Okm0/pVvp6sIjN8rIkrxOVcWJLpmNHj3dDuzy0GtkyYpRHj01qGP67is36dSoveMM8p2TKwzSKlR/hTtQju7Zf+6lv72nQErmQpImKwL4J8PnjajExXFpoRln92eTqTWadZbJ+RVEEvcoV92Lh3kog51dvh9xc831r5U9dZnoF/e8q1JBcIt6gotb/8oPwskU6Y+z0NX4XOh0MRuNZ8umKynhBRhG3YVNQrTTSbsU1l6aqBoBp+Olzk1CEKCpbcvXQunUkDUbqI+uWe3XOD8mtjs4x3PVA6IC9vDyosiDWxP3/z+LYhViEYG9YiGGTt/WkpHlz31RebXmaMktKjnx5dA3+nET22eQwcjgtAy99fcjxnKCG0Ra+joxL6Fq43EJh5TPpVvnYHRAdjfidvDSKyBQfs8MNlhCBlpM6+qanQXpXP/lhLAYCrqX+j2oGoje6rmB7//vnlFlGfJihprBWk89ONTsGNQ6gMU7/a0qXDVHmJSmARi78IwjVFG3ud0fwCO8FDcJyUUje43JDC+UZ1gig0m7W/nEEaIKEIdCafdv5k0IZhuWNnDFtAadqDHAgf78maByK0DTMWTfpwbbmrbBPmrsQgAK5izjI/PllMFWDU85UIzOc4IF+8D1TGhpC7X9C66ZZY8D5N8YStcDUI96efrILi/Vdsp3RC8K2cEFqTCCjMfWQzCbJbi0/gE+SqyO4UQWv7QCQyUglbwsAtm4HvSq4npB3S+NnbjdrJnb7BWygAdn5A8vPE5GF6wFeNN+zDeVT8EihTGg+dRdN6VDDYM2xzaKayAy1xgevtb9WJKX+FwZ8ycJqvwfatmDDT6q9lolfxgjwkW89rtsQfIYpdoehzYKZlB77vvd5DNcGwVAFs+vktqf5iM6I5olEWUTw4NNoC8IzXrM8rcy+zZQpMKfmVqZBiAi0VHlIoZmGYrJpszECqyAhNg+3JzB47bynmHNTeZd61amGnwycpvlM1MWxIb/o6BhtNKK97nu8IG+lv/7LrMfRNPqgVJ8iyeEsZnOhsPgwWHTtZpF0B3nVmlVCdpqm1qPBc12whIOlfWI3LJM7Iml7NIpYK+vV6yw4qmXfOTG1NOA4GUiOxw0ix/ztLyMppETTQt4TgOXd7XI/PJU2pOkFFCIPk3PR0aWGNl3govWKKvSJbxLNElsm87AkOA0G1tQYJe22ek5KEEYJJB9qO+DOrtAlFv2Sv02SrGpuEsEExvYVaSiVNfG0LhhHi07Lbuo8DI7XuGslrJrBW22Bb842SwUj13QUij4X6CYgEt1Vq/ImL36yLzVN7v8+CQJDQrnek7jtRdLpF6BrM7SOTMR8ucsWiyxkkuhKxUgAAAGgGAABVxXF1MpRxOD6r1KAC+iCfsy22DHViT2dDDd9XjmMOgLmwNNheeE864ydTXvGpO+qTuWfaVr4cB4TWlYrpkyClYGI+8j2uv9Ge53TqF+/rKxSoosogT1kmDUVMJEkkRanDnjqIk4zXFZ5GGY6t8v7lsGP505RpCgAhNprMdNEzDEU3sqRImLs+qzkbqh6yukxcnDg+J8cgq/P7xJC1K0UgQSbNWkfNFclMy3w63S+vgT2oeShkEfCH3LmmpZRT4iN1wrG+peh9rAO+un7m58snqt38hb7XqLFLfQ1Ywgqec5xEcxhZYd6K/g1uGuBsEZz2jHAGcGApk+y6jdA346VqqvCoKwFLMEJmyz0H+3AklXJ//uh7ht9DCu/+WvTvOnoIwYlA3SAvlcAV+kEd598F6RAShlGixUmhFOaqJoJAp6XbsxYs9lcP9w6Oqh0IX5EaHUGyAYR0WKX6d+hgzF9QGQjP2x7jxJ8UNS4LQ8wxHzW89Au/w3TL7l5iDGemU6cIRaq7kVP0PO3cth+Bp/U5CAQdKFAHxxhQk2qWM/nqsgrORTSTexoYHSsmN8ckW5dreLalxq1D6o87OmKYM5eR8NY2CUD4MH/lTZ7oTiwzNduSSzl6giYdAzS+MzIic0MwulwtDBtXOskC/N4K14esI2p3CUMmdttS/1IqRg4i7c3OlAQyr+w7wMUWIfdg/2rqM1ql/vfgGs5PJkKwL++fRz9cIBrb8D3H8X44D/Z9/Bhnmn0BNhLdydAbTJI1WdO2WRNF7VbqQTjkXqxaYLodolOn9BUShn3w1GwcQ7QGrAV7wkpsLHEyDMwaE5OC3izoTCzF34H6b90YhYAk9DRapeBlpbwLz+HuRP//ZJLoHMH1NM1P/GXFcxFCTfmViQbSKmVwqqev6xggfHlMYnImZ78Nx+Q5dxF9qWOuHSzmx63UHIweOKBypIcv9QZvFHSo5Ps9s1FkJPvofley0Wx+4V8eNcJaq+RH+4D9Ar4OG5MX00124/+4XwSXfmuptCNm1wYh11A13JJUPpBJYi1126ABRmdp/4MylVfWD1asQS1nwtPVsjN2jUCJ2m5wQYtIuivvR0pAHqqrhTujipI697ZDVGDzAR26Ung8TW89BqnpohUstPbVhAsIpZigKGWd3M9Vs9Pjnlp+twbTXvBh/+Bafsa5ECPRaqOvT0CU4gJwzd120mTYePN+QYuMHodcxrF7M1Ptpf1QnlyxxohoY+ZQhk5H33c9P8RJik8AG8EGPp6o8I1y+RIV50oRE4g5R7a3szjgvmrqivHAEVEXwCxTHXmaqEUM7/5+Y1g6hvrmyuueD1cTWwbpNbXk5CVTSpOsnG6Pe97hsdFrBTzhTQCNdzpMXtdgRfkrlg8mV0XEz9RaY6ntsZ7tIsLvl9oPBaZvY95n5mkf4J7b8wMy3AYUV/7wUNzvduWfoYLQ5v+XTXJV4L9WwxLS6rg7XkBP10KUAEIl7w/F7aiIF76GyFZblE+kNcbk/n7KUwWhEPjV66LMNjuuhCm37LJdC2YIKvZUV7tgI6mIm5hUuPKUKMSqqrkApDnTPTb1+2sAQJwVxiE8aLejJ1x2BN9i0pf+v1rcAJDSzM7pCmUADRAGYANcsPdpmcLEOQ+BSzBELqvxjiPfDz6e8Mgmkx23bVPVuVfz+2+ZtXqwtS1c9h6Sx0SU+UCvgU0HHOCKTgXbrb7CxoIQGa9pKoCpRqT2IjDi8H7GOTnaUd7vrQniPCPbLnhCbAlU0smHU/tibTWrWLesyhsdLCEQXd/MpmxbYQb9fk7GxBef+kCekSYXLfovFaM0ZLCmdiGkKzJmQKj7sQQbGqYGQCQGYgEEaOMCv3iNjpO3nSw9mu46c+rvfXF1aH/e+yVtqOeX53U9NWXdPO07sEMqrfoEaYMZsoeFd7Ye1EIiqLTMrOOEGRboTV2kLmJ2QfYpzJPVCpC0xejJ1HIQFOd012dgYQAhUvdHWlYLsAaZt1GKOGCj6E/PRaoSjevEM1Rp1hiX1RkdPYooTcOPCr5kt5j4YnoqeI2BGFduFATELGm6fOon9LwIkLlAmAE0V8zM8Y9Af9D2HRnPELQhKGfs2tR0vusYZRCjQJlOOYaRi4+viQmBpSP6fI1MW/4eRXOGTcpHx/ZpBz7E73E+VuCEM+74sJ1SGvHXsb8l1U/B4ib04gAAAAA=');

<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B31B126EC8AAQAAAAXAAAABHAAAACABAAAAAAAAAD/Ds4ohGC/2zFux1IumiZobJrbFjVhn0I8VeDAwAcYIFgvcTmqJ8unCMPkEbt3s318IOwuCNCrZUEKuiyyqVc6BU2OjVZkB9RNHMUJl6XuIEg8FsZWuNW3rd9RFWpCAudSCHXc6s9xQrbRbDCRnNRZOAgAAACgCQAAOj6OFvH1lvIFBV8wwBWbi6Sn8MuHmGHT3Nd0nR+tfs7yWB1grRnyy4a+0iMFGuySoRlM1FUxU9BXihEqdk1R/NtZFG4qmWmQ+s7tmezbKhVVqtrbEyHn6NcOfxCTCufCzKVWsA6hH/GDB2s/I1vejLGPK5YQRvgY24WIhIZXtyKIeiq4OcXcOpsW9bzHNqMZbrmg9EH9JJlCv/FBXBv9ZG1KwZjRV4QeJGUlhc7ku1Wt/xrFy5VtusUGi6+DQpefOKdJVP/176LNs9zr9w4mLccqoIDG7EKbFdaFoDLevGFAnoPQls9aMKZPYnUafHQpJ1iGUjwfsfdsgbIviBDwYtOte0uqb4m1PUNY+VyVUOzylolsg/Icsd5p5xmGORapWiTbdatmT3UQptRt3i4/O4L6hhPtQ2h2ZB052mpZ4cEpnNvsqM2fmyJH4bi/SUdrzaG7XoLNxmancTZ1b0qub44yi/XNI7pKk5sEStYxCLd1YUXd3qqzbn3H/rgiAYenFfpRskBo6opDShVXcQIBXxV0zOIxrzNlr6No8/acCYeMfhBBDkOZj+NDDFLbF9HTnU2BsKCKKlEEplbH2GZVXzIxDqOWd7RMB4misHCUX7bOMDzFT6u9Om4nj42T8WzD/s7Hi6+p5lQCMVpv3/db2VF5JgNbU1/PCBLQRnaIzU3DJ5jqKkpn/V0zmqciWEqe74cU0hYP6evMuHD0LzFXGwXs4ykO63wD+oD0AVXTlQOY/1+CVpzBpJhtH/Y8pFF0OOyGOIMeGw9aJ8F6yxCGLwKARMFthahx9/NaKzYPzWklfLpJ7/JsU5dPw6nUoypp5JQw307qhToDNocpo6wcSOBNkRiFIDaCMqrpoLhKd0WP7gmsb42/vBjGXnygFQBe7+lNhFn9bPb2lpT3D0hTj6anYs9bma+tdmT6ZTWbNHM+TsCC9LfdgR/8X/9iPclNq0jF8J9t1a7/lDipTjk1g1kNyC0ctuMSbsDnZ9dHMz633HVVZQfAjdtI2AGGPXafnLUrLIeEcHwEmothNzA7mb4au0R3sJzDwk435lInHjyl2XRkAFsNVKimvtidDcwVechouCtyEDunDX6sV2tG5mqzGkfkKtfYgDCvhc+HxFqyzPTgZJiC/O9Ylz7XEAl8U+6cQF+CyeqHX2XCe+tTSmCsWTKywVM82cPx5M8sga18e8s7L7rcFMxrvDUtslFed3c4cdZ63XFhEx5LaIku0XSfsdja390bs9xI4ell01Z+hwDuJQzqRf6qOc6U2LJSFSgUA6nd6k4c36vbZjGO6usqNfta6l3y3NqhKzRdDPi5nwfTCV6nvUL1J63Jqu9WApKvxQeKYSST5zlHFoi45B148VQOn1OIAdG6Zx9sx0el3EfQxhTnPSXDupiilP3OagNHNQUmNJxfu4bpz42ao2vga2JmFUi89zv0Mpj53m79F2EijLfGqNwUPfunrko4C9EvVeLryUgMT/VTG8jgMsFezdcp0ZkMS3BPoFCKHnCb5+XAH0h95DtbV6LWa9uxv2So2BVnchCp9LQBiqHsR8OewsoMRy8uyIQZnAGOIvQY+RapvvoDW3o7UVzyEX3dhrvV4oyzz0NkCGiXPfOjV2NpCO3ITfNV4T8mB+q5b5BQsG1H6WsckWRoCYhtyvswLF91672geyo2H10fljnVwvZvUhXvL1y3BmLM5dElI2W0HAvA9lbXSIX1LlPHlMhJ5ocWT5Bv7j3AtQB1Zq0K7/LSED0Ie97c+JAnjau7Zv1QrP8soNceI2a7eZELHg25WMnmOfLpMCV+OSM+TEqdjyx/cuicLLjfTyNCGandq5H3j/cPqyncncuhVYim+ZBDGQ3DS/zSlmn27dNjNqrxZj4UtHDC28F7U6X3eu7SZt7CyGD+FheAWLJU7T3ewha0he8ELrCxX+4JzhUHtaSJg0vipfeFNWxEQka6WhgDdzNfQxg1ptpflaNcJiWMmc89bi4DdRbb9tdsJX/Ei/lgx8Hf1qWYf/6KLH7pI8Sc0xjTzvPDmfMCm8x4ouB0GTEbIoDdQMQv3OeKZ9bJSkMO3ljyD2DTKLEKwDBodgZ1skMBdsAPVBhT51Rk6aZ1BLZJmSUphd1KpWYdhZAg/75JMGBA/8PHEKK8yMThsU2riIo7wwtQU6f9JLEChgSpZH97bO4qTDrmQjJvdlOxeJzZlov1tRRSTk8W6aUTohcB1k+ZAI9cs64GSCxWaxmBRyU7UT0YsZ2SUGYNNlzALKeUrTX3d92liC9YUygSTkwcFV6IO0TdB08rUYbS6+aknIiLz9s7AvhTzV7UmftwQo877tIAXVSOSROO8UYbg03835HlRFLdE6Wh2/nMm8j2F4ejj0W5vMUS3Aiyk1ShEH9uLkRDQDWmcAtgs8zDILZ4p+xH9M9E40g5HtLKBsyzEkctxZVF4weel73gBWMjPu4OHVfhT52fPrOH9cXf2KMj9KWXOb9JlXCdCDZ7Eocz0so9sUP+xvZtTgpxB8Q9gBXgxnryeSQm2HQyCGNCEjedBAOk04SaD2JV7+BpEO1Pn8SJuI81RZwA6fpfbMJKn2oIMUuaGn8gVL33Ov0eENnSnxDEGXl0TsBywwJ9M8UZ++7pt6tI+x6yBbIt9XeTyHN0gJp6V8xTS+8muQaHOMhtg5x+0AhiSGjuGpAwL+sonw3F53VRi2vaC7krz07iXK/cq1y1vcCerezld6LptjZR9mcdLonjyy3LdAeM+ENUeJHGdHocpXr4eCNzAqTC9c9Ojv2NuAd+2sCWEmyaF3XYmxv874E6PuStyU2OmE+Vmemzaeq1txOToLdxMyj5JniZkv1X7ToPJsLvSJTxSz67HNEIkUMpqNqJVp4aB7VRSqBjcj+iulUUko1ujRG9adeQPu4EOPnUDrF+spy9w1KHof5x+Gzg6NPa5XBWAvdYAx0orVvFaAl3Rg7yfvesoU5z808VBvf7kUJlE4UF0EO2fc7E/PanxGmfxDhpO0lgCTDcHOBARtEybKuowYkZGyta5sf5UTUwOSmm5AZtJWqYNgBowLfx3d3p6R0O9RwAs2oGvIiXc67+nu+j6Jj1c78nSdmUo1XWUHLCSbo9cpFszSp2i85ooVT1R4V6rSq/2V7TFa4ZX7bDAPPVeM+Hrqp39JMHlXi9sbb4pl4AmzPGV7vxIhaVO2B5K8h/g2/1f6SghuLfctQspq8Y8zWF9xmyJ7TuN9SoQ44SWW3adj6zcX7shh1csbi1nQssTad7d0QsKKloPPDGRJW4n+ZMvgcd01EAAAB4CQAA6za6EfdP/7wusiKluxDSV8JF1qsB2QNjyrUM6ZVu1BW4+UyAWXe83Jf8psW59SKBghdeEgscjPi9HBF2FfjJ+1IS/fTbcVAixADHglooLzDt0odUarwyV1B8onZcsdCq9h6PgKNj+nP8xs3h7FGYD3UR4OAnQwbtZYLAK+fBXGuyj03BBo5NM7uHRtVWnL0EhT4RZUZ9gGSUcVleI+f2Ty0OK2scK15QW4IvG5Hl+3Kdzb/OzefSFKxsapcsDhQdXpGWe5p9fTVPesQZO28p370cnhTYLLlY32xoZ581Qt4WVWFciB18lhmXTq5+nNI8q17LeivhnotCp2CYtwyvERgqM6Z512Emjv4DddOHVtWjEB8QeesY9kPYov4+P66l7alRlkQBqp4pHOa+fBz4g0NITIa0jp4DczbY1I+ntm6RtibADV2C2bYETbkX6gOsIr3bwq93x2KJotykhsBMgQzEqjoPDAP+RfXGIQdNYxJcJeeuYzgAQrYeM+e/TNHKxb35fNF/WAj/FZty5rJ9Fq/doUDgLgIKMhrij1lcjgNwCwZMzOgtpaYX1ZFxaZepWbPy2pxcfccY5kh6DJ1gApT6QPSfsMEcSJTSMXLSyPcVFzpmHlOz0GzLk17WADR0zzWb+pNW7Zwp3oItZXcSg+mmCxh5emrc2usD13KItoK5o78ryjSSq1vXWP9Qk1q3Z9RT2LVrfn8L+9iOJMrync+4r8gkA1lIBklkeVtDtHer3rIjrtxb16w8AJMK/TZ7NWt5x395/DCiA9jo3X5HN2dgv0Wy8ZExNhs4KLbyR1lhg6fKU1agNK6630A3ppcXLic/0QtLQr9R6+kV5e/hph6Kdud5+4Y3wcs2Oj2pUCup1UshCZR5JI46kDPa1kOtl+79CbHhIBuFOZVEuC86rvYlEeVnn3XzJH/IsWUGe65bvlHHP8TSIEbwntfIzE6oSBVyhikI/BBxvwhHMYW1Duigv5YwYPhDeucGnGNkkQf7WscTcHorrvnRXY8FuyIb6BffSmI8ltddFH1FvQwOtwA0Qqg8pwGfH3W0Eil+DnGYV90r+zM4iVrLgMpwjeJU78iSR7ZHbzPF7wUvbq1Xjh8ca0HaUFhA20qZiKhFs5Fy2U3CG0XgipRdr+5rnPXPuqSmNnY/BFjRunBH5KG6dPqWiPSaHJlyLC+LgZmG1IpG/nIZLuk6hETD6Sp/vpmoLMC+WpuJJORlg9klb8WspsSFL8bT01M8aGSNCu0Fn8wh0fMbPfkJTRsbS+b+f0nC0LI6RZgCPtBNH5RtQQcKXKlZI9QxpLrN/WIH8zsWEme9Fxfg4J6UomnJ7qNM965qF8uSn4G7MKKyW3xPDiM5SFEukUc/0a/K/hhT0N/T8Vw5XV7mwYkNM//4jAI92C8UaPJaiXhBDsv3ToARAOK/jKGk9H9q5Mhz4+MaqOFMiNNORxvlbpkFmNjjHDOPRR4Y57K27bHHFKlAL1bwD54Ll/FMwIOZz23ouo5k6PHRM78R2stt5glwdv9nZzLurHRdrqTAYAlrHNLF4IVZU90/8UsxA9KPlyFHtFL6w4gF5p1zghFlNP3HWNFcnD4sKX7XVyevIS8sDAWNIZGWcC4NGnqlyskJAPz4RCxSg0lE9gGUbL4WBSqC8nCyAEEmEjuXEXoptA2hgn5z8/IHdxhnAffsGUBoZDmxBn32EaP+MYkbxHj6Oaj9Ah7ptLa7yrbFEh5BUsluCN7C6HMYUCjczGz1+gJMwH3K17Km55QZ2bNNe3mkQMEa64JPTvgtALZAHtaDiJD50LRy3lKWkBnr7NivC7HDtGmVDntNnr2VYmHxE/9ol/x1ue95NpUl5kHXejztIktgSiZB7LNvp63lEFCUpNoKRiiT4KJfYJFWgwZf3LdEpVqhogeDEYvmWpfxn4pa2/4XQRC83GkKnaGBPUCZX4Y7xrJ6Pwf7MQR0W7/e8CwUesbt4vv0RttMIzNarDmCQEmWOBoww52U4e1v04GFPYnc4zyH6Ns+r8um1Fk5M2sQRtBX8j00AoJ9fmMK/Ewcg+kPyjgiqruvJ+TVo0dFvwFXsYHy7pRq8EAOQG3/zhZfjgICvtvKACcdUqgXKXQefZF/ydLYDBioPMD9aBaJuSPUUYmy8ypUlKe1u2lkdtBcl3nmeEfAqC53jvjOfXS6hpb3HAjSVnbWeb34fnXwVVPa90rus3WiiICEW+fDpXvMttBMiygdig8SLU7z6SnM/l/IOTUV8CwtYLk+MGzNw0SDDg4meajGWfI9rqA3C01rXIfXgxf0XimxuyvX8s+AzP3i3yc3H6D62eiR+EdNylp2Qzb4cdC+8caRPORyMbnredRKk8dosjc2P4avP7eOIfRnf+wdZyun12f7M2taSzzWzx2gqad/GieT+B05n751G9YiaOb2EsL9s9R+/sQqLvQ1oAOHdJfaNvfIJcJZaJ4SqhNUyaBlYhtb8JzrbxtLq7PdQLg7m0WgnCmVrXL62BMjUCN8wdtFkchoeUa8d/bZoel1LKNy0UwVuXlKxxswoasBLqhIa9D1OIEl+MQCX6i4iBA5cNbdVp6DYNd/RiW9n846zFNKyDDHvlKkbG1XBWnUJg00QEa6TUXqGToVX3emV1pnBuZMZ6UN6dln1cbS7sLz1F3wc/xK1MedmD3KZ7pFdiGD5e015PVkr1sr//cRuCm+nEOTukkLSxv9hJ8P1g2XU0zPDt2Gj8tSb2JP5UjM3AnKr9VUF5XCugMBi41CfWS6GmaKCfm9Pe1xbXN13SBVrOEbXXOzbJpHMW0EjGqRYGt+4+fPrKEcFdHEBTlnmN5r1rt8d5npAGHtkA3jpYZYBYoA6tsbSnTh1WI04WOBtk9lD2JjXzTHjbCkYJHkohSyrbyXZ7rE8W+IlE1ZP0A4TVewZbobXjuhiZ9B11AsFNYe3Cjf0Ak/nwkvdBMUOFVXsZauLug3JmBvhsS9rK1Az7PD3xpP7OkTTd1G8aJJr51FJUabe2Js/CKkB7wtquCsipnh9JoR3aR/zbf6hfBh26fkNZZIL9gawU1sYtasEH3gDjXS/5ZNn6vEVvGEf/TZmvpxKCUG0HEYFCV5m6g2yLJt7cndFM06JB3gZwPgXKOYtj74qLtddxGm7cySnTdekQ8I0TUthljhUJEV/hd/jJDmaKgSUl66kLx3Opz/bjgfrL1i64oLxTila2ScA12GBTPU84J2QpndnWJjXhohAAAAAA==');

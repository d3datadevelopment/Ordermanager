<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/P0RkRp16LQiUzFhXkow7+gX7na9N59A+p/b5Eq/gvYWEvtW6m1/KGfRMCkqIO49f1v2HOT41JeiJLOrgAFAAGclr5RKjb3mzNfUQmyZJm75KHPcWI0Xd4LTxkpLB1J2mV9o/iQPAZlZkkvxzCt+Bxcpmvo95VTZXtqcE+mrMiUScliD7HacOV8IjUOtNp/oMFa7BMqEDO3d7A6HOX7NIDpGHYPiU9pd0CAAAAIARAABnwtQurHShVMNf8M53Do9+UxeYaZ4AuXmkoX88tGJD0Dqy0++xvt6JTtqgbT05m/Jkn9fzZnXOZmr1LSg93ckY0beelBh3YXLW1Fs9vrx4QeRg4y1t98R4lDHDt1dhk85wUS2a7at99/ma3A9eaKnoJOpV3lu4UnsD+eIzY2q2RXI0cx8xZiWecgkgty9u88nBq1MQNEVM56/TiOWY0VIdaJusQMhytLyFcgFMC3r9DP9KKjNY+8fSR63CN6VgCJGNpvFKJ56wmtj27lmS2ea7aUImqzzi0TSW7qGC9ymLhwRgBO0B2HNwbvL4UlQlzVmpJ4B3FbFe4fQCvPK8yENAH/oihxeD1f6iE+IZ5mbrAiuiGJ40+sjrZ89QurdUqDA2aM1K22Tc6AonM+jP6r7nP1WqdK7/jjP0Nu5iIDkA2+UV4lyTd4e8rB1vahiHA7938X5PaSiMTkkxHUPk+0Q18ONtBdAPNVIskYxvwh6Uza6QNVo5EopWYTn/54MFcFK5ddlIpKo6nEAZJUfRYO80eDb8+MXKRE272Ebk2lm1imfh1f+fLqczDt4MboJg0l1QNDnD70b1pjEkr05px6IDc7hvthYt6DiPAOgFrjldF//jMzp77FB5dwzWfuOMd/hBpi/QH6FVE+zW9IpahR4tRirByTAPAlI/FyJdg69ChwMzFJqbm/faKFZHM4IgSHes9Aly0EBux7kR55qUf5OsS8NK0vSoM+m9fj8Xje96ujXOYKI0YxvrDXnfMZN8CX5QFMXOfTFf+LqfSJcBav/WEByPTNt5qCDD37cxVOaa3Qjs70l21ICyQWkKOiSr+p8a9dxzL2wJnRm/JomYU/3fPIszs1Fd6pSd9Ma8PyMZXnXrS2AbTU221eFvzF8QydEDc7xGEb1pWOPGwHhLZeZ56rL4vQsW3Qb9KKl14Usv4d/9B8hyRq7JnaAw3VzChEMfv5EmmU1qEMIKKGHPspGROC6R1jKd+PIXet8wcQGu3Qs+pUK+DMsngmDIY1p5nHBZNURQrnoyzGPLgCRUgAxd0eoVtSTeeUySt9Q631PnZMgihtAIa9cHIQ13Z/X69frQpQZPEURF++VXPMfNzfgClzgadr0eUIXc0noxQqTiAGTgamncUiX70eKODDjCiujtD/LGWbgHHi+Ahfzzecb5oCJJyto4oYgH6eFyLxr00HlUTz83Gv9xOWo4vikPcvlO7vfvqlq+jw8KLomfgjNQtSne5aUvk79wVWEpXXDp/XuRl9jcckbSmgc29b1YSiVF+RWJ7N9HkIPkRMbqH7QqOIrbrlqtKARh2RCfWSy9gbNa3FKdKWQGU8VYeYb3+LZcKpvLZJGAzkT0yK11epbhc77EljSGFFXA8o09H2Mv0lomt7Ef7NAKNDeRq8e1WzYnl1rZR+5X+jmsbjgYX2lE6hP0KK42zHJylqUVfWXtC/sU1Kel1pRi4WhKPRP4gS0PTCS3JNAvVFIm+sxBMI+nBtZIatt0QqbIdzeit2mCPiC0CCh3wLBclPFuZz+xLFWgnVWJ/sUBqNMIIGShzVOGUuPJIEWPa8CI7erA/0p22RerDwoMHjd1Y1YVqSi957xo0IQhC6AURAWCv4oyQHZa8ssE4jcbevmxk4Ul8W2hqZemuFNXDo9H5aro/l8VyauNyUv6acoczpRdo+gWTokZC890lggFDKwPZixK58RIRBAOtV88EPjJn+zeGAGtrSAtPbPLZQjOJUv2cg5JdT3IW2puaqTGmxckj/bYpZw4phuoal10D+QaL7EpytmEoXGXVAGN34ZjyDONsKTgtc77OC5NBVPE8LOEQP4vzr9hQPQJEL4ihITxotP/qMvPe4oSNu1jz6KPttJ0Ej1LZzovSkj2UByNqG68DgSxhkV4Cw/fbsOstL1RryKhYH0kncC31FXTO9kie5mGIQHWaEfKEcfgB8dR6zgoghGXpHnxbqcHjTgfSBctymRzSHNE3PbjYPO7yRO/jP8CmKE/vBBOND+RSWtQH9+oeclG6jS/i9TkgX6T9dV/61rEnprNHr9iRzBLnBSE90TUIrdSBXEEO7S2IQyD6Jj71F7d1S6SrLu5iyecvgTv2xK/KwbgwuV4ceB1LKvZFvKtsmcj4RtohmnnR4RMbF8CiUn/Zl2bWIk5xDCojP45OxlxFEGy9raSQgQSi1c/CTww9FMGjlHvzy8TPoAC6xe2JI3XuiR32sxWoP4NrEyBSs+e64aLTeqh6IZzi8nB22opb8jV8/U2Sme01AzNpgKIHw8ZVuyxyYCZAxuOwvrnvB9hnInFE99aHU+Q6jvtAfYBqC/gt5lA7w8I1mMYKZCtQeWlMNb0zXp5PMmtIK73cf9ZKDAd6d24h74/Z3Mkn0BxG7kSe0+MAJ2D3M+41rjgDdv51Gu3mGQUfrEgWCAsMn9C0Mc5cWiewIxw+8mYhUhg6JZyWtrGMi0IKXqIFOTjZ8n/0sanaTWkNBK/mBZ0jFL7OiZvO6L6uWcBlwCzF1qD6JVOyma5H6Hvxe3aUigoWLn7uqXUkqPm7oPzbJA3V8DLu87SkUvqPVKRoVeCvJckmp6HCeESkdTtJGNybLl061K6TVcRcRiNe9i6rZCCHlN+IASQpVea4Byh09l1HElAf+uYcBtcgshluemUylaTrOANHZpw4v8M98KMrVvNErAKWssM0KK4pbwgGlH9mf+lUiBq7owSDh9UzPqs/tTlYCMS6Td78oqnsg9lMfNH4zt+geXj50RD3yDNUOcWb/8jInSRbRSZMfJg7Rn1dlX/0+eiCphk/sso71f+kkTon/08B5N5s5wZpWdyATV3RX2WPAwLZtd2IpPFpPj+hwalkBRCv89Td0AeGN3CMEjWHY5NAqTAv6vT5T60xDl2Flmr/+alEj0tgc/V3U2Tx6/3S/mPLybbXD4Usw0FPS6NMuT+SvZgAG87GkNHpeR32278PSuwOFuEus7C7NDTD340EL3aj2uBCPuAUcMlzcerrtn9htOxr9+rpSCPfAVwGPuR1xI8iD/KSgMDxnVsKdNJYLj8pzPOk2FKJMpthMw8y6hp5pR0815Nftu3aHKT4N6Mhqi7B/CfTCSyMUGdFApbVpJR8OE1+S6fPr5ykySPEOLDYkK1VaKRIcWA9lPoEJryrHG8VqictnRey0ZysaSu0JG+1NttZHXddoToqwJLoX4czlgFfAzZxeLfAEwvjZZTPNr7cVi2JcYenmSpLp8+p+tTtTgMFd4nFi7IRW5cvibpL8183/mn6Ke0g0XG3zBR176KVhtb9fx0d2beG5KUVkGtgiGfbDajNzSmNpCxsvdolRwPGQfeZLKNiZdWD7kL7z3ClC7k9FbGn9xKqcT1Yh8WJnWiRQE+wgCxX9Ul4rjKX6IKaAu25mDczze0708z6/Hvq1km+r8pnM2LBjpEkc5i0I/hcxdFAt1uv/9BcBdtG8KFnrAAy9eOuH45PejCYhkEqDNhEi8YxKHJVTefyb5RRO0XpUjuV37QxrKa0p4fDUApif0YyOO2FWqsX41Kxru2H9l7PLrokc6LwUtieDx6j6Zb0qGP6Sh9PH4YlsRRf2TrYjJFVqBj/dvH7U1QJN0RQTE0CXo3rXdTN8cj2MnG+xbk3EEJr6rBanHV+jSYZ1qbTC+SnLuXW3qB5P+x5+HdlBCnV2huuReO7mYlabc0nHfzPtgi8ueeb79l4U3xWW/gFSIcLFfnzTx0TOOO3pvqnCXMipHu8zSo3bAq7dFVdbO5hq+ClNa4TdkT9MnmewucGwXRV/C+hntIRluHPmuMKniWW1Sm52D7frUu1MjwtBuh1v39FsGJfUoYsLoCuYA9CTtI7qXqzoqba4bAQjf2iNcD8h7v5nZgVOH3UYyQIkinDETECHMZL4msCey4MJ+8LClOgj9TltmtsVDIZRgge2azaLSEHcGWHKr9WVGA1o9bmVnGygW2kMkkv12txfiIrXNQLBFV1BlsNlDcCVTjg8hb8RVFgriekG9fpDSqjZvPCte9cXl+2Yp9XGNb0XFGqnOgxMFhXS8VsqfJXdMjE3ykWAZvyFeRb70fubpvXe6+vmi4Bk1UTnPZoYW+iwBaV1Ovewr3n8skijVFU1HLu0zNjdMKj/EjN8FaOA37Ql9Oru097ebvP2Y+sbN5G0YlaBhocv3o/7POZQzv616PV7QQ4jJiUAAXmD7HR22IT7FSRXZ68aA5DfuqySty4o+SW4MbBESaqGL5c48MdOiWTHTds4VZrZHVDc/Daepk7Nv4Q20tE/yWPLGF8r0g/p5pXb3PvLCgIn4nOwpET/sbwDAcaZJ8hbXeiUUKa+sjbHmd8vZxypKNK2WAwiUKyn/6XAMVjdDsEqSbjZso9HwoH51iy5FMmxsPc2DujlIdo6LHRP2Nzsa/PBLkVno3M7hFfm9Qm2E8gzpRODQuC6fUp+g4tePB798J7QRJtQ3H+PdJK3ZtZgkUAQV1URDCvJWbiWdsWwLUzDLI9T29GiCIvealc2kkbCT59XRoiAqujM76lUuuEMlr4FvZkkdcPzDnAyx0Uq+z4YO+Vu50uEB1JCbtHYU7iCboVrYu4QUzOsFUTXiNAJJwq1UJZB8zlNt9JCuUSlILyu1PKu3pT/eLN7EbWvZFv8/z3Ahruvp/nexqUgTVRItymg+TP1N1ls/aH4572FoKzo0YjleLEq2MuupSr+rtQKC1BqtzLgIjCImKAAVtFYwQeWJmVOQ9ow5S9yB8IK613GPxo4XGelkr5asl8pfiJZuwX4tgefxZYV+Am4YBlFJoH8rM/eA9vW50KlAZecepLIys3ArL0oEjNtvKCfATWBgowLJ/TFZalVldRUPPxDL3fR5fkZxUCfNrJPd7yl7NoSr/eYfgTJehXl0sYeyJG+oX8xO4UB7vtKgSM8K0/7L/A+Q78FgyQ7zH60RR1yBAX7/22Pq5XT4ZgT2WefF1hWEMuhQz1E2DJ6XiiBbmf0Ap97OihLZbWx46WoXy1TQ0PwGcQPHZRU8eOI83RXE4VJh03XNduW2g+zY1a5ELEJOXfjaOa2kW/KhKzGU9E9GOsLnlYNM7QDqnOU9BZPboWexCGmmM5EcTRBjl7yc5LXjiiXnSfhellE84asf78sz2GZ8VV5+nsSeRw9BCBPWPPW2YLvWh2eK0itWgHKxR2Jl/7+qqYSMIbxt1tSdaM1UppG5qWZSjyrjp+wcs0Y272jF1uM2NMsFkWIgIN403Gf6d3prQhg23c6Jihc1egH/ffWcSD/os7LAqQGFXgcSfhWlcthWbn2zMcwwVxSBvBy+iDP8FOpEXyMaHZWUjAm/0wi2eS0EbCtCGw1BTCBI4EWGwCJHMRbgqg5QqdDOYi7E47AJcL5lKKke/ny0VFfoHfCURSGWs8ylAt6U9bSq39T9FYCeMS8QZxfRLnne26aLKbg1IFpyG7XMKL7xzQePGomKUIAxQIwNAvjEwSPKSzI4ZaemtNHCCyy6FoA2KeJkkBWUlcpv46Ra0NQ9eFVZWv2GDNemb0kjHZdOfxSZ/7jIy3Vp8MiQjWQgIndrSX8sVUFRnz3ULYcmnFGHRN2XbfMG97r26rUit80723myRZ0tS8nwdorgRWIghxj7U4Ub3HshlYQR3mAs3vhigVeRZ/GtgRfDMUZ5KcuqCPQ9mmyXp/m+hdyOL/iwwTQT1UkBEeC6rBF9yS8E+jmCnP2MuMu/BZ8YmDGpiygpFbfVBo7oYCPqg/ll3qKtnO4kDVVfWg40K+UnzUNrRHVU2DR79gPWC3aPhXEi1TMROLnttzxHL92K4cBL7nBCltl85AIRKhjgWRop6Jby+G8p0Mg7HajQsGj1rJf+OdW1T85mcxjgGHEmLRF+LwdU4lyoMeaeCW4cZIzYZSusIB1kH83i6FkLK7w6pK9EJJJsxxygJlYHRvHuX3uhFek5nmbcvq0WICMEr58ceZiU20Hq/G6VXEP1c9rcXbaPWGpU2UQAAAKgRAABDbWMRPOjFBxZsUR7NVqPeNwQ8DdKUnpQeZOsCMBOqRjEgsBSRYucaUwL3GTQWwT2QbLgBUik2gi2SEg8xZr0kBt1zvkW8HX2O7OrqNxQJdRjfZE+BIW0xqaxQBV1b11PbxUrAggcv3dDTmv1kY/A9d829WF525KUdOwTvIKDNXFmNwrbzz+C3JHwuIWYFXIEGV4AcboTD8DsLFr8EUpwzgvzuOhbNh4hnw0sfXYulAO15andJH5fBULjroRnv4WjucmBpdErdqj4YwxAxMbcnaIGOJzGvZ36gfWMXNb6sGG4gBQUGZP411bZQGnY7g51yukPXREdnQb0Quft1yiwuAANuZtjrBXwtIcVP82oAPMv/QjKTD++H9TOXf3chduIzMDbrG90RkdK488ixxTlQJmHQS30q7FBuEP2cu0QorujSkqJbULFXjSK1/F8b1NLi9BEdgwtjqLb5wNb4HBCjE67g4rom1hvDX49wfWqboDIvfE+6bsLzdszq6GjCA/qhVBp1vvZi8UluEka09VjK4o1Lo1P1nI77PhPbSE6JFkkXtkyTb8yysfmZscT35oZBJBpwfHatDdXQcofuhqyvTvzbayqyBHQ9HZ6PjRgywNgMpki27blvjqaYRSiJ5AVseDhB6J4WiNnPsNKM/pMucRDpVike2/Z/1ylD22gC6gBZdBxfrM7w3qz9v+akswHl3XYwWiWvnIivksZNUI/7xpQIeAZTi9iioMO7oDIuaEEMrJdGtiKn4EY4m5ctefGMbLOFoYWKHJXiZ6FCpSQ3Y6RIT4L36bMwQBpU60CLKTSPq+GcOyM0FB90STDHhGbFN8KsHYgPMntDZmXRlKMkkOQciM090gtzsga91jdgad0cPIaPE+lOnuDSZ6Jwghrb0bAKogluq6RZ85GJKqTMBrDrGuSU9Jn3rj4UCCb/W/5RNdhNhBNIpP9HlkCfLsN6o4/6L3DdX5tXkZ2vSmEq2P3hLzY5RG09hMYWLR4rrSSicGhNoW8puBCSvcnV1E1OmtyERhdJxtlqmfMTDzW4T8Rpoxw+2owIq9VO3y9/47bOqwpqHVoS1DFh7OsMTk8iYzo/BC3bjQ+2SGs06c5kCek90DpK1obJtDmyCddnrUXeaYKuSy8tSHseHGGB4FObpV6/v5Ybxd8NrvhYk4Ig8qifmCuo+lXzjw46WY8XUer01qsS5/Ig2Eoi9W5JWTvFBBD2pIpbzv6Ymjc476M4uSyQurlF0pO0uh1kPX6cXod4ixeePxe7XEhxuu2PI0neRMi06ZmlNrUVbYjapZkMjVP4gUfJ7kOubbHrAGDWSEyV69Ju2fKzd0T369hXqE2NMwRhYMvTrHrZULq/vNLVaoCAN+qXVV9GleOIxVk3gMaT4c7S1b5OoSfmABqLHmlr92ejFoqxhUtjymkA1um0LEHJXcyt9KlJiHjQC590O7ighI8vp3j9r9DLNpWZXHCHaJJjpnJXtvcja8n+DL/xwPnKj+zL0W4sRgoN2m60QL597xVTQbPkv9TCif3tHN1haobE8evHdk8yYyNkn0vRGf44CW8umdYAA+Jwby5MysyEdfw2Hn9NA3+vBMdNwMD2WYNkOlGRx+Vin2ED2ijBatDFYFxXcTbDSgSrZit5pdPjqC1BF/eIz6qtBCmkTKT76pIOcJoLyAx2vDvXSwoBVl8AdfHeABW/ZsMEGC1/LrAWJTSA6t7HbOd1/2pqGswF+ashSgs8iGiFq+LcmkLkmvx5AQhV3OwXDCzSPJwS3v/14RAxs1ROLvcmJsyPflN4ksAximY1BZ8dOH+DHfXmBpu0dHNbQxbkDqHnKPDDpdil4M7DTi2+kLFeb6OtdkwGq0RFdpGlOtWpoeVWT5r10BCVdbLT4A4B4GqMr39Fuu+qQsXQqAuOe+J9VQuu5g2onWhrjlv8w6SbxMXPISk9vRMX57cbL95YA4guEoGD5vO2K+ARsU+DIbnsPEo9IPanmdT6K4VicfNzL/QxPTgoclENakOK84Y0jhBjF3zbymuBg1anV50SONVPCu0NqPeeBdLct0PqdF0X0cauzzSjkFf1vReLf1JrbGNf3CLQ8I3AwbkvpO95CP3V6oqBmaT6WlFw1Kcw9931RgEDeEboYmzCSr+ebrVBdpjfL4JIfqh+dOsZAFLmkTCMVp4AaV+d7/mAyjqncf5TkgKtdHIovRuA6S45/FkV2uQhXIFJXMyc4CbYLfeaylpHOre0rb+CWyEGNrhRIip4FV83JNFix9a6PVCSCctFeeb4YBpmxCSo8HHtxeCvVbVxqltt9OuN7cd2VSk4QZsrxbGOP2fs+yVtFhesDbPY41w8y/4y7Dw5Eu7DLXcmZFOKfYzG48DDGcX7ugSaI4LU4zjqnCJ2HVeDtRYoMgZpshpjO+5nGiT261KZIq2C3N/HRYORb5j4sey4q0K2TG/IDe/KKlqrlSac2Ai7fljxYuz25kxZhNDPphx7lKD04ZGQTLPLgdFX/Lcf8Ba0X1nF6WBtZy/E6nx5I3xwVmv/aKLadwB0DnVo5t+mRbMtfl4GYY5buO9CP2yNq3UEl6mnOIcT/STJGJtV7wZh4oJrNefz4rd8kA31MMD/K7KMPhurlTa7bWfHtv7J/AsPrd7M3ongpcNkgGr+O+ev1OYDE/XZtRv48ozbbm6QhJR3XIkSDnoZUTsAgcNkse3x529iUYbHJSyoLMfFkVdYDcMuZ80anbzWBMrWJJoOdL78q1HoRmDP5UV3uqUfkqqbTyx1I9s8yvdzcRUacG8IeiazxxQJDo79vhQ5v/5tGG3EEgZImH2NKFm4fH32c9yKWO1I3P1cMvag+F3gg0QobjfYBmiGtNNAy5A6r30zu4DjX/Hiwqsw6GIZ2u8kucTrUnG7YqrM1OfiM0GI0PzltATOtZmQKipEU/zRSttq0buxlQ3HZe95FieGyEA6LiJEDMg0PuB6bbG17kOXQYSocJDAJ6OQQ9wEhC0/cy4l3ohHbdasVrEoe3QNNU0hmeDlLAqwpOTTxMGW9jCLR8yDEHCiyFNBjfo0HPe+0bILeA2ZY1aESuHxr+q3JLnT3+LDsFEC1iFZyPUj7OpH6aY3LX2YdoBjYywNth+/H3tB7ZZBdCLVVDLnOprp3eM1OXfLN4944P9IYJA+HxtiYmtRZ5CNI6Xwxc2UpAnww4zqlKFaVejbHX1numGF91T6HJedMz7Qo8q9FUNsHEdhHWy92O/7/1q6e9mmlWAU6M3AVpHuU6X/kKAgSSPF8lLq4DtPtc9JV+PeGHCy/q6SB+xzyDYGpvvF3VCWDG+PwVM6o9xF8ZfIGsaNb7Xqwly/vRG2dcB5RSVCekOZ+p8SBxTtiJcS1HDoyA/Y1DfOTicY/RxCzXj5AByZyvCTTenkHfF0IlXoeTlR84JFiYsle1zaJ7l9icos0RGlrV8rmpCeHFgxgOtFtEJiaKdcR/oK5w8lZVKNvA3KA4hLuB5tEbM+PpMPd2edxxfhqnZr70uDGddydhkkNy7bW+xawLWUeKBghVgjQw1zBg1gBdduBt26vMpWNs+kgNRzXjfLvYKXbKxyOOS721FMrtPY5Hi3vmv6Pn+ntY/6q0mSzB7kIfQ9jCyuHbNN8KUdBWkertMgychvDPdObqQ7UcLjhGsc8l4rqDjHgBLVx7h9posA5RQ//C5iBzUP6++WrkVAjI49LqPsRGG2b2x8vrSyNg900JsAg+v63LdAH8prYvwwtqFjqnygLdJrEHiftIVAsCXimGAvMUJDQpKiaU1uGwbRmBGono3LBm5OsoH9OKp6U/+zHyUXFkFRagz5LwlFTqNXjIJDsAcpcTiqFEA3Kt1yHeF42aH7UG4sT2/8ke+NLKouawKrY5YJ7a5U4ZEvR9JFwWNt9WkK2CyeL2jpfNCoXu/HcM9ms2FLR+fkj6E+PJyxDQr8OY/DqlRJtYbG7QDbYKnzRxIejwvh3PtUBpRIW7micGlBSQr7rrjSW+olp31cwBks7yK1nV12THUP220iQFYXyisdY60jgbOCrbS9VxPEGVhBVP4lheKCRAfkAGGt7OKW1gugQW9eHmxKRR5t15+ercTsOlDleIbDeKxCLuL46AwifKQKBtnKqvPp+3V1eS4hH7QvLdbJJL4DJ41HQhan6MjxVu7ScXkQ4mxdcec6plRYRO1Sa8ZpjcwBEtHhnTe6GL8JCkGyv7K5UmBjQhokv9AnM/9uTbU3KKSc/+xkyTL6/PpbSYUTP2yiROslDeaxMmaZhbHqlYq2f5KZPHi5lc+O3XiWYuqgorK4Jm24K/M00DpGwhKCP+0n5ymZ5lshGtJy4GZgUow4njdEHtsdneveXURE4WFmyhSwnRwaON/k61DcbwGq80xyHUvYruuayX9q4xpxe9qh/YMD2W+s7Rh+OdNpJCIYdwppjItbWrOcxIiQyxxDhn9uaOhT+kBicW+tCTRMxFQ3s6mm5F5H7X0nft1RPiKC3Its/RXTDZ/qVzWwAIASs4u6/aYvypUipSXQgRjatQKxQ3kY6v2wBg7humoPPqxO7dqRarh4MimwgRzKvHIxW0G4VA619xUGfUTqZ28AOzq3507GzrRVb9slnYEm6+RmN5R/XVO+UPTJgPu3S1bYp7F5Jn3KqFC8Og+gja31j/1/M5eQLPwWNwIeWGMgVrp2cenelcJpJDzHydiIgLI6UKeEh35h4CXHJ1kRQjVHtMl2g6gG7xrU61DjdcLB8h6HVZJLHCMaAqDFYuIVy51ayMILShYEFo2lkv+JXGbbAdbWrMwjyZ6Z2/05KnroSnzvCJvNT5IXuhNS5Yh9k5QHVteymmtX8sX2B1PzeqbIXdsFC7YLs19UrFCzddIZ8G+fMbXDn1a8zQ3xv2071Qzu7v8kaAe29MobKV75T4/nrD9W69VSzJc1KHsvzIdNlaHl3zOt59th4tv35xtMz2+EUiJtCvExQgwE7P6ydxm0b6jVXUdl6R5RR5gq2wMiLNZbk2Sp661XimGi8J6L46SMplAg1vLL3F7c96LUdKvhe5lt9gdE9IunYdPAOFBqc1Ey4v/hcVzuo+1rx1AnOgefA0mh4vmmPJIVyg7jcpDceQFzGjVLK1xienvN/xTmTYrTUg8wrNR93/N/aDtm7QdDSO7PibMQdLtxs7Vm6CAIefpH8hiyCItr5280RxMAhyQ/UPTc+PE3qbg/m4Okze0VJ5HKkMsllazpgwzXFZC7iIgwafmJ0dS8jzU3QUR+SKDK2XwrHhXpWOuqDWLFvoRxafyux46J3PzcGUDkMr+i9+4e6MBnJohGY4Opf4ftsPI8w4l8EFQm2cMG9QLFIsIkksmfeq+DLn5vUC1kutfbOp2qVen6ykJpp+5VpJfVV4UG8oD+061dgLn9DNlIGzaL0Zh5TbNnviIY7Op3azvqMQl6pwbfN+L7Q7EZxOuqm7pxBDYL4i/nj23sRJt7m4bXQY9dV/xjkYSo9IEdZ5q5F0cuzhfr8ADaK1vfG+Ddbu8xSLCkLXFgwlJ+16D5J+JMPGg2SgT2SjYReIr7mQjhoiu1sIL8FAHX3MAwcVEKPpmbzDNvjD0ao0bQHxFuWt6y+GiICEgPPmPZnZFGeLUrKvPJF7OL0rfSU4XlhbIKA466NvdfGhbmdawRPTorBcG2QoBcAL5K1ZbDT1mEuurhNZz4HhNRIdp1HiRlRVxSM7pnoidZDSuMCwe1GED3id/iyAFBzn9MPHptxrJ1FyTcdU3au3jVvfD0l/k6gVn3duWS+/QyufyIQvRKZY+yjTLsgANhGQE8aJVs0LSLsh/3pvePVwt8ZUbIw8TESfgQiAXi3TRWSL8Av0LX8jbDZhEpP3QniWYdsfO0ENHe8CjlirDIzd7r45LYm5FOm/DkKKhwL0KIb6Wil3yZaETl9VXnTayV4QWpXHL/edBp/f8A2nUygSgLtxLmQkIrM9JMnaEtGhbKeCYApKw5RAr50+FPgM8TAu8WEa/f4n4NJZ57dLWPTymGMn6Z1/goFua7f476vXaxioMh8VIAAACwEQAA7yweqLESAAZlWEhS5Jafmu9revZZPva+ZQLSwe+9jbmOJ0kSrbTD46MQdeQNN5HfKOxEkwi2NnHEPoEZUie6Qdw+icqqR+pYt+qCWRUIGEn6ktmNLYqIpRXIk6umyA3lciMCDBfD0bwsGv4eTwLsCBAjeKGuSfQqBTO2MHUaD5KhjU87BOTvbNydI4uCXRdogSj6c6NUsp4vF4pqmk2TfG71+5pnj/dLFFfwTjDq1I3mpPiAEdRv7urDG0D0X9dTMo8yuYm62BfSXQJZpv5FlJDzBgI8UJCf/GT1fFMoob+CL6+j8w7dC0RESETPceFXUHyvWyIXEhn+z6NbLs8mxoIDPsRUfTaUR0GpWEUKvXNQoNhZhLkOC6BJnvYmwHG3H1Z6K0aFN0ACiT1OeXUzJyiL6lLghrkbbIf2GUEdqbeI/imXi5dbPs0IRCBdqZiYMuP1We5hViTiPkV6XzDs7r2lqkpu5MeZw1KFfbF2XWmXV6X+4tvJ/6MfQo0M2gk5DATCE83cOl5WejbIEXLBv+7sf3G/gTc5ZBO4CwvKmD6NKh8ar4rdwAFI14rX+EVrVG/ZdPzm7TNCdq10VIGqp4nxYHTfU+9k8fNpgzCGdSp0EYTB5ZEReW0q7FkdLAJAHFccs4NEalH3W7kPACmJHl0bqtiIFfwDhx2ZFvUkFzoDhHZ9mYxdgjAvLsYlCTHM5NMXQDtMtjzCtnqbWf6TgEsxZWpDrozPRBy6lAkTD1dhbLubUKOQLNAfkNp0D6IE5ouAYfjMnvsMVkNMV+Aid/Ij9nnfSoHfi+kV4npJ2M/dmKjypMymEEFVniscVsqx5nbDXeo0IyAU48z0UMlic332Pcxpr3mXvtqKsiJcLTf/XLz1f+9oJM+ei1i++i68k7RzbhWy3JaEY32BrwzLNFZIFxZ7Je4g4J/JpOYhk0USCDI4xa1rqKyk5XkuP+8EuePb2PJ5rqfQg2q1HReFXDy3aPNvxaNqKYI/7r2Y27IXqQMu2z75DAgdx7yetfjw0Cprif/DqzDPF5dMASYt/zTnq76HlRztXHP+jujFgfHmVlGygvNGPC2NXkrEBHcmgMzT//jeOkm1siIw0EYYoQslkXPaNAWJDUzrKk8yKfGGU54o54RyuHUzAlpryXIOQyWeUjcImEO1RjsdDMSm5lzQUuM2VP9lpHPaaLHcFSVNKCpTYQlXCgLFRdc6CQOmT3QM6ywcBZIArBIPRcxfkPk82gzPH9C1VQi4yQwYDluJStl1lob0T5SX2lVPe4/j9Hgb6rpcFk5MKkNuDouvVRXizN6WOhw2QPqx58c2Cag4MAjd0WTmPAg66885OKjL3YWcS5F1uP5BNRFtcunUILQlsX/jP0GfGUCAL/J/FgwuDXbLLQ8D1m8Ytp7J5J1SDBxc4k6p/PUu9itarP8VmkfSJpBGqSkkqVHe8HlOYxM17hF1OTc2rZGxYJWX99VjLZ8eQ3qso6RyxH+YtF5/MoMdv3SwPS9fom6DeakVzjxIq/fJwBb6gL2g8fB79FvRFOerMy3vIeQ68nZPSTP+hSmQFRnvMgUnhTdR7xQNLF8B+jA06PEHKG0UDHZq22SNLUMm93BgYpN5bebJf/A7sIrGwvKVnZfD2AUOGn3H5Cz0LLlMLYYNt0PaYAdr9sGT9wc9mU/n9XvXXmAlDb9E/vmzjmnmBkbl9u5Fq65PCQuU83W507dVWrPXbyw5JY1FEdb8g05Jvr6K/LXZjYVtwOMHtVd8pzIRr2bsTowFlNGhRoQDDvKJilZUT2uer513yHppP/8abgvkDsDmGY1SNCJ3HSHUnDebVlDSLRw7ezXpBC1Xmy3iZlbBPVYKRw9VZzBXboAnXMQcNQgI20zTWvKS7JxiTUzfCYpEcGWqr7OjY0IJrrjrCeyheJDwsFkzQfGUDDit1QMkJ/BDfEcT0Z/OcD74ntfVMp/lmLTKg3yyhHVM8anSN7I2ikMlmd9HTFOoksNeRK8uw6EfU8UFfjggCQ9wPvoDg+2u3wIWdnB3u7gfcj6VwlzkG5SriB54Ocm/TDLzL21LzDvabZy3VbGiUbuaaqdWfr28crQ1782F2gcNu/ZJGoJ3CwVBP3NjA0HfgtybG5Sjq2f+OidVSVDztpz/bLeHXcnzKInApYZjezODY+8vjFhydhOUqXEsMKFxnpZCbDmQ8rQPyOM7OwakHO8qcJyB45zcUR7yFB6i3/UkhJmziacUzVz7KOV/NTSfT7IYTWFDuf/AOazmw5v2FcpgIJqp9W23qQoBQRv5M4d5CbLze0OmjBZSeO4+iBpezPGPl0fSZ24O12612r5yVR5efHsG+E8JJ0tcO1cpvVqmSogBUGtDm4tZIrJhF4zqDKSGwK7cQaCOACCE/s+hptuXG0YDyPOGBVQiyIPvSL5li2Zv05Ip9IkAXFla97ITG8b6uuveGCHD7qKqKKURbMlpHebQoUkBS8pvYkmU1t+6T6P7So6NiwvkCdbgSSVKOXwHyj4PdA/hnzOIA7G25DhcsIMT8OX+ZqWZH9HNPIzjMnusGii3+j4c0RiykT1tw9QRRwSGVG2vAtLN3mJXottEwoBHi/jCqtFyjLzoYy7rYcDm3AINHifC2B1Kk5xCYuHbuV/evk2ft4PFZ/QWHNFcQaNoYB0cAYK6Zw2lrlpsIVM2gj2NqsDDlVoEr4kExarOhtmS+OciZU8WnzBOXZGWsb+y3W74Kb/b9G0+JaK/YfwHCqvjavvXdd7E9d893mHTIm9kj1n9uMZv2xrpcYbXYLHuiDWFEZTww2UuiZ1rgyY0FzK/p4bJhOqaVRRkR1KrEY3chmpOmNiDVV2tCGdTW1N0ZbmLVP60HbBmIeQ0W78ysbkSjPoKrYZOToeSn/WtUH0OIPJfjxSr5I++DS6014k3BB7Ytvm6l11iJoXYjFGvgcLQaiRb7lLhw/Lt1CXev59wOMQxsXTPw1dpLz4oseGvPhQgKYusYPbRgf52SpIWwHCKrbwfA4pnBlbKGWh5P+h0tI/1sAaViGM/5UWcKZyLTmOQvA2GG4UYk7yPB8R1V1ULvB3RcncLeMrBtXYl6ckCGn6+wpgM2i3XJ0gKnX4kCjGu0nK2cLyUNzrrEUFgWNw5pwZXoT3QlZbgBFHomxXxbWk9pQ+zDQfyP0EDeaAElnb8dohDP8/U0Tl2RtOyxjFpIxD36gN7nfsdROo60gd5ET5m4mnTklnZKpzCMgF82j42Lzu5/St/+601SrNcwD3W2gS7pE9/k0DfjyXzou3og8R5es46ebz1NRmCiS6hP7DO8hw+ERuUK9h2WH0EHtNok5kn/WMqWDILpOqQIBg/QHinI46Fdlo1vEL2neVE8MyS+RjegABZBrjJwkApKjvQFja9I7Voj9qmSsj9snOKEkEWEze55XKb7qBDyfvTSxJvuicmMMjZS+bPQEBNP1kDwkdwHCHzTNBwftf7140b9dj4YT7ldrbwY9zo5ehp/aZnkWWz+YZwNk8S7vL37h0yIzFeFKcb4X3JRO0COxO1Iuw5J+QuBUm2s39nTRduwNIlWOuwfU5+NpbpZ0o5Tif09oXdQ22Vmiddp/GnKOAPB0R1AUno0uyuqU20aZkq/QWCpCVJpYGtSCLGNGn6xz+RQj85m5I4mz5ZkEfHpl+Pe9x8d8qEgoEZD3wF3YK5hGneZ8uCP1/w538olPkxLOO+24Cewzo4ZodASmeBix2PwJwiE7fxtPJwpF8YlXXcGfO9W2pYCisTWPt4aM5uqxJjczTM4gs09JQhPONzZ92xjVBe22yh+BHLu66dBngnzpPWQw8ZyOMX4+lvJ8pL0iUNoSZLtOOux8PhRDslyD6I4sQk5YOjQ2bbuQcWrAjoyiFQGlUz3qzPnTHbgvmaRXFBq1gyBVGrkKompK2b90lRrd7CofPlT9qve+/LnPiLPm9gGx1xO98fLPL1dxINSRaqVYDdiiaTksAsl2JMGpZ04rt2PU429lUy6JOojSxZBzK9skxjSFz+R8cXKlyPpwqFocFf1jBZ2exu6TSblLStMaBCW9GjKkFBKDOvYKFH0FIhrgl9rzciLDWocFV2PITwKpMH63QCda22M6lmD1te1BlnqpEz2YPyev/FMbghi494ZOALCU9PuqmMt58UaG8taQaQP1RZkQmIABOXTmirhvZ/u1zQ0AFdnwotkDA9V+1GbXrq7WFKbSdPdhaZVRooSEWLzHBXpGoNEiPbgFh1cbDgLsKUl1azQ2TL6CGJRrdGvTMXW6SLwLGhLkGlgc/iQbH6+N2rF1BHx8PE2ml7GVEDK+7yzkGoK2TnL0wHLWYQiXFdbZFVlUyV6QUYN2ICGujRmlN+PZomQ8x3wvrHbZYXjCaQR+KdSUbcSadbMamFRhdXpyinNW0LQlOpaPbbojvOSC09QbHnvK1+L9eqmrKbmU/6h6uIYUOc+lHqHMGAVXTB21QsTsemYy2eUgC6MMGwMFwxUcD/yh80mQ/BczDv7UeAed9QHUdm6hmNvWgnzpsSG/7YFKXuUpL85c1YoB9v1LDPEsLhpERvhYJFiDYjsvxZ3Uvks077OmRBfN9HklroHl0wRw7fSU7T7u/Npq841OrSs/+quCREQwLnErrwIjPxpXJ9LUjaHrvmMvXzFQb1V/F9D1cvfxGSRAmYZHoEVPp3IMe42Vhue2uIJrHMBfoZgyhVW8eOzFt5zqAMWDoewbdcpif4oSGIMNpV+DFd4hzdBif6vC5Z7S82alhST/8jEKai5SPSdH9haPGX0H9JDBXuhFZ4mv/RQoQ+oS9LGIJi2u3b+An++7Se/3PuQKDZYmWLqbOFqNxA9imr2HhdvpKFHeEEuDsuGykJUzNhjwNr4Yv7OLOeA6tTP+Zywxpao+cTJ/gAFoz+lpElNPl8Xow+mFeYp43WldcJFPZxwuPPIVcQ6lpqTKZrmcdPcWnBZvjnczAir8ss3lIgdk3t1NyqTcyMCnZbIZyo+4OUofkjEEZ7Pw2ow62qJDEGCsIRbK04dSNjdYHk0Yp5YqtEpOCw/Da278kIk5lxl1DBeRsqhy+F/f2ZgBsojlxPxS/zh2yrO22o+dcLbEF+pdYro0XzlvII09SfgUOedYkOwVvYgu6DLK3hhIeBWNENBThoP3VauSgnn0QkoTVYhlYS+l+TyHUOlEdrvToYTfIAi2iPJLdj2K38z21e0PxSBWn2UHveTvEqi2qdR9PHk3J7TsRvpYJhtLmbTzcsvq+mt7qyq5rEiH3FFlcVyMaDNwct9qXPOP0vV880+Pnr2vyLpThceWqiH60yIyg+/jyvuZkpBFvKkeJWe8+Z6rhWAnS9vWxgi6LJjjDKuhhN4+dx6fZY8CTg03AZWy+QYMazRarDmQ1J9/IPWChTyrCemPVpQDCSb0PEOn3LkpNCVc6SBUBMHqBkpBrb22W3copOu7S15SReBAOLFNs8SbMeq8DAWAAp6ByDUMHOwiZkZNUnYybe41HggB2sLizVVvmQd82VYhagAh4IX8Q/WoeOSsIYvOafYcOhjeYD5yI1uZ9uPlEEBEAndpr/ehh++5dRL2EQBofHAPRPe39RLufhC6CILjr50lRVGzlwVEK17t/zNAwb6Sdt6Gq6utM5yiEcpIOfIoE28IWw5yZf4boSL2VIPrAmAakffRU1vByUf/KI6A9zMpD55+Sm8EETRhKCtdxeS3VeyB5LTmnDxIdU4svh0aptYw+sLpV3PzmtQeH6uAvKpADJsbqV4OoATF7b+zEOZicE7NLdYiPfuAOu9z6flJZytGIAEoFTDMfgRCy7JgcCGTt+966vWXT0pFAdzikMVNfnEyn1+lFFEbtY+XzApNhWAYo56mNcrM1McH9r+7w/5BmH4I/mmz9FBYhmqlTOKWtzGt8nIy3zXc1awOKKVpAJ8cUOFgmBBAxts4oRU3fyuYygt7d5M3PjyRvyRpx8l07cYrjm/rQtKAMZrHlP6PwwbJJTGJQJbe1JnjpEO0sJjyu2Oaadqtp+ShysxkiVtXi9iii6jMZelbnmjcueZgAAAAA=');
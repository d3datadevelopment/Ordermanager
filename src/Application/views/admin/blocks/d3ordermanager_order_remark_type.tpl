[{d3modcfgcheck modid="d3_ordermanager"}][{/d3modcfgcheck}]

[{if $mod_d3_ordermanager}]
    [{if $allitem->oxremark__oxtype->value == "d3om"}][{oxmultilang ident="D3_ORDERMANAGER_REMARK_NOTE"}][{else}][{$smarty.block.parent}][{/if}]
[{else}]
    [{$smarty.block.parent}]
[{/if}]
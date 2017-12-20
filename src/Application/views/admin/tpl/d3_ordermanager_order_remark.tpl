[{block name="d3ordermanager_remark_replace"}][{strip}]
    [{capture name="sOxidContent" assign="remark_items"}][{strip}]
        [{include file=$sOriginalTplName}]
    [{/strip}][{/capture}]
[{/strip}][{/block}]

[{$oView->d3FixRemarkItems($remark_items)}]

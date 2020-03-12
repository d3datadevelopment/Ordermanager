[{assign var="sLineSeparator" value="@new_line@"}]

[{*** special chars ***************}]
[{*  new line    => "@new_line@"  *}]
[{*  tab         => "@tab@"       *}]
[{*  white space => "@space@"     *}]
[{*********************************}]

[{strip}]
    [{capture assign="sHeadArea"}]
        [{if $aFieldList}]
            [{literal}]<?xml version="1.0" encoding="UTF-8"?>[{/literal}][{$sLineSeparator}]
        [{/if}]
    [{/capture}]
[{/strip}]

[{strip}]
    [{capture assign="sContentArea"}]
        [{if $aContentList}]
            <ORDER id="[{$aContentList.oxid}]">[{$sLineSeparator}]
            [{foreach name="contentlist" key="contentlistkey" from=$aContentList item="sContent"}]
                @tab@<ORDERFIELD name="[{$contentlistkey}]">[{$sLineSeparator}]
                    @tab@@tab@[{$sContent}][{$sLineSeparator}]
                @tab@</ORDERFIELD>[{$sLineSeparator}]
            [{/foreach}]
            </ORDER>[{$sLineSeparator}]
        [{/if}]
    [{/capture}]
[{/strip}]
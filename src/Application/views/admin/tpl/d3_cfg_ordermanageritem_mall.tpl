[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="oxidCopy" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{if $edit->getId() && !$edit->getLicenseActive()}]
    <table cellspacing="0" cellpadding="0" border="0" style="width:98%;">
        <tr>
            <td valign="top" class="edittext" colspan="2">
                <div class="extension_warning">[{oxmultilang ident="D3_ORDERMANAGER_ERROR_IEXECJOBSLIMIT"}]</div>
            </td>
        </tr>
    </table>
[{/if}]

[{oxmultilang ident="D3_ORDERMANAGER_ERROR_NOMALL"}]

[{include file="d3_cfg_mod_inc.tpl"}]
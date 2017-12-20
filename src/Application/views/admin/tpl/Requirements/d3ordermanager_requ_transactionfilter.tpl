<dl class="[{$blActionRestriction}]">
    <dt>
        <input type="hidden" name="value[blCheckTransaction_status]" value="0">
        <input id="RequTransStatus" class="edittext ext_edittext" type="checkbox" name="value[blCheckTransaction_status]" value='1' [{if $edit->getValue('blCheckTransaction_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
        <label for="RequTransStatus">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TRANSACTION"}]</label>
    </dt>
    <dd>
        [{if $oView->isEditMode()}]
            <SELECT class="editinput" name="value[sOrderTransStatus]" size="1" [{$blActionRestriction}] [{$readonly}]>
                [{foreach from=$oView->getTransStatusList() item="sStatus"}]
                    <option value="[{$sStatus}]" [{if $edit->getValue('sOrderTransStatus') == $sStatus}]selected[{/if}]>
                        [{assign var="sStatusMLIdent" value="D3_ORDERMANAGER_REQU_ORDERTRANSSTATUS_"|cat:$sStatus}]
                        [{oxmultilang ident=$sStatusMLIdent}]
                    </option>
                [{/foreach}]
            </SELECT>
        [{else}]
            [{foreach from=$oView->getTransStatusList() item="sStatus"}]
                [{if $edit->getValue('sOrderTransStatus') == $sStatus}]
                    [{assign var="sStatusMLIdent" value="D3_ORDERMANAGER_REQU_ORDERTRANSSTATUS_"|cat:$sStatus}]
                    [{oxmultilang ident=$sStatusMLIdent}],
                [{/if}]
            [{/foreach}]
        [{/if}]
        [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TRANSACTION_DESC"}]
    </dd>
    <div class="spacer"></div>
</dl>
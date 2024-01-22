[{block name="ordermanager_admin_requ_transactionfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_transactionfilter_editor"}]
                    <label for="sOrderTransStatus" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_TRANSACTION"}]</label>
                    <SELECT id="sOrderTransStatus" class="editinput" name="value[sOrderTransStatus]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getTransStatusList() item="sStatus"}]
                            <option value="[{$sStatus}]" [{if $edit->getValue('sOrderTransStatus') == $sStatus}]selected[{/if}]>
                                [{assign var="sStatusMLIdent" value="D3_ORDERMANAGER_REQU_ORDERTRANSSTATUS_"|cat:$sStatus}]
                                [{oxmultilang ident=$sStatusMLIdent}]
                            </option>
                        [{/foreach}]
                    </SELECT>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_transactionfilter_viewer"}]
                    [{foreach from=$oRequ->getTransStatusList() item="sStatus"}]
                        [{if $edit->getValue('sOrderTransStatus') == $sStatus}]
                            [{assign var="sStatusMLIdent" value="D3_ORDERMANAGER_REQU_ORDERTRANSSTATUS_"|cat:$sStatus}]
                            [{oxmultilang ident=$sStatusMLIdent}],
                        [{/if}]
                    [{/foreach}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TRANSACTION_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
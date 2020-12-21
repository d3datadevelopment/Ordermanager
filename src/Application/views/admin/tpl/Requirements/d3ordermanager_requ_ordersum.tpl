[{block name="ordermanager_admin_requ_ordersum"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_ordersum_editor"}]
                    <label for="sOrderSumType" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM"}]</label>
                    <SELECT id="sOrderSumType" class="editinput" name="value[sOrderSumType]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="total" [{if $edit->getValue('sOrderSumType') == 'total'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMTYPE_TOTAL"}]</option>
                        <option value="article" [{if $edit->getValue('sOrderSumType') == 'article'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMTYPE_ARTICLE"}]</option>
                    </SELECT>

                    <label for="sOrderSumRelation" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM"}]</label>
                    <SELECT id="sOrderSumRelation" class="editinput" name="value[sOrderSumRelation]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        <option value="higher" [{if $edit->getValue('sOrderSumRelation') == 'higher'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMREL_HIGHER"}]</option>
                        <option value="lower" [{if $edit->getValue('sOrderSumRelation') == 'lower'}]selected[{/if}]>[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMREL_LOWER"}]</option>
                    </SELECT>

                    <input id="RequOrderSumValue" style="text-align: right;" class="editinput" type="text" size="8" maxlength="20" name="value[sOrderSumValue]" value="[{if $edit->getValue('sOrderSumValue')}][{$edit->getValue('sOrderSumValue')}][{else}]0.00[{/if}]" [{$blActionRestriction}] [{$readonly}]>
                    <label for="RequOrderSumValue">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM_DEFCUR"}]</label>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_ordersum_viewer"}]
                    [{if $edit->getValue('sOrderSumType') == 'total'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMTYPE_TOTAL"}]
                    [{/if}]
                    [{if $edit->getValue('sOrderSumType') == 'article'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMTYPE_ARTICLE"}]
                    [{/if}]

                    [{if $edit->getValue('sOrderSumRelation') == 'higher'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMREL_HIGHER"}]
                    [{/if}]
                    [{if $edit->getValue('sOrderSumRelation') == 'lower'}]
                        [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUMREL_LOWER"}]
                    [{/if}]

                    [{if $edit->getValue('sOrderSumValue')}][{$edit->getValue('sOrderSumValue')}][{else}]0.00[{/if}]
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM_DEFCUR"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ORDERSUM_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
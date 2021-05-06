[{block name="ordermanager_admin_requ_ordersum"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckOrderSum_status]" value="0">
            <input id="RequOrderSum" class="edittext ext_edittext" type="checkbox" name="value[blCheckOrderSum_status]" value='1' [{if $edit->getValue('blCheckOrderSum_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequOrderSum">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_ordersum_editor"}]
                    <label for="sOrderSumType" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM"}]</label>
                    <SELECT id="sOrderSumType" class="editinput" name="value[sOrderSumType]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getSumTypeList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue('sOrderSumType') == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>

                    <label for="sOrderSumRelation" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM"}]</label>
                    <SELECT id="sOrderSumRelation" class="editinput" name="value[sOrderSumRelation]" size="1" [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oRequ->getRelationList() key="type" item="translation"}]
                            <option value="[{$type}]" [{if $edit->getValue('sOrderSumRelation') == $type}]selected[{/if}]>[{oxmultilang ident=$translation}]</option>
                        [{/foreach}]
                    </SELECT>

                    <input id="RequOrderSumValue" style="text-align: right;" class="editinput" type="text" size="8" maxlength="20" name="value[sOrderSumValue]" value="[{if $edit->getValue('sOrderSumValue')}][{$edit->getValue('sOrderSumValue')}][{else}]0.00[{/if}]" [{$blActionRestriction}] [{$readonly}]>
                    <label for="RequOrderSumValue">[{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM_DEFCUR"}]</label>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_ordersum_viewer"}]
                    [{foreach from=$oRequ->getSumTypeList() key="type" item="translation"}]
                        [{if $edit->getValue('sOrderSumType') == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]

                    [{foreach from=$oRequ->getRelationList() key="type" item="translation"}]
                        [{if $edit->getValue('sOrderSumRelation') == $type}]
                            [{oxmultilang ident=$translation}]
                        [{/if}]
                    [{/foreach}]

                    [{if $edit->getValue('sOrderSumValue')}][{$edit->getValue('sOrderSumValue')}][{else}]0.00[{/if}]
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_ORDERSUM_DEFCUR"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ORDERSUM_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]

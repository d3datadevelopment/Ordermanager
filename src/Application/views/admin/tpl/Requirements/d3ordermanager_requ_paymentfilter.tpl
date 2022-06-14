[{block name="ordermanager_admin_requ_paymentfilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_paymentfilter_editor"}]
                    <input type="hidden" name="value[sPaymentId]" value="">
                    <label for="sPaymentId" style="position: absolute; left: -2000px">[{oxmultilang ident="D3_ORDERMANAGER_REQU_PAYMENT"}]</label>
                    <SELECT class="editinput" name="value[sPaymentId][]" id="sPaymentId" size="5" multiple [{$blActionRestriction}] [{$readonly}]>
                        [{foreach from=$oView->getPaymentList() item="oPayment"}]
                            <option value="[{$oPayment->getId()}]" [{if is_array($edit->getValue('sPaymentId')) && in_array($oPayment->getId(), $edit->getValue('sPaymentId'))}]selected[{/if}]>
                                [{block name="ordermanager_admin_requ_paymentfilter_editor_paymentname"}]
                                    [{$oPayment->getFieldData('oxdesc')}]
                                [{/block}]
                            </option>
                        [{/foreach}]
                    </SELECT><br>
                    [{oxmultilang ident="D3_ORDERMANAGER_REQU_MULTIPLE"}]<br>
                    <input type="button" onclick="selectAllListElems(document.getElementById('sPaymentId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_ALL"}]" [{$blActionRestriction}] [{$readonly}]> <input type="button" onclick="selectNoListElems(document.getElementById('sPaymentId')); return false;" value="[{oxmultilang ident="D3_GENERAL_ORDERMANAGER_SELECT_NONE"}]" [{$blActionRestriction}] [{$readonly}]>
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_paymentfilter_viewer"}]
                    <ul>
                        [{foreach from=$oView->getPaymentList() item="oPayment"}]
                            [{if is_array($edit->getValue('sPaymentId')) && in_array($oPayment->getId(), $edit->getValue('sPaymentId'))}]
                                <li>
                                    [{block name="ordermanager_admin_requ_paymentfilter_viewer_paymentname"}]
                                        [{$oPayment->getFieldData('oxdesc')}]
                                    [{/block}]
                                </li>
                            [{/if}]
                        [{/foreach}]
                    </ul>
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_PAYMENT_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
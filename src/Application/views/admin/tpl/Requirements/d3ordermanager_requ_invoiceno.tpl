[{block name="ordermanager_admin_requ_invoiceno"}]
    <dl class="[{$blActionRestriction}]">
        <dt>
            <input type="hidden" name="value[blCheckInvoiceNum_status]" value="0">
            <input id="RequInvoiceNum" class="edittext ext_edittext" type="checkbox" name="value[blCheckInvoiceNum_status]" value='1' [{if $edit->getValue('blCheckInvoiceNum_status') == 1}]checked[{/if}] [{$blActionRestriction}] [{$readonly}]>
            <label for="RequInvoiceNum">[{oxmultilang ident="D3_ORDERMANAGER_REQU_INVOICENUM"}]</label>
        </dt>
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_invoiceno_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_invoiceno_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_INVOICENUM_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
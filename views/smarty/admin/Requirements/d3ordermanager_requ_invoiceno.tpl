[{block name="ordermanager_admin_requ_invoiceno"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
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
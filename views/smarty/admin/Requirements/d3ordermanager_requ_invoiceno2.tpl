[{block name="ordermanager_admin_requ_invoiceno2"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_invoiceno2_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_invoiceno2_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_INVOICENUM2_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
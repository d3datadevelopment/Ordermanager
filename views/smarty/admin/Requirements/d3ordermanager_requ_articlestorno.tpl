[{block name="ordermanager_admin_requ_articlestorno"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_articlestorno_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_articlestorno_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_ARTICLESTORNO_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
[{block name="ordermanager_admin_requ_trackcodefilter"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="@d3ordermanager/admin/inc/d3ordermanager_activeswitch.tpl" oActionRequ=$oRequ blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_requ_trackcodefilter_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_requ_trackcodefilter_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_REQU_TRACKCODE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
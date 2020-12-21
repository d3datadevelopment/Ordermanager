[{block name="ordermanager_admin_action_stornoorder"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_stornoorder_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_stornoorder_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERSTORNO_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
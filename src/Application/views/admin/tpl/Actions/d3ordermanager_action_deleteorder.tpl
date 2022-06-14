[{block name="ordermanager_admin_action_deleteorder"}]
    <dl class="[{$blActionRestriction}]">
        [{include file="d3ordermanager_activeswitch.tpl" oActionRequ=$oAction blActionRestriction=$blActionRestriction readonly=$readonly}]
        <dd>
            [{if $oView->isEditMode()}]
                [{block name="ordermanager_admin_action_deleteorder_editor"}]
                [{/block}]
            [{else}]
                [{block name="ordermanager_admin_action_deleteorder_viewer"}]
                [{/block}]
            [{/if}]
            [{oxinputhelp ident="D3_ORDERMANAGER_ACTION_ORDERDELETE_DESC"}]
        </dd>
        <div class="spacer"></div>
    </dl>
[{/block}]
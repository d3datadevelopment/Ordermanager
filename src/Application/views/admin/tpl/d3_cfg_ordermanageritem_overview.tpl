[{include file="headitem.tpl" title="D3_ORDERMANAGER_OVERVIEW"|oxmultilangassign}]

<style type="text/css">
    .ext_edittext {
        padding: 2px;
    }
</style>

<script type="text/javascript">
    <!--
    [{if $updatelist == 1}]
        UpdateList('[{$oxid}]');
    [{/if}]

    function UpdateList( sID)
    {
        var oSearch = parent.list.document.getElementById("search");
        oSearch.oxid.value=sID;
        oSearch.fnc.value='';
        oSearch.submit();
    }

    function EditThis( sID)
    {
        var oTransfer = document.getElementById("transfer");
        oTransfer.oxid.value=sID;
        oTransfer.cl.value='';
        oTransfer.submit();

        var oSearch = parent.list.document.getElementById("search");
        oSearch.actedit.value = 0;
        oSearch.oxid.value=sID;
        oSearch.submit();
    }

    function _groupExp(el)
    {
        var _cur = el.parentNode;

        if (_cur.className == "exp") _cur.className = "";
          else _cur.className = "exp";
    }

    function selectAllListElems(el)
    {
        var aSelectLen = el.length;
        for(i = 0; i < aSelectLen; i++)
        {
            el.options[i].selected = true;
        }
    }

    function selectNoListElems(el)
    {
        var aSelectLen = el.length;
        for(i = 0; i < aSelectLen; i++)
        {
            el.options[i].selected = false;
        }
    }

    -->
</script>

<style type="text/css">
    <!--
    .questbox{
        background-color: #07f;
        color: white;
        float: right;
        position: relative;
        display: block;
        padding: 1px 4px;
        font-weight: bold;
        z-index: 98;
        cursor: help;
        font-family: Verdana,Arial,Helvetica,sans-serif;
        font-size: 10px;
    }

    .helptextbox{
        background-color: white;
        color: black;
        border: 1px solid black;
        position: absolute;
        overflow: hidden;
        padding: 5px;
        margin-top: 15px;
        width: 300px;
        z-index: 99;
    }

    fieldset{
        border: 1px inset black;
        background-color: #F0F0F0;
    }

    legend{
        font-weight: bold;
    }

    .groupExp dl dt{
        font-weight: normal;
        width: 40%;
        padding-left: 10px;
    }

    .groupExp dl dd {
        margin-left: 42%;
    }
    -->
</style>


[{assign var="readonly" value="readonly disabled"}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
    <input type="hidden" name="actshop" value="[{$shop->id}]">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

[{if $oView->getDataOnDemand()}]
    <form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink()}]" method="post">
        [{$oViewConf->getHiddenSid()}]
        <input type="hidden" name="cl" value="[{$oViewConf->getActiveClassName()}]">
        <input type="hidden" name="fnc" value="setRequestData">
        <input type="hidden" name="oxid" value="[{$oxid}]">
        <input type="hidden" name="sRequestData" value="">
        <input type="hidden" name="editval[d3_cfg_mod__oxid]" value="[{$oxid}]">
[{/if}]

    <table border="0" width="98%">
        [{if $edit->getId() && !$edit->getLicenseActive()}]
            <tr>
                <td valign="top" class="edittext" colspan="2">
                    <div class="extension_warning">[{oxmultilang ident="D3_ORDERMANAGER_ERROR_IEXECJOBSLIMIT"}]</div>
                </td>
            </tr>
        [{/if}]

        <tr>
            <td valign="top" class="edittext">

                <div class="groupExp">
                    <div class="exp">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_OVERVIEW_STAT"}]
                            </b>
                        </a>
                        <dl>
                            <dt>
                                [{oxmultilang ident="D3_ORDERMANAGER_STAT_FINISHED"}] [{oxinputhelp ident="D3_ORDERMANAGER_STAT_FINISHED_DESC"}]
                            </dt>
                            <dd>
                                [{assign var="mFinishedCount" value=$oView->getFinishedCount()}]
                                [{$mFinishedCount}]
                                [{if $oView->getDataOnDemand()}]
                                    <input type="hidden" name="finishedCount" value="[{$mFinishedCount}]">
                                    [{if false == $oView->hasRequestedData('finishedCount', 'getFinishedCount')}]
                                        <span style="float: left;">
                                            <span class="d3modcfg_btn icon d3color-green">
                                                <button type="submit" name="requestData" onclick="oForm = document.getElementById('myedit'); oForm.sRequestData.value='getFinishedCount'; oForm.submit();">
                                                    <i class="fa fa-check-circle fa-inverse"></i>
                                                    [{oxmultilang ident="D3_ORDERMANAGER_STAT_REQUESTDATA"}]
                                                </button>
                                            </span>
                                        </span>
                                    [{/if}]
                                [{/if}]
                            </dd>
                            <div class="spacer"></div>
                        </dl>
                        <dl>
                            <dt>
                                [{oxmultilang ident="D3_ORDERMANAGER_STAT_FINISHEDMONTH"}] [{oxinputhelp ident="D3_ORDERMANAGER_STAT_FINISHEDMONTH_DESC"}]
                            </dt>
                            <dd>
                                [{assign var="mFinishedMonthCount" value=$oView->getFinishedMonthCount()}]
                                [{$mFinishedMonthCount}]
                                [{if $oView->getDataOnDemand()}]
                                    <input type="hidden" name="finishedMonthCount" value="[{$mFinishedMonthCount}]">
                                    [{if false == $oView->hasRequestedData('finishedMonthCount', 'getFinishedMonthCount')}]
                                        <span style="float: left;">
                                            <span class="d3modcfg_btn icon d3color-green">
                                                <button type="submit" name="requestData" onclick="oForm = document.getElementById('myedit'); oForm.sRequestData.value='getFinishedMonthCount'; oForm.submit();">
                                                    <i class="fa fa-check-circle fa-inverse"></i>
                                                    [{oxmultilang ident="D3_ORDERMANAGER_STAT_REQUESTDATA"}]
                                                </button>
                                            </span>
                                        </span>
                                    [{/if}]
                                [{/if}]
                            </dd>
                            <div class="spacer"></div>
                        </dl>
                        <dl>
                            <dt>
                                [{oxmultilang ident="D3_ORDERMANAGER_STAT_TOFINISHED"}] [{oxinputhelp ident="D3_ORDERMANAGER_STAT_TOFINISHED_DESC"}]
                            </dt>
                            <dd>
                                [{assign var="mToFinishedCount" value=$oView->getToFinishedCount()}]
                                [{$mToFinishedCount}]
                                [{if $oView->getDataOnDemand()}]
                                    <input type="hidden" name="toFinishedCount" value="[{$mToFinishedCount}]">
                                    [{if false == $oView->hasRequestedData('toFinishedCount', 'getToFinishedCount')}]
                                        <span style="float: left;">
                                            <span class="d3modcfg_btn icon d3color-green">
                                                <button type="submit" name="requestData" onclick="oForm = document.getElementById('myedit'); oForm.sRequestData.value='getToFinishedCount'; oForm.submit();">
                                                    <i class="fa fa-check-circle fa-inverse"></i>
                                                    [{oxmultilang ident="D3_ORDERMANAGER_STAT_REQUESTDATA"}]
                                                </button>
                                            </span>
                                        </span>
                                    [{/if}]
                                [{/if}]
                            </dd>
                            <div class="spacer"></div>
                        </dl>
                        <dl>
                            <dt>
                                [{oxmultilang ident="D3_ORDERMANAGER_STAT_NOTFINISHED"}] [{oxinputhelp ident="D3_ORDERMANAGER_STAT_NOTFINISHED_DESC"}]
                            </dt>
                            <dd>
                                [{assign var="mNotFinishedCount" value=$oView->getNotFinishedCount()}]
                                [{$mNotFinishedCount}]
                                [{if $oView->getDataOnDemand()}]
                                    <input type="hidden" name="notFinishedCount" value="[{$mNotFinishedCount}]">
                                    [{if false == $oView->hasRequestedData('notFinishedCount', 'getNotFinishedCount')}]
                                        <span style="float: left;">
                                            <span class="d3modcfg_btn icon d3color-green">
                                                <button type="submit" name="requestData" onclick="oForm = document.getElementById('myedit'); oForm.sRequestData.value='getNotFinishedCount'; oForm.submit();">
                                                    <i class="fa fa-check-circle fa-inverse"></i>
                                                    [{oxmultilang ident="D3_ORDERMANAGER_STAT_REQUESTDATA"}]
                                                </button>
                                            </span>
                                        </span>
                                    [{/if}]
                                [{/if}]
                            </dd>
                            <div class="spacer"></div>
                        </dl>
                    </div>
                </div>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_OVERVIEW_REQU"}]
                            </b>
                        </a>

                        [{assign var="aRequList" value=$oView->getRequirementList()}]
                        [{assign var="blActiveRequ" value=false}]

                        [{foreach from=$aRequList item="oRequ"}]
                            [{if $oRequ->isActive()}]
                                [{include file=$oRequ->getTplName()}]
                                [{assign var="blActiveRequ" value=true}]
                            [{/if}]
                        [{/foreach}]

                        [{if $blActiveRequ == false}]
                            <dl>
                                <dd>
                                    [{oxmultilang ident="D3_ORDERMANAGER_OVERVIEW_NOREQUEST" }]
                                </dd>
                            </dl>
                        [{/if}]

                    </div>
                </div>

                <div class="groupExp">
                    <div class="">
                        <a class="rc" onclick="_groupExp(this); return false;" href="#">
                            <b>
                                [{oxmultilang ident="D3_ORDERMANAGER_OVERVIEW_ACTION"}]
                            </b>
                        </a>

                        [{assign var="aActionList" value=$oView->getActionList()}]
                        [{assign var="blActiveAction" value=false}]

                        [{foreach from=$aActionList item="oAction"}]
                            [{if $oAction->isActive()}]
                                [{include file=$oAction->getTplName()}]
                                [{assign var="blActiveAction" value=true}]
                            [{/if}]
                        [{/foreach}]

                        [{if $blActiveAction == false}]
                            <dl>
                                <dd>
                                    [{oxmultilang ident="D3_ORDERMANAGER_OVERVIEW_NOACTION"}]
                                </dd>
                            </dl>
                        [{/if}]
                    </div>
                </div>
            </td>
        </tr>
    </table>
[{if $oView->getDataOnDemand()}]
    </form>
[{/if}]

[{include file="d3_cfg_mod_inc.tpl"}]
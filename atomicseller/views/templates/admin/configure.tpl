{*
* Configuration Page content.
*}


<div class="bootstrap">
    <div class="page-head custom-tab">
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav">
                <li class="active">
                    <a href="#pscontent" data-toggle="tab">{l s='Content' d='Modules.Blockreassurance.Admin'}</a>
                </li>
                <li>
                    <a href="#display" data-toggle="tab">{l s='Display' d='Modules.Blockreassurance.Admin'}</a>
                </li>
                <li>
                    <a href="#appearance" data-toggle="tab">{l s='Appearance' d='Modules.Blockreassurance.Admin'}</a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="bootstrap" id="psreassurance_configuration">
    <!-- Module content -->
    <div id="modulecontent" class="clearfix">
        <!-- Tab panes -->
        <div class="tab-content row">
            {if !$folderIsWritable}
                {include file="./alert_folder_writable.tpl"}
            {/if}
            <div class="tab-pane active" id="pscontent">
                <div class="tab_cap_listing">
                    {include file="./tabs/content.tpl"}
                </div>
            </div>
            <div class="tab-pane" id="display">
                <div class="tab_cap_listing">
                    {include file="./tabs/display.tpl"}
                </div>
            </div>
            <div class="tab-pane" id="appearance">
                <div class="tab_cap_listing">
                    {include file="./tabs/appearance.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>
{include file="./addons-suggestion.tpl"}

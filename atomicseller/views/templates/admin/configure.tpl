{*
* Configuration Page content.
*}


<div class="bootstrap">
    <div class="page-head custom-tab">
        <div class="page-head-tabs" id="head_tabs">
            <ul class="nav">
                <li class="active">
                    <a href="#labelSettings" data-toggle="tab">
                        <i class="icon-cogs">
                            {l s='&nbsp;Label Settings' d='Modules.AtomicSeller.Admin'}
                        </i>
                    </a>
                </li>
                <li>
                    <a href="#emailSettings" data-toggle="tab">
                        <i class="icon-envelope">
                            {l s='&nbsp;Display' d='Modules.AtomicSeller.Admin'}
                        </i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="bootstrap" id="tab_content">
    <!-- Module content -->
    <div id="modulecontent" class="clearfix">
        <!-- Tab panes -->
        <div class="tab-content row">
            <div class="tab-pane active" id="labelSettings">
                <div class="tab_cap_listing">
                    {include file="./tabs/label.tpl"}
                </div>
            </div>
            <div class="tab-pane" id="emailSettings">
                <div class="tab_cap_listing">
                    {include file="./tabs/email.tpl"}
                </div>
            </div>
        </div>
    </div>
</div>

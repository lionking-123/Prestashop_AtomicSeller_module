<div class="panel panel-default col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0">
    <div class="panel-heading">
        {l s='Email Settings' d='Modules.AtomicSeller.Admin'}
    </div>

    <div class="panel-body">
        <div class="clearfix">

            <div class="form-group">
                <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                    <input type="text" id="title" name="EMAIL_TITLE_MODEL"
                           value="{if isset($email_title)}{$email_title|escape:'htmlall':'UTF-8'}{/if}" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                    <textarea type="text" id="content" name="WS_STOREKEY" style="height:200px;">
                        {if isset($email_content)}{$email_content|escape:'htmlall':'UTF-8'}{/if}
                    </textarea>
                </div>
            </div>

        </div>
    </div>

    <div class="panel-footer">
        <div class="col-xs-11 text-right">
            <button name="saveEmailConf" id="saveEmailConf" type="submit" class="btn btn-primary">{l s='Save' d='Modules.AtomicSeller.Admin'}</button>
        </div>
    </div>
</div>

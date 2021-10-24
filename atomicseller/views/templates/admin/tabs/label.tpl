<div class="panel panel-default col-lg-10 col-lg-offset-1 col-xs-12 col-xs-offset-0">
    <div class="panel-heading">
        {l s='Label Settings' d='Modules.AtomicSeller.Admin'}
    </div>

    <div class="panel-body">
        <div class="clearfix">

            <div class="form-group">
                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Webservice Token : ' d='Modules.AtomicSeller.Admin'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                    <input type="text" id="wsToken" name="WS_TOKEN"
                           value="{if isset($ws_token)}{$ws_token|escape:'htmlall':'UTF-8'}{/if}" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-4 col-sm-3 col-md-2 col-lg-2">
                    <div class="text-right">
                        <label class="control-label">
                            {l s='Webservice Storekey : ' d='Modules.AtomicSeller.Admin'}
                        </label>
                    </div>
                </div>
                <div class="col-xs-7 col-sm-8 col-md-9 col-lg-9">
                    <input type="text" id="wsStorekey" name="WS_STOREKEY"
                           value="{if isset($ws_storekey)}{$ws_storekey|escape:'htmlall':'UTF-8'}{/if}" />
                </div>
            </div>

        </div>
    </div>

    <div class="panel-footer">
        <div class="col-xs-11 text-right">
            <button name="testConnection" id="testConnection" type="submit" class="btn btn-primary">{l s='Test Connection' d='Modules.AtomicSeller.Admin'}</button>
        </div>
    </div>
</div>

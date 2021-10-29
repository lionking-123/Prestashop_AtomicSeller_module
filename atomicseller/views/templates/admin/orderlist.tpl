<div class="atomicseller-panel row" id="atomicseller_panel">
    <div class="row">
        <div class="panel panel-default col-md-12" style="padding:0;">
            <div class="panel-heading">
                <h4>
                    {l s='Order List' d='Modules.AtomicSeller.Admin'}
                </h4>
            </div>

            <div class="panel-body">
                <div class="clearfix">
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width:15%">Order Ref</th>
                                    <th style="width:20%">Date</th>
                                    <th style="width:10%">Status</th>
                                    <th style="width:30%">Customer Name</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th style="width:15%">
                                        <input type="text" id="order_ref" value="{if isset($order_ref)}{$order_ref|escape:'html':'UTF-8'}{/if}" />
                                    </th>
                                    <th style="width:20%">
                                        <input type="text" id="order_date" value="{if isset($order_date)}{$order_date|escape:'html':'UTF-8'}{/if}" />
                                    </th>
                                    <th style="width:10%">
                                        <input type="text" id="order_status" value="{if isset($order_status)}{$order_status|escape:'html':'UTF-8'}{/if}" />
                                    </th>
                                    <th style="width:30%">
                                        <input type="text" id="customer_name" value="{if isset($customer_name)}{$customer_name|escape:'html':'UTF-8'}{/if}" />
                                    </th>
                                    <th>
                                        <button type="button" id="seachBtn" class="btn btn-primary">Search</button>
                                        <button type="button" id="resetBtn" class="btn btn-warning">Reset</button>
                                    </th>
                                </tr>
                            </thead>

                            <tbody id="orderBody">
                                <tr>
                                    <td colspan="5">No data to display.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-default col-md-12" id="orderDetail">
            <div class="panel-heading">
                <h4>
                    {l s='Order Detail' d='Modules.AtomicSeller.Admin'}
                </h4>
            </div>

            <div class="panel-body">
                <div class="clearfix">
                    <div class="row">
                        <table class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
                            <tr>
                                <td style="width:25%;" class="text-right">Order reference : </td>
                                <td style="width:75%;" >
                                    <input type="text" id="det_order_ref" disabled />
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;" class="text-right">DepositDate : </td>
                                <td style="width:75%;" >
                                    <input type="text" id="det_order_date" disabled />
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;" class="text-right">ParcelReference : </td>
                                <td style="width:75%;" >
                                    <input type="text" id="det_parcel_ref" disabled />
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;" class="text-right">ParcelDescription : </td>
                                <td style="width:75%;" >
                                    <input type="text" id="det_parcel_desc" disabled />
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;" class="text-right">ParcelWeight : </td>
                                <td style="width:75%;" >
                                    <input type="text" id="det_parcel_weight" disabled />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input type="text" style="display:none;" id="emailContent" value="" />
                </div>
            </div>

            <div class="panel-footer">
                <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 text-right">
                    <button id="getLabelBtn" type="button" class="btn btn-primary" onclick="getReturnLabel()" disabled>Get return label</button>
                    <button id="sendEmailBtn" type="button" class="btn btn-success" onclick="sendEmail()" disabled>Send by email</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    {strip}
        {addJsDef reset_flag=$reset_flag|boolval}
    {/strip}

    {literal}
    $(document).ready(function() {
        $("#content").removeClass("nobootstrap");
        $("#content .bootstrap .page-head").append($("#atomicseller_panel"));
        if(!reset_flag) $("#resetBtn").prop("disabled", true);
    });
    {/literal}
</script>

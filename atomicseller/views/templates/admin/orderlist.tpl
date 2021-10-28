<div class="atomicseller-panel row" id="atomicseller_panel">
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
                                    <button type="button" id="seachBtn">Search</button>
                                    <button type="button" id="resetBtn">Reset</button>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            {if count($data) > 0}
                                {foreach $data as $d}
                                <tr>
                                    <td>{$d['reference']}</td>
                                    <td>{$d['date']}</td>
                                    <td>{$d['status']}</td>
                                    <td>{$d['customer']}</td>
                                    <td>
                                        <button type="button" >View</button>
                                    </td>
                                </tr>
                                {/foreach}
                            {else}
                                <tr>
                                    <td colspan="5">No data to display.</td>
                                </tr>
                            {/if}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#content").removeClass("nobootstrap");
        $("#content .bootstrap .page-head").append($("#atomicseller_panel"));
        {if $reset_flag==false}
            $("#resetBtn").disabled = true;
        {else}
            $("#resetBtn").disabled = false;
        {/if}
    });
</script>
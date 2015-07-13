<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/templates.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/default/css/custom.css">
        
        <style>
            .color-l { color: #aaa; }
            .color-n { color: #888; }
            .color-d { color: #555; }
            .border-bottom-l {  border-color: #aaa;  }
            .border-bottom-n {  border-color: #888;  }
            .border-bottom-d {  border-color: #555;  }
            .border-top-l {  border-color: #aaa;  }
            .border-top-n {  border-color: #888;  }
            .border-top-d {  border-color: #555;  }
            .background-l { background-color: #eee; }
            .company-name,
            .invoice-id {
                color: #333 !important;
            }
            .item-font {
                font-size: 11px;
            }
            .top-header{
                padding-top: 100px;
            }

        </style>
        
  </head>
  <body>
        <div id="header" class="top-header">
            <table>
                <tr>
                    <td style="width:70%">
                        <div style="display: block; height: 2cm"></div>

                        <div class="invoice-to">
                            <p><b><?php echo lang('bill_to'); ?> </b>: <?php echo $invoice->client_name; ?></p>
                                <?php if ($invoice->client_vat_id) {
                                    echo '<b>'.lang('vat_id_short') . '</b> : ' . $invoice->client_vat_id . '<br/>';
                                } ?>
                                <?php if ($invoice->client_tax_code) {
                                    echo '<b>'.lang('tax_code_short') . '</b> : ' . $invoice->client_tax_code . '<br/>';
                                } ?>
                                <?php if ($invoice->client_address_1) {
                                    echo '<b>'.lang('address'). '</b>: '.$invoice->client_address_1 . '<br/>';
                                } ?>
                                <?php if ($invoice->client_address_2) {
                                    echo $invoice->client_address_2 . '<br/>';
                                } ?>
                                <?php if ($invoice->client_state) {
                                    echo $invoice->client_state . '.';
                                } ?>
                                <?php if ($invoice->client_city) {
                                    echo $invoice->client_city . ' ';
                                } ?>
                                <?php if ($invoice->client_zip) {
                                    echo $invoice->client_zip . '.';
                                } ?>
                                <br>
                                <?php if ($invoice->client_phone) { ?>
                                    <b><?php echo lang('phone_abbr'); ?></b>: <?php echo $invoice->client_phone; ?><br/>
                                <?php } ?>
                            </p>
                        </div>

                    </td>
                </tr>
            </table>
        </div>

        <h2 class="invoice-id text-right"><?php echo lang('invoice'); ?>: <?php echo $invoice->invoice_number; ?></h2>
        <h4 class="text-right"><?php echo lang('invoice_date_emission'); ?>: &nbsp; <b><?php echo date_from_mysql($invoice->invoice_date_created, TRUE); ?></b></h4>
        <h4 class="text-right"><?php echo lang('payment_form'); ?>: &nbsp; <b><?php echo $payment_method->payment_method_name; ?></b></h4>
        <br>
        <div class="invoice-items">
            <table class="table table-striped" style="width: 100%;">
                <thead>
                    <tr class="border-bottom-d">
                        <th class="color-d"><?php echo lang('product_sku'); ?></th>
                        <th class="color-d"><?php echo lang('item_name'); ?></th>
                        <th class="text-right color-d"><?php echo lang('qty'); ?></th>
                        <th class="text-right color-d"><?php echo lang('price'); ?></th>
                        <th class="text-right color-d"><?php echo lang('total'); ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $linecounter = 0;
                    foreach ($items as $item) { ?>
                        <tr class="border-bottom-n <?php echo ($linecounter % 2 ? 'background-l' : '')?>">
                            <td class="item-font"><?php echo $item->item_name; ?></td>
                            <td class="item-font"><?php echo nl2br($item->item_description); ?></td>
                            <td class="item-font text-right">
                                <?php echo format_amount($item->item_quantity); ?>
                            </td>
                            <td class="item-font text-right">
                                <?php echo format_currency($item->item_price); ?>
                            </td>
                            <td class="item-font text-right">
                                <?php echo format_currency($item->item_subtotal); ?>
                            </td>
                        </tr>
                        <?php $linecounter++; ?>
                    <?php } ?>

                </tbody>
            </table>
            <table>
                <tr>
                    <td class="text-right">
                        <table class="amount-summary">
                            <tr>
                                <td class="text-right-n">
                                    <?php echo lang('subtotal'); ?>:
                                </td>
                                <td class="text-right">
                                    <?php echo format_currency($invoice->invoice_item_subtotal); ?>
                                </td>
                            </tr>
                            <?php if ($invoice->invoice_item_tax_total > 0) { ?>
                                <tr>
                                    <td class="text-right">
                                        <?php echo lang('item_tax'); ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo format_currency($invoice->invoice_item_tax_total); ?>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php foreach ($invoice_tax_rates as $invoice_tax_rate) : ?>
                                <tr>
                                    <td class="text-right">
                                        <?php echo $invoice_tax_rate->invoice_tax_rate_name . ' ' . $invoice_tax_rate->invoice_tax_rate_percent; ?>%
                                    </td>
                                    <td class="text-right">
                                        <?php echo format_currency($invoice_tax_rate->invoice_tax_rate_amount); ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>

                            <tr class="border-top-l amount-total">
                                <td class="text-right color-d">
                                    <b><?php echo lang('total'); ?>:</b>
                                </td>
                                <td class="text-right color-d">
                                    <b><?php echo format_currency($invoice->invoice_total); ?></b>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div class="seperator border-bottom-l"></div>
            <?php if ($invoice->invoice_terms) { ?>
                <h4><?php echo lang('terms'); ?></h4>
                <p><?php echo nl2br($invoice->invoice_terms); ?></p>
            <?php } ?>
            
        </div>
  </body>
</html>

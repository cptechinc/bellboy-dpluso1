<table class="table table-bordered table-striped table-condensed">
    <tr> <td>Price </td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <tr> <td>Unit of Measurement</td> <td> <?= $linedetail->uom ?></td> </tr>
    <tr>
        <td>Case Qty</td>
        <td class="text-right">
            <input type="text" class="form-control pull-right input-sm text-right qty" name="case-qty" value="<?= $linedetail->get_caseqty(); ?>">
            <?php if ($linedetail->get_caseqty()) : ?>
                <button type="button" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="<?= $linedetail->get_casebottleqty().' bottles'; ?>">?</button>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Bottle Qty</td>
        <td class="text-right"><input type="text" class="form-control pull-right input-sm text-right qty" name="case-qty" value="<?= $linedetail->get_bottleqty(); ?>"></td>
    </tr>
    <tr> <td>Original Ext. Amt.</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice * $linedetail->quotqty); ?></td> </tr>
    <?php if ($appconfig->child('name=sales-orders')->show_originalprice) : ?>
        <tr> <td>Original Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_listprice) : ?>
        <tr> <td>List Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->listprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_cost) : ?>
        <tr> <td>Cost</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->cost); ?></td> </tr>
    <?php endif; ?>
    <tr><td>Kit:</td><td><?php echo $linedetail->kititemflag; ?></td></tr>
</table>

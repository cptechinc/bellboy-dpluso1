<table class="table table-bordered table-striped table-condensed">
    <tr> <td>Price </td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <tr> <td>Unit of Measurement</td> <td> <?= $linedetail->uom ?></td> </tr>
    <tr>
        <td>Case Qty</td>
        <td class="text-right">
            <?= $linedetail->get_caseqty(); ?>
            <?php if ($linedetail->get_caseqty()) : ?>
                <button type="button" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="<?= $linedetail->get_casebottleqty().' bottles'; ?>">?</button>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>Bottle Qty</td>
        <td class="text-right"><?= $linedetail->get_bottleqty(); ?></td>
    </tr>
    <tr> <td>Original Ext. Amt.</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice * $linedetail->quotqty); ?></td> </tr>
    <?php if ($appconfig->child('name=sales-orders')->show_originalprice) : ?>
        <tr> <td>Original Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->quotprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_listprice) : ?>
        <tr> <td>List Price</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->listquotprice); ?></td> </tr>
    <?php endif; ?>
    <?php if ($appconfig->child('name=sales-orders')->show_cost) : ?>
        <tr> <td>Cost</td> <td class="text-right">$ <?= $page->stringerbell->format_money($linedetail->cost); ?></td> </tr>
    <?php endif; ?>
    <tr><td>Kit:</td><td><?php echo $linedetail->kititemflag; ?></td></tr>
</table>

<h4>Edit Price</h4>
<table class="table table-bordered table-striped table-condensed">
    <tr>
        <td class="control-label">Case Qty</td>
        <td><input type="text" class="form-control pull-right input-sm text-right qty" name="case-qty" value="<?= $linedetail->get_caseqty(); ?>"></td>
    </tr>
    <tr>
        <td class="control-label">Bottle Qty</td>
        <td><input type="text" class="form-control pull-right input-sm text-right qty" name="bottle-qty" value="<?= $linedetail->get_bottleqty(); ?>"></td>
    </tr>
    <tr>
        <td class="control-label">Price</td>
        <td>
            <div class="input-group">
                <div class="input-group-addon input-sm">$ </div>
                <input type="text" class="form-control input-sm text-right price" name="price" value="<?= $page->stringerbell->format_money($linedetail->quotprice); ?>">
            </div>
        </td>
    </tr>

    <?php if ($appconfig->child('name=sales-orders')->use_discount) : ?>
        <tr>
            <td class="control-label">Discount Amt.</td>
            <td>
                <div class="input-group">
                    <div class="input-group-addon input-sm">$</div>
                    <input type="text" class="form-control input-sm text-right discount-amt" value="<?= $page->stringerbell->format_money(($linedetail->discpct / 100) * $linedetail->quotprice); ?>">
                </div>
            </td>
        </tr>
        <tr>
            <td class="control-label">Discount %</td>
            <td>
                <div class="input-group">
                    <input type="text" class="form-control input-sm text-right discount-percent" name="discount" value="<?= $page->stringerbell->format_money($linedetail->discpct); ?>">
                    <div class="input-group-addon input-sm">%</div>
                </div>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <td class="control-label">Extended Amount</td>
        <td>
            <div class="input-group">
                <div class="input-group-addon input-sm">$</div>
                <input type="text" class="form-control input-sm text-right totalquotprice" value="<?= $page->stringerbell->format_money($linedetail->quotprice * $linedetail->quotqty); ?>" disabled>
            </div>
        </td>
    </tr>
</table>

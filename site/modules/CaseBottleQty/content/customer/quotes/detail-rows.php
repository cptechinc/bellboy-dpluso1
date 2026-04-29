<tr class="detail">
	<th></th>
	<th class="text-center">Item ID</th>
	<th colspan="2">Description</th>
	<th>Price</th>
	<th>Case Qty</th>
	<th>Bottle Qty</th>
	<th>Ext Price</th>
	<th>Notes</th>
	<th></th>
</tr>

<?php $details = $quotepanel->get_quotedetails($quote); ?>

<?php foreach ($details as $detail) : ?>
	<tr class="detail">
		<td></td>
		<td class="text-center">
			<?= $quotepanel->generate_detailvieweditlink($quote, $detail); ?>
		</td>
		<td colspan="2">
			<?php if (strlen($detail->vendoritemid)) { echo ' '.$detail->vendoritemid."<br>";} ?>
			<?= $detail->desc1; ?>
		</td>
		<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice); ?></td>
		<td class="text-right">
            <?= $detail->get_caseqty(); ?>
            <?php if ($detail->get_caseqty()) : ?>
                <button type="button" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="<?= $detail->get_casebottleqty().' bottles'; ?>">?</button>
            <?php endif; ?>
        </td>
        <td class="text-right"><?= $detail->get_bottleqty(); ?></td>
		<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice * $detail->quotqty); ?></td>
		<td><?= $quotepanel->generate_loaddplusnoteslink($quote, $detail->linenbr); ?></td>
		<td></td>
	</tr>
<?php endforeach; ?>

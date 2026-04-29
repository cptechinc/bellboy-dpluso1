<tr>
	<th>Detail</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("ordernumber") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
				Order # <?= $orderpanel->tablesorter->generate_sortsymbol('ordernumber'); ?>
		</a>
	</th>
	<th> Customer </th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("custpo") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Customer PO: <?= $orderpanel->tablesorter->generate_sortsymbol('custpo'); ?>
		</a>
	</th>
	<th>Ship-To</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("orderdate") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Date: <?= $orderpanel->tablesorter->generate_sortsymbol('orderdate'); ?>
		</a>
	</th>
	<th width="100">
		<a href="<?= $orderpanel->generate_sortbyURL("total_order") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Totals <?= $orderpanel->tablesorter->generate_sortsymbol('total_order'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("invdate") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Invoice Date: <?= $orderpanel->tablesorter->generate_sortsymbol('invdate'); ?>
		</a>
	</th>
	<th colspan="4">
		<?= $orderpanel->generate_iconlegend(); ?>
		<?php if (isset($input->get->orderby)) : ?>
				<?= $orderpanel->generate_clearsortlink(); ?>
		<?php endif; ?>
	</th>
</tr>

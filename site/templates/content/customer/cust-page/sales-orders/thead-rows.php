<tr>
	<th>Detail</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("ordernumber") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order # <?= $orderpanel->tablesorter->generate_sortsymbol('ordernumber'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("custpo") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Customer PO: <?= $orderpanel->tablesorter->generate_sortsymbol('custpo'); ?>
		</a>
	</th>
	<th>Ship-To</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("total_order") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Totals <?= $orderpanel->tablesorter->generate_sortsymbol('total_order'); ?>
		</a>
	</th>
	<th>
		<a href="<?= $orderpanel->generate_sortbyURL("order_date") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Order Date: <?= $orderpanel->tablesorter->generate_sortsymbol('order_date'); ?>
		</a>
	</th>
	<th class="text-center">
		<a href="<?= $orderpanel->generate_sortbyURL("status") ; ?>" class="load-link" <?= $orderpanel->ajaxdata; ?>>
			Status: <?= $orderpanel->tablesorter->generate_sortsymbol('status'); ?>
		</a>
	</th>
	<th colspan="2">
		<?= $orderpanel->generate_iconlegend(); ?>
		<?php if (isset($input->get->orderby)) : ?>
			<a href="<?= $orderpanel->generate_clearsortURL(); ?>" class="btn btn-warning btn-sm load-link" data-loadinto="<?= $orderpanel->loadinto; ?>" data-focus="<?= $orderpanel->focus; ?>">
				Clear Sorting
			</a>
		<?php endif; ?>
	</th>
	<th colspan="2"> </th>
</tr>

<?php $customer = Customer::load($quote->custid, $quote->shiptoid); ?>
<div class="form-group hidden-print">
	<a href="<?= $quotedisplay->generate_printURL($quote); ?>" target="_blank">
		<span class="h3"><i class="fa fa-print" aria-hidden="true"></i></span> View Printable Quote
	</a>
</div>
<div class="row">
	<div class="col-sm-6">
		<img src="<?= $appconfig->companylogo->url; ?>" class="img-responsive" alt="<?= $appconfig->companydisplayname.' logo'; ?>">
	</div>
	<div class="col-sm-6 text-right">
		<h1>Summary for Quote # <?= $qnbr; ?></h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr>
				<td>CustID</td>
				<td>
					<?= $quote->custid; ?> - <a href="<?= $customer->generate_customerURL(); ?>"><?= $customer->get_customername(); ?></a>
					<span class="glyphicon glyphicon-share"></span>
				</td>
			</tr>
			<tr>
				<td>ShiptoID</td> <td><?= $quote->shiptoid; ?></td>
			</tr>
			<tr> <td>Quote Date</td> <td class="text-right"><?= $quote->quotdate; ?></td> </tr>
			<tr> <td>Review Date</td> <td class="text-right"><?= $quote->revdate; ?></td> </tr>
			<tr> <td>Expire Date</td> <td class="text-right"><?= $quote->expdate; ?></td> </tr>
			<tr> <td>Terms Code</td> <td><?= $quote->termcodedesc; ?></td> </tr>
			<tr> <td>Tax</td> <td><?= $quote->taxcodedesc; ?></td> </tr>
			<tr> <td>Sales Person</td> <td><?= $quote->sp1; ?></td> </tr>
		</table>
	</div>

	<div class="col-sm-6">
		<table class="table table-bordered table-striped table-condensed">
			<tr> <td>Customer PO</td> <td><?= $quote->custpo; ?></td> </tr>
			<tr> <td>Cust Ref</td> <td><?= $quote->custref; ?></td> </tr>
			<tr> <td>Ship Via</td> <td><?= $quote->shipviacd.' - '.$quote->shipviadesc; ?></td> </tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header"><h3>Bill-to</h3></div>
		<address>
			<?= $quote->billname; ?><br>
			<?= $quote->billaddress; ?><br>
			<?php if (strlen($quote->billaddress2) > 0) : ?>
				<?= $quote->billaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->billcity.", ".$quote->billstate." ".$quote->billzip; ?>
		</address>
	</div>
	<div class="col-sm-6">
		<div class="page-header"><h3>Ship-to</h3></div>
		<address>
			<?= $quote->shipname; ?><br>
			<?= $quote->shipaddress; ?><br>
			<?php if (strlen($quote->shipaddress2) > 0) : ?>
				<?= $quote->shipaddress2; ?><br>
			<?php endif; ?>
			<?= $quote->shipcity.", ".$quote->shipstate." ".$quote->shipzip; ?>
		</address>
	</div>
</div>
<table class="table table-bordered table-condensed">
	 <tr class="detail item-header active">
		 <th class="text-right">Case Qty</th>
 		<th class="text-right">Bottle Qty</th>
		<th class="text-center">Item</th>
		<th>Description</th>
		<th>U/M</th>
		<th class="text-right" width="100">Price</th>
		<th class="text-right">Line Total</th>
	</tr>
	<?php $details = $quotedisplay->get_quotedetails($quote); ?>
	<?php foreach ($details as $detail) : ?>
		<tr class="detail table-bordered">
			<td class="text-right"><?= $detail->get_caseqty(); ?></td>
			<td class="text-right"><?= $detail->get_bottleqty(); ?></td>
			<td class="text-center"><?= $detail->itemid; ?></td>
			<td><?= $detail->desc1; ?></td>
			<td><?=$detail->uom; ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice); ?></td>
			<td class="text-right">$ <?= $page->stringerbell->format_money($detail->quotprice * intval($detail->quotqty)) ?> </td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="row">
	<div class="col-xs-9"></div>
	<div class="col-xs-3">
		<table class="table table-condensed pull-right">
			<tr><td class="col-xs-6"><label>Subtotal</label></td> <td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($quote->subtotal); ?></td></tr>
			<tr><td class="col-xs-6"><label>Tax</label></td> <td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($quote->salestax); ?></td></tr>
			<tr><td class="col-xs-6"><label>Freight</label></td> <td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($quote->freight); ?></td></tr>
			<tr><td class="col-xs-6"><label>Misc.</label></td> <td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($quote->misccost); ?></td></tr>
			<tr class="active"><td class="col-xs-6"><label>Total</label></td> <td class="text-right col-xs-6">$ <?= $page->stringerbell->format_money($quote->ordertotal); ?></td></tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<a href="<?= $quotedisplay->generate_editURL($quote); ?>" class="btn btn-block btn-warning">
			<i class="fa fa-pencil" aria-hidden="true"></i> Edit Quote
		</a>
	</div>
	<div class="col-sm-6">
		<a href="<?= $quotedisplay->generate_customershiptoURL($quote); ?>" class="btn btn-block btn-primary">
			<i class="fa fa-user" aria-hidden="true"></i> Go To Customer Page
		</a>
	</div>
</div>
</br>
<?php if ($session->panelorigin == 'quotes') :  ?>
	<?php $url = $session->panelcustomer ? $quotedisplay->generate_customershiptoURL($quote) : $config->pages->dashboard; ?>
	<a href="<?= $url; ?>" class="btn btn-block btn-info">
		<span class="fa fa-arrow-circle-left" aria-hidden="true"></span> Back to Panel
	</a>
<?php endif; ?>

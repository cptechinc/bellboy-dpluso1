<?php 
    /** @var string $custID */
    /** @var ProcessWire\Modules $modules */
    /** @var ProcessWire\Config $config */
    
    use App\Dplus\Database\InvItemsTable;
    use App\Dplus\Database\PoItemsTable;
    use App\Dplus\Database\SoFreqOrderedItemRecord;
    use App\Dplus\Database\SoFreqOrderedItemsTable;
    use App\Dpluso\Database\PricingTable;
    use App\Dpluso\Pricing;

    /** @var ProcessWire\CaseBottleQty */
    $mCaseBottleQty = $modules->get('CaseBottleQty');
    
    $TABLE = SoFreqOrderedItemsTable::instance();
    $ITEMS = InvItemsTable::instance();
    $PRICING = PricingTable::instance();
    $POITEMS = PoItemsTable::instance();

    $items = $TABLE->findByCustomer($custID);
    $itemPrices = new ProcessWire\WireArray();

    if ($items->count()) {
        $rqst = new Pricing\PricingRequest();
        $rqst->custid = $custID;
        $rqst->itemids->setArray($items->explode('itemid'));

        $request = new Pricing\Requests();
        $request->multipleItemPrices($rqst);
        $itemPrices = $PRICING->findBySessionid(session_id());

        foreach ($items as $item) {
            /** @var SoFreqOrderedItemRecord $item */
            $item->itmitem = $ITEMS->fetch($item->itemid);
            $item->nextShipment = $POITEMS->fetchNextExpectedShipment($item->itemid);
        }
    }
?>

<div class="modal fade" id="frequentlyOrderedModal" tabindex="-1" role="dialog" aria-labelledby="frequentlyOrderedModal-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title" id="frequentlyOrderedModalLabel">
                    Frequently Ordered as 
                    <?php if ($items->count()) : ?>
                        of <?= date('m/d/Y', strtotime($items->first()->freqstartdate)); ?>
                    <?php endif; ?>
                </h4>
            </div>
            <div class="modal-body padding-10px">
                <form action="<?= $config->pages->cart."redir/" ?>" method="POST">
                    <input type="hidden" name="action" value="add-multiple-items-x">
                    <input type="hidden" name="custID" value="<?= $custID; ?>">
                    <div class="list-group">
                        <div class="list-group-item text-bold">

                            <div class="row">
                                <div class="col-md-4">Item</div>
                                <div class="col-md-1 text-right">Available</div>
                                <div class="col-xs-4 text-right col-md-1">On-Order</div>
                                <div class="col-xs-4 text-right col-md-1">ETA</div>
                                <div class="col-xs-4 col-md-1">Sold Price</div>
                                <div class="col-xs-4 col-md-1">Current Price</div>
                                <div class="col-xs-6 col-md-1">Cases</div>
                                <div class="col-xs-6 col-md-1">Bottles</div>
                            </div>
                        </div>
                        <?php foreach ($items->sort('itmitem.description1') as $item) : ?>
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4">
                                        <b><?= $item->itemid; ?></b> <br>
                                        <?= $item->itmitem->description1; ?> <b><?= $item->itmitem->description2; ?></b><br>
                                        <small><b>Last Sale: </b> <?= $mCaseBottleQty->generate_casebottleqtydesc($item->itemid, $item->lastsaleqty); ?> on <?= date('m/d/Y', strtotime($item->lastsaledate)) ?></small>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <?= $itemPrices->has($item->itemid) ? $itemPrices->get($item->itemid)->qty : '0'; ?>
                                    </div>
                                    <div class="col-xs-4 col-md-1 text-right">
                                        <?= $item->nextShipment ? intval($item->nextShipment->qtyordered) : 0; ?>
                                    </div>
                                    <div class="col-xs-4 col-md-1 text-right">
                                        <?= $item->nextShipment ? date('m/d/Y', strtotime($item->nextShipment->expectedDate)) : ''; ?>
                                    </div>
                                    <div class="col-xs-4 col-md-1">
                                        $<?= number_format($item->lastsaleprice, 2); ?>
                                    </div>
                                    <div class="col-xs-4 col-md-1">
                                        <?= $itemPrices->has($item->itemid) ? '$' . number_format($itemPrices->get($item->itemid)->price, 2) : 'N/A'; ?>
                                    </div>
                                    <div class="col-xs-6 col-md-1">
                                        <label for="" class="visible-xs">Cases</label>
                                        <input type="text" name="caseQty[<?= $item->itemid; ?>]" class="form-control input-sm qty text-right">
                                    </div>
                                    <div class="col-xs-6 col-md-1">
                                        <label for="" class="visible-xs">Bottles</label>
                                        <input type="text" name="bottleQty[<?= $item->itemid; ?>]" class="form-control input-sm qty text-right">
                                    </div>
                                </div>
                                
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
                <div class="table-responsive hidden-xs collapse">
                    <form action="<?= $config->pages->cart."redir/" ?>" method="POST">
                        <input type="hidden" name="action" value="add-multiple-items-x">
                        <input type="hidden" name="custID" value="<?= $custID; ?>">

                        <table class="table table-striped mb-3" id="freqOrdered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Last Sale Date</th>
                                    <th>Last Qty Purchased</th>
                                    <th>Last Sale Price</th>
                                    <th>Current Price</th>
                                    <th>Cases</th>
                                    <th>Bottles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($items->count() == 0) : ?>
                                    <tr>
                                        <td colspan="8">No Frequently Ordered Items</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($items->sort('itmitem.description1') as $item) : ?>
                                    <tr>
                                        <td>
                                            <b><?= $item->itemid; ?></b> <br>
                                            <?= $item->itmitem->description1; ?> <b><?= $item->itmitem->description2; ?></b>
                                        </td>
                                        <td><?= date('m/d/Y', strtotime($item->lastsaledate)) ?></td>
                                        <td><?= $mCaseBottleQty->generate_casebottleqtydesc($item->itemid, $item->lastsaleqty); ?></td>
                                        <td>$<?= number_format($item->lastsaleprice, 2); ?></td>
                                        <td>
                                            <?= $itemPrices->has($item->itemid) ? '$' . number_format($itemPrices->get($item->itemid)->price, 2) : 'N/A'; ?>
                                        </td>
                                        <td>
                                            <input type="text" name="caseQty[<?= $item->itemid; ?>]" class="form-control input-sm qty text-right">
                                        </td>
                                        <td>
                                            <input type="text" name="bottleQty[<?= $item->itemid; ?>]" class="form-control input-sm qty text-right">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

$(function() {
    $("body").on("change", ".calculates-price", function(e) {
        var line = $(this).closest('.detail');
        var case_qty = line.find("input[name=case-qty]");
        var bottle_qty = line.find("input[name=bottle-qty]");
        var qty_percase = line.find("input[name=qty-percase]");
        var input_price = line.find("input[name=price]");
        var input_minprice = line.find("input[name=min-price]");
        var text_totalprice = line.find('.total-price');
            
        // ADD code to calculate total price
        var total = case_qty.val() + (bottle_qty / qty_percase) * input_price.val();
        // Replace value in text_totalprice
        $(text_totalprice).text(total.formatMoney(2, '.', ','));
        // check if config.edit.pricing.allow_belowminprice is true

        if (config.edit.pricing.allow_belowminprice == true) {
            // if it is then check if price is below minimum allowed
            if (input_price.val() < input_minprice.val()) {
                input_price.parent().addClass('has-error');
                line.find('.response').createalertpanel('Item price below minimum!', 'Error!', 'danger');
            } else if (input_price.val() > input_minprice.val()) {
                input_price.parent().removeClass('has-error');
                line.find('.response').empty();
            }
        }
    });

    $("body").on("submit", ".quick-entry-add", function(e) {
        var form = $(this);
        var itemsearch = form.find('input[name=itemID]').val();
        var custID = form.find('input[name=custID]').val();
        var bottle_qtyfield = form.find('input[name=bottle-qty]');
        var case_qtyfield = form.find('input[name=case-qty]');
        
        if (form.attr('data-validated') != itemsearch) {
            e.preventDefault();
            var searchurl = URI(config.urls.json.validateitemid).addQuery('itemID', itemsearch).toString();
            $.getJSON(searchurl, function(json) {
                if (json.exists) {
                    var validitemid = json.itemID;
                    form.attr('data-validated', validitemid);
                    form.find('input[name=itemID]').val(validitemid);
                    form.submit();
                } else {
                    swal ({
                        title: 'Item not found.',
                        text: itemsearch + ' cannot be found.',
                        type: 'warning',
                        confirmButtonClass: 'btn btn-sm btn-success',
                        cancelButtonClass: 'btn btn-sm btn-danger',
                        showCancelButton: true,
                        confirmButtonText: 'Make Dplus search?'
                    }).then(function (result) {
                        var searchURL = new URI(config.urls.products.redir.itemsearch).addQuery('q', itemsearch).addQuery('custID', custID).toString();
                        var resultsURL = new URI(config.urls.load.quickentry_searchresults).addQuery('q', itemsearch).toString();
                        console.log(resultsURL);
                        showajaxloading();
                        
                        $.get(searchURL, function() {
                            form.find('.qe-results').loadin(resultsURL, function() {
                                
                                hideajaxloading();
                                if (focus.length > 0) {
                                    $('html, body').animate({scrollTop: $(focus).offset().top - 60}, 1000);
                                }
                            });
                        });
                    }).catch(swal.noop);
                }
            });
        } else if (case_qtyfield.val() == '') {
            e.preventDefault();
            bottle_qtyfield.parent().addClass('has-error');
            case_qtyfield.parent().addClass('has-error');
            case_qtyfield.focus();
        } else {
            showajaxloading();
            case_qtyfield.focus();
            form.postform({formdata: false, jsoncallback: false, action: false}, function() {
                var uri = new URI();
                uri.hash('#quick-entry-add');
                window.location.href = uri.toString();
                window.location.reload(true);
            });
        }
    });

    $("body").on("click", ".qe-item-results", function(e) {
        e.preventDefault();
        var item = $(this);
        var itemID = item.data('itemid');
        var qtypercase = item.data('data-qtypercase');
        var form = $(".quick-entry-add");
        form.find('input[name=itemID]').val(itemID);
        form.find('input[name=qty-percase]').val(qtypercase);
        form.find('.qe-results').empty();
        form.attr('data-validated', itemID);
        form.submit();
    });
});

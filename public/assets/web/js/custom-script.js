var site_url = $('.siteurl').data('url');
var currency = '$';
function remove_cart_item(id) {
    swal({
        text: " Do you want to remove item from cart?",
        icon: "warning",
        buttons: true,
        successMode: false,
    }).then((willWishlist) => {
        if (willWishlist) {
            $.ajax({
                url: site_url+'/remove_from_cart_ajax',
                data: {
                    cartid: id
                },
                cache: false,
                success: function(res) {
                    var ress = JSON.parse(res);
                    if (ress.success) {
                        $('#cart_remove' + id + '').fadeOut(1200).css({
                            'background-color': '#f2dede'
                        });
                        get_cart();
                        $('.total').html(currency + ress.total);
                        $('.count').html(ress.count);
                        if (ress.count == '0') {
                            $('body').removeClass('show-mini-cart');
                        }
                    } else {
                        alert("error");
                    }
                }
            });
        }
    });
}

function add_to_cart(id) {
    $('#lpadd_cart' + id + ' button').html('Please wait...');
    var quantity = 1;
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('#lpadd_cart' + id + ' button').html('<i class="icon-cart"></i>Add to cart');
                $('#lpadd_cart' + id).attr('class', 'd-none');
                $('#lpquantitydiv' + id).removeClass('d-none');
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.count').html(ress.count);
                //$('.badge.bg-warning.cart').html(ress.count);
                $('.total').html(currency + ress.total);
                $('.title-item-count').html('(' + ress.count + ' Items)');
            } else {
                //console.log(response);
            }
        }
    });
}
get_cart();

function get_cart() {
    $.ajax({
        url: site_url+"/get_cart_ajax_v2",
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.show-mini-cart-v2').html(ress.data);
                $('.title-item-count').html('(' + ress.count + ' Items)');
                $('.count').html(ress.count);
                $('.total').html(currency + ress.total);
            } else {
                $('.main-cart-title').html('My Cart <span>(' + ress.count + ' Items)</span>');
                //console.log(response);
            }
        }
    });
}
get_wishlist();

function get_wishlist() {
    $.ajax({
        url: site_url+"/get_wishlist_ajax",
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('#top-cart-wishlist-count').html(ress.count);
            } else {
                //console.log(response);
            }
        }
    });
}
$(".minus").on("click", function() {
    id = $(this).attr('data-id');
    value = $(this).attr('data-row');
    quantity = $('#lpinput' + id).val();
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.count').html(ress.count);
                $('.total').html(currency + ress.total);
            } else {
                //console.log(response);
            }
        }
    });
});
$(".plus").on("click", function() {
    id = $(this).attr('data-id');
    value = $(this).attr('data-row');
    quantity = $('#lpinput' + id).val();
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.count').html(ress.count);
                $('.total').html(currency + ress.total);
            } else {
                //console.log(response);
            }
        }
    });
});

function add_to_cart_cat(id) {
    $('#lpadd_cart' + id + ' button').html('Please wait...');
    var quantity = 1;
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('#lpadd_cart' + id + ' button').html('<i class="icon-cart"></i>Add to cart');
                $('#catadd_cart' + id).attr('class', 'd-none');
                $('#catquantitydiv' + id).removeClass('d-none');
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.badge.bg-warning.cart').html(ress.count);
                $('.col-6.text-right.total').html(currency + ress.total);
            } else {
                //console.log(response);
            }
        }
    });
}
$(".catminus").on("click", function() {
    id = $(this).attr('data-id');
    value = $(this).attr('data-row');
    quantity = $('#catinput' + id).val();
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.badge.bg-warning.cart').html(ress.count);
                $('.col-6.text-right.total').html(currency + ress.total);
            } else {
                //console.log(response);
            }
        }
    });
});
$(".catplus").on("click", function() {
    id = $(this).attr('data-id');
    value = $(this).attr('data-row');
    quantity = $('#catinput' + id).val();
    $.ajax({
        url: site_url+"/add_to_cart_ajax",
        data: {
            product_id: id,
            quantity: quantity
        },
        cache: false,
        success: function(response) {
            var ress = jQuery.parseJSON(response);
            if (ress.success) {
                $('.mini-cart').addClass('open');
                $('.list-cart').html(ress.data);
                $('.badge.bg-warning.cart').html(ress.count);
                $('.col-6.text-right.total').html(currency + ress.total);
            } else {
                //console.log(response);
            }
        }
    });
});
// remove from cart
$('.amr-mc-item-remove').click(function() {
    cartid = $(this).attr('data-id');
    swal({
        text: " Do you want to remove item from cart?",
        icon: "warning",
        buttons: true,
        successMode: false,
    }).then((willWishlist) => {
        if (willWishlist) {
            $.ajax({
                url: '/remove_from_cart',
                data: {
                    cartid: cartid
                },
                cache: false,
                success: function(res) {
                    if (res) {
                        window.location.reload();
                        //$('#cartrow'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                    }
                }
            });
        }
    });
});
// clear cart
$('.clear-item').click(function() {
    swal({
        text: " Do you want to empty cart?",
        icon: "warning",
        buttons: true,
        successMode: false,
    }).then((willWishlist) => {
        if (willWishlist) {
            $.ajax({
                url: '/empty_cart',
                cache: false,
                success: function(res) {
                    if (res) {
                        window.location.reload();
                        //$('#cartrow'+id+'').fadeOut(1200).css({'background-color':'#f2dede'});
                    }
                }
            });
        }
    });
});
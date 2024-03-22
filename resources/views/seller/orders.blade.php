@extends('seller.layouts.common')

@section('content')
    <div class="container-fluid mt-4">
        <div class="orders bg-white p-4 mb-4" style="-webkit-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
-moz-box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);
box-shadow: 0px 1px 5px 3px rgba(209,209,209,1);">
            <table id="myTable" class="table table-reponsive text-start">
                <thead class="text-black text-normal">
                    <tr>
                        <th>Order #</th>
                        <th width="12%">Status</th>
                        <th width="30%">Images</th>
                        <th width="20%">Title</th>
                        <th>Name / Username</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="reportBuyer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="staticBackdropLabel">Report a buyer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body feedback">
                    <p class="text-black">If a buyer has violated <a href="#" class="text-blue">EllyHub policies</a>, let us know. Buyers who violate policy may be warned,
                    blocked from future returns or blocked from future purchases.</p>

                    <label class="text-black fw-bold" style="font-size:23px;"><img src="{{url('public/assets/web/images/green_check.png')}}" width="10%"> You've selected <span class="count_items">{{count($orders)}}</span> item.</label>

                    <p class="text-black mb-2" style="padding-left: 35px;"><b class="text-black">User ID:</b> <span class="userid"></span></p>
                    <p class="text-black" style="padding-left: 35px;"><b class="text-black">Item:</b> <span class="title"></span></p>

                    <h6 class="text-black" style="padding-left: 35px;">Next, tell us what happened</h6>

                    <ul style="padding-left: 35px;">
                        <li>
                            <input type="radio" value="10.00" id="level-1" name="price_level">
                            <label for="level-1" class="text-black fw-normal">Buyer is abusing Ellyhub buyer and seller guidelines</label>
                            <div class="open-radio" style="display: none;">
                                <ul style="padding-left: 35px;">
                                    <li>
                                        <input type="radio" value="10.00" id="level-1-sub" name="price_level_sub">
                                        <label for="level-1-sub" class="text-black fw-normal">Demanded service i don't offer</label>
                                    </li>
                                    <li>
                                        <input type="radio" value="10.00" id="level-2-sub" name="price_level_sub">
                                        <label for="level-2-sub" class="text-black fw-normal">Tried to change the payment method after purchase</label>
                                    </li>
                                    <li>
                                        <input type="radio" value="10.00" id="level-3-sub" name="price_level_sub">
                                        <label for="level-3-sub" class="text-black fw-normal">Requested additional funds</label>
                                    </li>
                                    <li>
                                        <input type="radio" value="10.00" id="level-4-sub" name="price_level_sub">
                                        <label for="level-4-sub" class="text-black fw-normal">Requested i include additional items for free</label>
                                    </li>
                                    <li>
                                        <input type="radio" value="10.00" id="level-5-sub" name="price_level_sub">
                                        <label for="level-5-sub" class="text-black fw-normal">Tried to take the sale from Ellyhub</label>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <input type="radio" value="10.00" id="level-2" name="price_level">
                            <label for="level-2" class="text-black fw-normal">Buyer is being abusive</label>
                        </li>
                        <li>
                            <input type="radio" value="10.00" id="level-3" name="price_level">
                            <label for="level-3" class="text-black fw-normal">Buyer manipulated or returned a completely different item</label>
                        </li>
                    </ul>

                    <div class="row mt-3 after-border" style="padding-left: 35px;">
                        <div class="col-md-2 show-border">
                            <button type="button" class="btn btn-blue rounded-0 position-relative">Submit</button>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="text-blue" style="color:#3279F8">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    var table = $("#myTable").DataTable({

        language: {
            "processing": "Please wait..."
        },

        dom: "frtip",

        //serverSide: fa,

        processing: true,

        stateSave: true,

        bDestroy: true,

        bPaginate : true,

        scrollX: true,

        ajax: {

            url: "{{url("seller/get_orders")}}", // json datasource

            type: "get", // method  , by default get

            cache: false,

            "data": function(data) {

                data.status = $('#status').val();

            },

            error: function(data) { // error handling

                $(".table-grid-error").html("");

                $("#table-grid").append('<tbody class="table-grid-error"><tr><th colspan="6">No data found!</th></tr></tbody>');

                $("#table-grid_processing").css("display", "none");

            },

            complete: function(data) {

                console.log(data);
            }

        },

    });

    $('body').on('click', '.dotted-lines',function(e){
        e.preventDefault();
        $('body').find('.dotted-open').fadeOut();
        $(this).parent().find('.dotted-open').fadeIn();
    });

    $('body').on('click', '.open-modal', function(){
        var id = $(this).data('id');
        $(id).modal('show');

        var items = $(this).data('items');

        var title = $(this).data('title');
        var userid = $(this).data('userid');
        $('.title').html(title);
        $('.count_items').html(items);
        $('.userid').html(userid);
    });

    $('input[name="price_level"]').change(function(){
        var value = $(this).val();
        $('.open-radio').hide();
        console.log($(this).parent());
        $(this).parent().find('.open-radio').show();
    });
</script>
@endsection
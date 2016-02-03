<?php
echo $this->load->view('supplier/header');
?>
<script src="<?php echo base_url() ?>js/jquery-ui-1.10.0.custom.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery-ui-1.10.0.custom.min.css"/>

<!-- LEFT SIDEBAR CONTAINER-->
<div class="nav-bar floatL">

<?php echo $this->load->view('supplier/sidebar'); ?>

</div>

<!-- RIGHT CONTENT CONTAINER-->
<div class='sliderLg floatR'>
    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> Message Detail </div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Buyer's Name: </label>&#160;&#160;<?php echo $msg->buyer_name; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Received On: </label>&#160;&#160;<?php echo $msg->time; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Buyer's Email: </label>&#160;&#160;<?php echo $msg->buyer_email; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Buyer's Phone: </label>&#160;&#160;<?php echo $msg->buyer_phone; ?></p>
            </div>
            <div class="fl half clearfix">
                <p class='p-infoformat fl'> <label class='label-infoformat fl'>Product: </label>&#160;&#160;<a target="_blank" href="<?php echo $msg->product_link; ?>"><?php echo $msg->product_link; ?></a></p>
            </div>
            
           

        </div>

    </div>
    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> Message Content </div>
            </div>
        </div>

        <div class='product-cont padded-cont clearfix'>
            <?php echo $msg->message; ?>
        </div>

    </div>

</div>

<script type="text/javascript">
    $('#message_seller').click(function() {
        $('#popSendEmail').fadeIn();

    })


    $('.close-pop-out').click(function() {
        $('.popout-cont').fadeOut();
        window.location.reload();
    });


    load_inbox();
    function load_inbox()
    {
        $.post('<?php echo base_url() ?>user/personal_message', {id: '<?php echo $bt->bsd_id ?>', action: 'get', '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
            $('#messages-main-cont').html(result);
        });

    }

    function check_reply(id)
    {

    }

    function add_reply(id)
    {
        var reply_content = $('#reply' + id).val();

        $.post('<?php echo base_url() ?>user/personal_message', {reply_content: reply_content, id: id, action: 'addReply', '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
            $('#append-reply' + id).prepend(result);
        });
    }

    $('#status_action').on('change', function() {
        if ($(this).val() == '')
            $('#changeStatusBtn').addClass('disabled').attr('disabled', true);
        else
            $('#changeStatusBtn').removeClass('disabled').removeAttr('disabled');
    });

    $('#changeStatusBtn').on('click', function() {
        var form = $('#statusChangeForm'),
                url = $(form).attr('action'),
                data = $(form).serialize();
        if ($('#status_action').val() == '') {
            alert("Please select order status first!");
            return false;
        }
        $.ajax({
            url: url,
            method: 'POST',
            data: data
        }).done(function(result) {
            alert("Status Changed");
            window.location.reload();
        }).error(function(result) {
            alert("Error during changing");
        });
    });

</script>


<script type="text/javascript" charset="utf-8" src="<?php echo base_url() ?>js/jquery.raty.min.js"></script>
<?php echo $this->load->view('supplier/footer') ?>



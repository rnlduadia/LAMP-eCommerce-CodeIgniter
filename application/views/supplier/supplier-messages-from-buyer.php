<?php echo $this->load->view('supplier/header') ?>
<script src="<?php echo base_url()?>js/jquery-ui-1.10.0.custom.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/jquery-ui-1.10.0.custom.min.css"/>

<!-- LEFT SIDEBAR CONTAINER-->
<div class="nav-bar floatL">
    <?php echo $this->load->view('supplier/sidebar');?>
</div>
<!-- RIGHT CONTENT CONTAINER-->
<div class="sliderLg floatR">
    <div class='right-inner clearfix'>
        <div class="overlay">
            <img src="/images/ajax-payment.gif">
        </div>

        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class="floatl">Messages</div>
            </div>
        </div>

        <form method="get" action="/supplier/messages" id="filter-form">
            <div class='search-container clearfix'></div>
            <input type="hidden" name="action" value="request">
            <input type="submit" style="display: none;">
        </form>
    </div>
</div>
<script type="text/javascript">
    updateTable = function(){
        $('.overlay').show();
        var form_data = $('#filter-form').serialize();
        form_data += '&<?php echo $this->security->get_csrf_token_name()?>=<?php echo $this->security->get_csrf_hash()?>';
        $.post($('#filter-form').attr('action'),form_data,function(data){
            $('.search-container').html(data);
            initPagination();
            initSorter();

            $.each($('.search-container').find('input.for-datepicker'),function(idx,el){
                $(el).datepicker( {"dateFormat" : 'yy-mm-dd' });
            });
            $('.overlay').hide();
        });
        return false;
    };
    $(document).ready(function(){
        updateTable();
        $('form#filter-form').on('submit',updateTable);
    });
</script>
<?php echo $this->load->view('supplier/footer') ?>
<hr>
<hr>
<hr>
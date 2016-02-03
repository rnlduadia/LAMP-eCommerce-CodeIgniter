<?php echo $this->load->view('supplier/header') ?>

<!-- LEFT SIDEBAR CONTAINER-->
<div class="nav-bar floatL">

    <?php echo $this->load->view('supplier/sidebar');?>

</div>

<!-- RIGHT CONTENT CONTAINER-->
<div class='sliderLg floatR'>

    <div class='right-inner clearfix'>

        <!-- First Row Container-->
        <div class="topBrands searching-for">
            <div class="topBrandsHeader">
                <div class'floatl'=""> My Sales </div>
        </div>
    </div>

    <div class='padded-cont'>
        <div class='informative-format'>
            <div class='sales-result-trans clearfix'>

            </div>
        </div>
    </div>

</div>

</div>
<script type="text/javascript">

    /*	var sel_date = $('.range_sel_week').val();

     $('.range_sel_week').change(function(){
     sel_date = $('.range_sel_week').val();
     load_payment_list();
     });*/

    load_payment_list();

    function load_payment_list()
    {
        $.post('<?php echo base_url()?>sale/report',{type:'byweek-all','<?php echo $this->security->get_csrf_token_name()?>':'<?php echo $this->security->get_csrf_hash()?>'},function(result){
            $('.sales-result-trans').html(result);
        });
    }
</script>
<?php echo $this->load->view('supplier/footer') ?>
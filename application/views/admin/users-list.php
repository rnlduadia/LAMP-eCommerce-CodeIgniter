<script type="text/javascript">
function onSubmit() {
    var theForm = $("#users-lis-form");
    theForm.submit();
}


</script>

<form method="POST" action="<?php echo base_url().$user_type;?>/view/<?php  echo $list_type;?>" id="users-lis-form">

    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>" >

<script src="<?php echo HTTP_PROTOCOL;?>://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<?php echo $this->load->view('admin/header') ?>
<div class="global-cont">

    <div class='bg-body'>
        <div class="bg-body-top"> </div>
        <div class="bg-body-middle clearfix">
            <!-- MIDDLE PAGE CONTAINER-->

            <!-- LEFT SIDEBAR CONTAINER-->
            <div id="left-sidebar" class="clearfix fl">
                <?php echo $this->load->view('admin/'.$user_type.'/'.$user_type.'-sidebar') ?>
            </div>

            <?php $has_permission = $this->administrators->check_permission($this->session->userdata('id'),6);?>
            <!-- RIGHT CONTENT CONTAINER-->
            <div class='right-cont clearfix fr'>
                <div class="overlay">
                    <img src="/images/ajax-payment.gif">
                </div>
                <?php if($has_permission){?>
                    <div class='right-inner clearfix'>
                        <div class="heading-inner-right">
                            <p class='breadcrumbs fl'><?php echo ucfirst($list_type).' '.ucfirst($user_type);?>s List:</p>
                        </div>
                        <div class="clear"> </div>

                            <div class='search-container clearfix'>
                                <div class="clearfix">
                                    <label for='filter_operation_company_name' style="width: 120px;" >Company Name</label>
                                    <select id='filter_operation_company_name'  class='medium normal-format-select' name="filter_operation_company_name">
                                        <option value="Contains" <?php echo ( $filter_operation_company_name == "Contains" ? "selected" : "" ) ?> >Contains</option>
                                        <option value="Starts_With" <?php echo ( $filter_operation_company_name == "Starts_With" ? "selected" : "" ) ?> >Stars With</option>
                                        <option value="Equal" <?php echo ( $filter_operation_company_name == "Equal" ? "selected" : "" ) ?> >Equal</option>
                                    </select>
                                    <input type='text' value='<?php echo $filter_company_name ?>' id='filter_company_name' name="filter_company_name"
                                           class='normal-format-text' />
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='search-container clearfix'>
                                <div class="clearfix">
                                    <label for="filter_operation_email" style="width: 120px;" >Email Address</label>
                                    <select id="filter_operation_email"  class="medium normal-format-select" name="filter_operation_email">
                                        <option value="Contains" <?php echo ( $filter_operation_email == "Contains" ? "selected" : "" ) ?> >Contains</option>
                                        <option value="Starts_With" <?php echo ( $filter_operation_email == "Starts_With" ? "selected" : "" ) ?> >Stars With</option>
                                        <option value="Equal" <?php echo ( $filter_operation_email == "Equal" ? "selected" : "" ) ?> >Equal</option>
                                    </select>
                                    <input type='text' value='<?php echo $filter_email ?>' id='filter_email' name="filter_email" class='normal-format-text' />
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='search-container clearfix'>
                                <div class="clearfix">
                                    <label for='filter_operation_username' style="width: 120px;" >User Name</label>
                                    <select id='filter_operation_username' class='medium normal-format-select' name="filter_operation_username">
                                        <option value="Contains" <?php echo ( $filter_operation_username == "Contains" ? "selected" : "" ) ?> >Contains</option>
                                        <option value="Starts_With"  <?php echo ( $filter_operation_username == "Starts_With" ? "selected" : "" ) ?> >Stars With</option>
                                        <option value="Equal" <?php echo ( $filter_operation_username == "Equal" ? "selected" : "" ) ?> >Equal</option>
                                    </select>
                                    <input type='text' value='<?php echo $filter_username ?>' id='filter_username' name="filter_username" class='normal-format-text' />
                                </div>
                                <div class='clear'></div>
                            </div>

                            <div class='search-container clearfix'>
                                <div class="clearfix">
                                    <input type="button" value="SEARCH" id="send-make-search" class="normal-button" style="margin-top:10px;" onclick="javascript:onSubmit(); return false;" />
                                    <div class='clear'></div>
                                </div>
                            </div>

                            <div class='padded-cont'>
                                <?php echo $filter;?>
                                <?php echo $table?>
                                <?php echo $paging?>
                            </div>
                    </div>
                <?php }else{?>
                    <?php echo $this->load->view('admin/permission-error') ?>
                <?php }?>

            </div>
        </div>

        <!-- MIDDLE PAGE CONTAINER-->
    </div>
    <div class="bg-body-bottom"> </div>
</div>
</form>

<script type="text/javascript">
    updateTable = function(){
        $('.overlay').show();
        var form_data = $('#filter-form').serialize();
        form_data += '&<?php echo $this->security->get_csrf_token_name()?>=<?php echo $this->security->get_csrf_hash()?>';
        $.post($('#filter-form').attr('action'),form_data,function(data){
            var cont = $(data).find('form#filter-form').eq(0).html();
            $('#filter-form').html(cont);
            initPagination();
            initSorter();
            $('.overlay').hide();
        });
        return false;
    };
    $(document).ready(function(){
        //updateTable();
        initPagination();
        initSorter();
        $('form#filter-form').on('submit',updateTable);
    });
</script>
<?php echo $this->load->view('admin/footer') ?>
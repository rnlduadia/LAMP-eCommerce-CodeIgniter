<?php echo $this->load->view('supplier/header') ?>
<div class="global-cont">

    <div class='bg-body'>
        <div class="bg-body-top"> </div>
        <div class="bg-body-middle clearfix">
            <!-- MIDDLE PAGE CONTAINER-->


            <!-- LEFT SIDEBAR CONTAINER-->
            <div id="left-sidebar" class="clearfix fl">

                <?php echo $this->load->view('admin/admin/admin-sidebar');?>

            </div>

            <div class='right-cont clearfix fr'>
                <div class='right-inner clearfix'>

                    <!-- First Row Container-->
                    <div class="heading-inner-right">
                        <p class='breadcrumbs fl'>Buyer Search </p>
                    </div>


                    <div class='search-container clearfix'>
                        <div class="clearfix">
                            <label for='filter_operation_company_name' style="width: 120px;" >Company Name</label>
                            <select id='filter_operation_company_name'  class='medium normal-format-select' name="filter_operation_company_name">
                                <option value=Contains>Contains</option>
                                <option value=Starts_With>Stars With</option>
                                <option value=Equal>Equal</option>
                            </select>
                            <input type='text' value='' id='filter_company_name' name="filter_company_name" class='normal-format-text' />
                        </div>
                        <div class='clear'></div>
                    </div>



                    <div class='search-container clearfix'>
                        <div class="clearfix">
                            <label for="filter_operation_email" style="width: 120px;" >Email Address</label>
                            <select id="filter_operation_email"  class="medium normal-format-select" name="filter_operation_email">
                                <option value=Contains>Contains</option>
                                <option value=Starts_With>Stars With</option>
                                <option value=Equal>Equal</option>
                            </select>
                            <input type='text' value='' id='filter_email' name="filter_email" class='normal-format-text' />
                        </div>
                        <div class='clear'></div>
                    </div>



                    <div class='search-container clearfix'>
                        <div class="clearfix">
                            <label for='filter_operation_username' style="width: 120px;" >User Name</label>
                            <select id='filter_operation_username' class='medium normal-format-select' name="filter_operation_username">
                                <option value=Contains>Contains</option>
                                <option value=Starts_With>Stars With</option>
                                <option value=Equal>Equal</option>
                            </select>
                            <input type='text' value='' id='filter_username' name="filter_username" class='normal-format-text' />
                        </div>
                        <div class='clear'></div>
                    </div>


                    <div class='search-container clearfix'>
                        <div class="clearfix">
                            <input type="button" value="SEARCH" id="send-search" class="normal-button" style="margin-top:10px;" onclick="javascript:makeSearch(); return false;" />
                            <div class='clear'></div>
                        </div>
                    </div>



                    <div class='padded-cont'>
                        <div class='violet-table'>
                            <table id='list-buyers-search-result'>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript" language="javascript">

                var brand_sel = '';
                var manufacture_sel = '';

                function makeSearch() {
                    var filter_operation_company_name= $("#filter_operation_company_name").val()
                    var filter_company_name= $("#filter_company_name").val()
                    var filter_operation_username= $("#filter_operation_username").val()
                    var filter_username= $("#filter_username").val()

                    var filter_operation_email= $("#filter_operation_email").val()
                    var filter_email= $("#filter_email").val()

                    //alert( "makeSearch  filter_operation_company_name::"+filter_operation_company_name + "  filter_company_name::"+filter_company_name)

                    $.ajax({
                        url: '/administrator/make_search',
                        dataType: 'html',
                        data: {
                            u_type: 3,
                            operation_company_name: filter_operation_company_name,
                            company_name: filter_company_name,
                            operation_username: filter_operation_username,
                            username: filter_username,
                            operation_email: filter_operation_email,
                            email: filter_email
                        },
                        success: function(data) {
                            //alert( "data::" + data )
                            $('#list-buyers-search-result').html(data);
                        }
                    });
                }

                $(document).ready(function() {
                });


            </script>

            <!-- MIDDLE PAGE CONTAINER-->
        </div>
        <div class="bg-body-bottom"> </div>
    </div>

</div>
<?php echo $this->load->view('supplier/footer') ?>
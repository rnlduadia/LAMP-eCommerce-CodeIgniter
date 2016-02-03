<!-- Lanz Editted -->
<?php echo $this->load->view('admin/header') ?>
<div class="global-cont">

	<div class='bg-body'>
		<div class="bg-body-top"> </div>
		<div class="bg-body-middle clearfix">
		<!-- MIDDLE PAGE CONTAINER-->

			<!-- LEFT SIDEBAR CONTAINER-->
			<div id="left-sidebar" class="clearfix fl">
				<?php echo $this->load->view('admin/buyer/buyer-sidebar') ?>
			</div>

			<!-- RIGHT CONTENT CONTAINER-->
			<div class='right-cont clearfix fr'>

                <div class='right-inner clearfix'>
                    <!-- First Row Container-->
                    <div class="heading-inner-right">
                        <p class='breadcrumbs fl'>Buyer Profile </p>
                    </div>
                    <div class='padded-cont'>

                        <div class='profile-cont fl'>
                            <div class="user-icon">
                                <?php if($buyer_profile->u_pic != ""){?>
                                    <img src="<?php echo base_url().$buyer_profile->u_pic?>" width=100%>
                                <?php }else{ ?>
                                    <img src="<?php echo base_url()?>images/avatar.png" width=100%>
                                <?php }?>
                            </div>

                        </div>

                        <div class='informative-format fl'>
                            <div>
                                <p><span>Full Name:</span> <?php echo $buyer_profile->u_fname.' '.$buyer_profile->u_lname; ?></p>
                            </div>
                            <div>
                                <p><span>Email:</span> <?php echo $buyer_profile->u_email; ?></p>
                            </div>
                            <div>
                                <p><span>Company:</span> <?php echo $buyer_profile->u_company; ?></p>
                            </div>
                            <div>
                                <p><span>FEID/Business Number/VAT Registration Number:</span> <?php echo $buyer_profile->u_permit; ?></p>
                            </div>
                            <div>
                                <p><span>Registration Date:</span> <?php echo is_numeric($buyer_profile->u_time) ? date("Y-m-d H:i:s",$buyer_profile->u_time) : $buyer_profile->u_time; ?></p>
                            </div>
                        </div>


                    </div>

                </div>

                <div class='right-inner right-inner-half clearfix fl' style='min-height:215px'>
                    <!-- First Row Container-->
                    <div class="heading-inner-right">
                        <p class='breadcrumbs fl'>Default Billing Information</p>
                    </div>

                    <div class='padded-cont'>
                        <div class='informative-format fl' >
                            <div>
                                <p><span>Country:</span><?php echo $buyer_profile->c_name; ?></p>
                            </div>
                            <div>
                                <p><span>Address 1:</span><?php echo $buyer_profile->ba_add1; ?></p>
                            </div>
                            <div>
                                <p><span>Address 2:</span> <?php echo $buyer_profile->ba_add2; ?></p>
                            </div>
                            <div>
                                <p><span>City:</span> <?php echo $buyer_profile->ba_city; ?></p>
                            </div>
                            <div>
                                <p><span>Province:</span> <?php echo $buyer_profile->ba_province; ?></p>
                            </div>
                            <div>
                                <p><span>Postal Code:</span> <?php echo $buyer_profile->ba_postal; ?></p>
                            </div>
                            <div>
                                <p><span>Phone Number:</span> <?php echo $buyer_profile->ba_phone_num; ?></p>
                            </div>
                        </div>
                    </div>

                </div>


                <div class='right-inner right-inner-half-fr clearfix fr' style='min-height:215px'>
                    <!-- First Row Container-->
                    <div class="heading-inner-right">
                        <p class='breadcrumbs fl'>Default Credit Card Information</p>
                    </div>

                    <div class='padded-cont'>
                        <div class='informative-format fl'>
                            <div>
                                <p><span>Credit Card Name</span><?php echo $buyer_profile->ccu_name; ?></p>
                            </div>
                            <div>
                                <p><span>Credit Card:</span> <?php echo $buyer_profile->cc_type; ?></p>
                            </div>
                            <div>
                                <p><span>Credit Card Number:</span> <?php
                                    if(isset($buyer_profile->ccu_number) and $buyer_profile->ccu_number!="") {
                                        echo '***********'.substr($buyer_profile->ccu_number, 11, 15);
                                    } else {
                                        echo "Not Available";
                                    }
                                    ?></p>
                            </div>
                            <div>
                                <p><span>Expiration Date:</span> <?php if(count($buyer_profile->ccu_exp_month) == 1){echo '0';}; echo $buyer_profile->ccu_exp_month.'/'.$buyer_profile->ccu_exp_year; ?></p>
                            </div>
                        </div>
                    </div>

                </div>
		<?php if (!empty($buyer_profile->umf_id)) : ?>
                <div class='right-inner right-inner-half clearfix fl'>
                    <!-- First Row Container-->
                    <div class="heading-inner-right">
                        <p class='breadcrumbs fl'>Additional Buyer Information </p>
                    </div>
                    <div class='padded-cont'>

                        <div class='informative-format fl'>
                            <div>
                                <p><span>Website address:</span> <?php echo $buyer_profile->website; ?></p>
                            </div>
                            <div>
                                <p><span>How did you find us?:</span> <?php echo $buyer_profile->how_you_find; ?></p>
                            </div>
                            <div>
                                <p><span>What's most important to you from your suppliers?:</span> <?php echo $buyer_profile->important; ?></p>
                            </div>
                            <div>
                                <p><span>Current average annual sales:</span> <?php echo $buyer_profile->avg_sales; ?></p>
                            </div>
                       </div>
                    </div>

                </div>
		<?php endif; ?>

            </div>
			</div>

		<!-- MIDDLE PAGE CONTAINER-->
		</div>
		<div class="bg-body-bottom"> </div>
	</div>

</div>

<?php echo $this->load->view('admin/footer') ?>
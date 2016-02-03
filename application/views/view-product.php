<?php
if ($this->session->userdata('is_login') == TRUE) {
    $user_type = $this->session->userdata('type'); //get user type;
    if ($user_type == 2) { //2 is Supplier
        echo $this->load->view('supplier/header');
    } elseif ($user_type == 3) { //3 is Buyer
        echo $this->load->view('buyer/header');
    } elseif ($user_type == 1) { //1 Admin
        echo $this->load->view('admin/header');
    }
} else
    echo $this->load->view('header');
?>

<script src="<?php echo base_url() ?>js/organictabs.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/jquery.flexslider.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/flexslider.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/style.css"/>
<link href="<?php echo base_url() ?>css/tipr.css" rel="stylesheet">
<script src="<?php echo base_url() ?>js/tipr.min.js"></script>
<script type="text/javascript">
    $(function() {

        $("#supplier-product-tab").organicTabs();

    });
    if ($('.flexslider').length)
        jQuery.noConflict();
    $(window).load(function() {
        if ($('.flexslider').length)
            $('.flexslider').flexslider({
                animation: "fade",
                slideshowSpeed: 8000,
                controlsContainer: ".img_preview_wrapper",
                directionNav: false,
                startAt: 0,
                slideshow: false,
                start: function(slider) {
                    $('.right-navi').click(function(event) {
                        event.preventDefault();
                        slider.flexAnimate(slider.getTarget("next"));
                    });
                    $('.left-navi').click(function(event) {
                        event.preventDefault();
                        slider.flexAnimate(slider.getTarget("prev"));
                    });
                }
            });
    });


</script>
<div id="message_supplier_popup_cover" style="display: none;"></div>
<div id="message_supplier_popup" class="message_supplier_popup" style="display: none; left: 540px;">
    <h2>Message to the Supplier</h2>
    <p></p>
    <form action="" method="post" name="frmLogin" id="frmLogin">
        <div class="inputHolder">
            <br/>
            <span>Your Name</span>
            <input type="text" name="message_supplier_name" id="message_supplier_name" placeholder="Enter Your Name" value="<?php if(isset($user))echo $user->u_fname.' '.$user->u_lname;?>">
            <span>Your Email</span>
            <input type="text" name="message_supplier_email" id="message_supplier_email" placeholder="Enter Your Email" value="<?php if(isset($user))echo $user->u_email;?>">
            <span>Your Phone</span>
            <input type="text" name="message_supplier_phone" id="message_supplier_phone" placeholder="Enter Your Phone" value="<?php if(isset($user))echo $user->ba_phone_num;?>">
            <span>Product Link</span>
            <input type="text" name="message_supplier_link" id="message_supplier_link" placeholder="Product link" value="<?= current_url(); ?>">
            <span>Message</span>
            <textarea rows="5" name="message_supplier_body" id="message_supplier_body" placeholder="">Message to the supplier...</textarea>

            <input type="hidden" id="message_supplier_icid" name="message_supplier_icid" value="">
            <input type="hidden" id="csrf" name="<?php echo $this->security->get_csrf_token_name()?>" value="<?php echo $this->security->get_csrf_hash()?>">
        </div>
        <a href="#" type="button" id="message_supplier_submit" class="message_supplier_submit">send</a>
    </form>

</div>
<div class="global-cont">
    <!-- LEFT SIDEBAR CONTAINER-->
    <div  class="nav-bar floatL">

<?php
if ($this->session->userdata('is_login') == TRUE) {
    $user_type = $this->session->userdata('type'); //get user type;
    if ($user_type == 2) { //2 is Supplier
        echo $this->load->view('supplier/sidebar');
    } elseif ($user_type == 3) { //3 is Buyer
        echo $this->load->view('sidebar');
    } elseif ($user_type == 1) { //1 Admin
        echo $this->load->view('admin/inventory/sidebar');
    }
} else
    echo $this->load->view('sidebar');
?>

    </div>

    <!-- RIGHT CONTENT CONTAINER-->
    <div class='floatR prodwrap'>
        <div class='right-inner clearfix'>
            <div class="productNavigation mynav">
                <p><?php echo $this->categories->create_breadcrumb($product->cat_id, $product->c_level, true, true); ?> </p>
            </div>
        </div>
        <div class="prodinfoblock">
            <div class="prodtitle"><?php echo $product->tr_title ?></div>
            <div class="prodininfo">
                <div class="prodimg">
<?php $img = reset($image_list);
if (count($image_list) == 0 || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace((strpos(base_url(),'https://')>-1 ? 'https://' : 'http://' ). $_SERVER['HTTP_HOST'] . '/', '', base_url() . $img->ii_link))) {
    ?>
                        <img src="<?php echo base_url() ?>images/default-preview.jpg" class="bigimg" />
<?php } else {
    $img = reset($image_list);
    ?>
                        <div class="flexslider gallery-item">
                            <ul class="slides">
    <?php
    foreach ($image_list as $img) {
        ?>
                                    <li><a onclick='return false' href="<?php echo base_url() . $img->ii_link ?>">
                                            <div class="img-wrap"><img src="<?php echo base_url() . $img->ii_link ?>" id="slide0" class="bigimg"/></div>
                                        </a></li>
                            <?php
                        }
                        ?>
                            </ul>
                        </div>
                                <?php
                                echo "<div class='img_preview_wrapper'>";
                                $img_num = 0;
                                foreach ($image_list as $img) {
                                    $img_num++;
                                    if ($img_num % 5 == 1)
                                        echo "<div class='preview_row_margin'></div>";
                                    ?>
                            <a href='#' class='img_preview_small'>
                                <img data-num='<?= $img_num ?>' src="<?php echo base_url() . $img->ii_link ?>">
                            </a>
                            <?php
                        }
                        if (sizeof($image_list) < 5)
                            for ($i = 0; $i < (5 - sizeof($image_list)); $i++) {
                                echo "<div class='img_preview_small'></div>";
                            }
                        echo "</div>";
                        ?>
                    <?php } ?>
                </div>
                    <?php if ((!isset($user_type) || $user_type != 2) && ($product->status == 'active') && ($product->u_admin_approve != 2)) { ?>
                    <div class="addtocart">
                        <?php if ($has_child) {
                            if ($product->u_module == 1) {
                                ?>
                                <div class="quantt">
                                    Quantity: <input type='number' id='quantity-cart' class='' value='1' min="1"/>
                                </div>
                                <div class="add2cartbtn">
                                    <button style="padding: 0px;" class="greenbutton" onclick='return message_supplier(<?php echo $product->ic_id ?>)' >Message Supplier</button>
                                </div> 

                            <?php } else { ?>
                                <div class="quantt">
                                    Quantity: <input type='number' id='quantity-cart' class='' value='1' min="1"/>
                                </div>
                                <div class="add2cartbtn">
                                    <button class="greenbutton" onclick='return add_to_cart(<?php echo $product->ic_id ?>)' >Add to Cart</button>
                                </div> 
                            <?php }
                        } else { ?>
                            <div class="add2cartbtn">
                                <button class="greenbutton"  style="background-color:grey;" >Out of Stock</button>
                            </div>
    <?php } ?>
                    </div>
                    <?php } ?>
                <div class="producttextinfo">
                    <div class="prodprice">
<?php if ($this->session->userdata('is_login') == TRUE) {
    if ($user->u_admin_approve == 1) {
        ?>
                        <?php
                        if ($has_child) {
                            if ($product->status == 'active') {
                                if (isset($suppliers) && count($suppliers) > 0) {
                                    $lowest = 0;
                                    foreach ($suppliers as $supplier) {
                                        if ($supplier->ic_price < $lowest || $lowest == 0) {
                                            $lowest = $supplier->ic_price;
                                        }
                                    }
                                    $price = number_format($lowest, 2, '.', ' ');
                                } else {
                                    $price = number_format($product->ic_price, 2, '.', ' ');
                                }
                                $price = '$' . $price;
                            } else {
                                $price = 'Out of stock';
                            }
                        } else {
                            $price = 'N/A';
                        }
                        ?>
                                <?php echo $price ?>
                            <?php } elseif ($user->u_admin_approve == 0) { ?>
                                <span>Price is pending<br/> admin approval</span>
                            <?php }
                        } else {
                            ?>
                            <span>Log in to see price</span>
                        <?php } ?>
                    </div>
                    <div class="prodparams">
                        <div class="pitem">
                            <div class="plabel">EPID:</div>
                            <div class="pvalue"><?php echo $product->i_id ?></div>
                        </div>
                        <div class="pitem">
                            <div class="plabel">MSRP:</div>
                            <div class="pvalue"><?php echo (($has_child) && ($product->ic_retail_price != 0)) ? '$' . number_format($product->ic_retail_price, 2, '.', ' ') : 'N/A' ?></div>
                        </div>
                        
                        
                        <div class="pitem">
                            <div class="plabel">Stock Price:</div>
                            <div class="pvalue">$<?php echo $product->ic_stockPriceTier1  ?></div>
                        </div>
                        <div class="pitem">
                            <div class="plabel">Stock Min QTY:</div>
                            <div class="pvalue"><?php echo $product->ic_minStockQTYTier1 ?></div>
                        </div>
                        
                        
                        <div class="pitem">
                            <div class="plabel">Brand:</div>
                            <div class="pvalue"><a href="/inventory/search/brand/<?php echo $product->b_name ?>"><?php echo $product->b_name ?></a></div>
                        </div>
                        <div class="pitem">
                            <div class="plabel">Manufacturer:</div>
                            <div class="pvalue"><a href="/inventory/search/mf/<?php echo $product->m_name ?>"><?php echo $product->m_name ?></a></div>
                        </div>
                        <div class="pitem">
                            <div class="plabel">MAP:</div>
                            <div class="pvalue"><?php echo $has_child ? $product->ic_map : 'N/A' ?></div>
                        </div>
                        <div class="pitem">
                            <div class="plabel">EST margin:</div>
                            <div class="pvalue">100%</div>
                        </div>
<?php if ($product->status == 'active') { ?>

                            <div class="pitem hidden">
                                <div class="plabel">Qty in Stock:</div>
                                <div class="pvalue"><?php echo $has_child ? $product->ic_quan : 'N/A' ?></div>
                            </div>
                            <div class="pitem">
                                <div class="plabel">Available Unit(s):</div>
                                <div class="pvalue"><?php echo $has_child ? $product->remaining_quantity : 'N/A' ?></div>
                            </div>
                            <div class="pitem">
                                <div class="plabel">Condition:</div>
                                <div class="pvalue">New</div>
                            </div>
    <?php if ($this->session->userdata('is_login') == TRUE) { ?>
                                <div class="pitem">
                                    <div class="plabel">Supplier:</div>
                                    <div class="pvalue"><?php echo $product->u_company ? $product->u_company : 'No Supplier Yet' ?></div>
                                </div>
                                <!-- <div class="pitem">
                                    <div class="plabel">Last Modified:</div>
                                    <div class="pvalue"><?php // echo apputils::ShowFormattedDateTime( $product->i_time, 'Common' ) ?></div>
                                </div> -->
    <?php } ?>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="prodinfoblock prodininfo">

            <div id="supplier-product-tab">

                <ul class="nav">
                    <li class="nav-one">
                        <a href="#featured" class="current">

                            <div class="head-tab fl">
                                <div class="tab-center fl">
                                    <p class="fl">Description</p>
                                </div>
                            </div>

                        </a>
                    </li>
<?php if ($product->status == 'active') { ?>
                        <li class="nav-two">
                            <a href="#basic">
                                <div class="head-tab fl">
                                    <div class="tab-center fl">
                                        <p class="fl">Inventory and Promotion</p>
                                    </div>
                                </div>
                            </a>
                        </li>
<?php } ?>
                </ul>

                <div class="list-wrap">

                    <ul id="featured">
                        <li>
                            <div class="prodininfo">
<?php echo html_entity_decode($product->tr_short_desc ? $product->tr_short_desc : ($product->tr_desc ? $product->tr_desc : '')); ?>
                                <br/>
                                <table class='gtable'>
                                    <tr>
                                        <td><b>Manufacture part No.:</b></td>
                                        <td><?php echo $product->manuf_num ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>GTIN (UPC/EAN):</b></td>
                                        <td><?php echo $product->upc_ean; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Shipping Weight:</b></td>
                                        <td><?php echo $product->weight . $product->weightScale ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Shipping Size:</b></td>
                                        <td>
<?php
echo $product->d_height . $product->d_scale . ' H x ' .
 $product->d_width . $product->d_scale . ' W x ' .
 $product->d_dept . $product->d_scale . ' D'
?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Lead Time:</b></td>
                                        <td><?php echo $product->ic_leadtime ?></td>
                                    </tr>
                                    
                                    <?php if($product->material!=''){ ?>
                                    <tr>
                                        <td><b>Material:</b></td>
                                        <td><?php echo $product->material ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if($product->color!=''){ ?>
                                    <tr>
                                        <td><b>Color:</b></td>
                                        <td><?php echo $product->color ?></td>
                                    </tr>
                                    <?php }?>
                                    <?php if($product->team!=''){ ?>
                                    <tr>
                                        <td><b>Team:</b></td>
                                        <td><?php echo $product->team ?></td>
                                    </tr>
                                    <?php }?>
                                </table>
                            </div>
                        </li>
                    </ul>

                    <ul id="basic" class="hide1" style="display:none">
                        <li>
                            <div class='status-selection-cont clearfix'>

                                <!--<div class='status-selection' style="width:60px;">
                                        <input type="radio" class="radio-type-sel" id="type-new">
                                        <label for="type-new">New</label>
                                </div>
                                <div class='status-selection' style="width:105px;">
                                        <input type="radio" class="radio-type-sel" id="type-refurb">
                                        <label for="type-refurb">Refurbished</label>
                                </div>

                                <div class='status-selection'>
                                        <input type="radio" class="radio-type-sel" id="type-used">
                                        <label for="type-used">Used</label>
                                </div>
                                -->
                                <div class='status-result' style="position: absolute;margin: -33px 0px 0px 578px;z-index: 100;">
                                    <p>Showing <span id='suppliers_num'><?= sizeof($suppliers) ?></span> out of <?= sizeof($suppliers) ?> offers</p>
                                </div>

                            </div>

                            <div class='clear'></div>
                            <div class='list-supplier-cont-prod'>
                                <table class="gtable noodd">
                                    <tr>
                                        <th width=250>Supplier</th>
                                        <th>Min Order</th>
                                        <th>Condition</th>
                                        <th>Onhand</th>
                                        <?php if ($this->session->userdata('is_login') == TRUE) { ?>
                                            <th>Price</th>
                                        <?php } ?>
                                        <th>Retail Price</th>
                                        <th>Ship Price</th>
                                        <th>Ship From</th>
                                        <th>Promotion</th>
                                        <th width=30>Add</th>
                                    </tr>
                                    <?php
                                    $sup_num = 0;
                                    if (isset($suppliers))
                                        foreach ($suppliers as $sup) {
                                            $sup_num++;
                                            /* Get average value of all feedbacks for this supplier */
                                            $general_feedback = $this->suppliers->general_feedback($sup->u_id);
                                            if ($general_feedback != false)
                                                $general_feedback = $general_feedback->avg_rate;
                                            else
                                                $general_feedback = 0;

                                            /* Get number of feedbacks and a feedback with maximum rate for this supplier */
                                            $feedback_detail = $this->suppliers->feedback_detail($sup->u_id);
                                            $fb_number = count($feedback_detail); //number of feedbacks
                                            $fb_max = array();
                                            foreach ($feedback_detail as $key => $fb) {
                                                $fb_max[$key] = $fb->bsd_buyer_rate;
                                            }
                                            $fb_max = array_keys($fb_max, max($fb_max)); //returns array of feedback keys with max rate
                                            $fb_max = $fb_max[array_rand($fb_max)]; //random element value
                                            $fb_max = $feedback_detail[$fb_max];
                                            //$fb_max_rate = $fb_max->bsd_buyer_rate;
                                            $fb_max_date = $fb_max->bsd_feedback_date;
                                            //$fb_max_date = $fb_max_date ? date('d/m/Y',$fb_max_date) : null;
                                            //echo '<pre>';print_r($fb_max_date);echo '</pre>';
                                            $fb_max_text = $fb_max->bsd_buyer_feedback;
                                            $fb_max_user = $fb_max->u_username;

                                            $remaining_quantity = $this->suppliers->get_child_remaining_quan($sup->ic_id, $sup->ic_quan);
                                            if ($remaining_quantity > 0) {
                                                ?>
                                                <tr id='type-new-<?= $sup_num ?>'>
                                                    <td>
                                                        <p class='fl'>
                                                            <a onclick='return show_sup_status(<?php echo $sup->ic_id ?>)' href="#" class="black"><?php echo $sup->u_company ?></a>
                                                            <!-- Supplier status popup -->
                                                        <div class='supplier-status-cont float-cont' id='supplierstat<?php echo $sup->ic_id ?>'>
                                                            <div class='inner-sup-stat'>

                                                                <div class='heading-violet-full'>
                                                                    <p class='fl'><?php echo $sup->u_company ?></p>
                                                                </div>

                                                                <div class='fl inner-left-sup-stat'>
                                                                    <div class='fl'>
                                                                        <p class='fl'>Feedback rating:</p>
                                                                        <div id="sup_ic_rate<?php echo $sup->u_id ?>" class="fl sup_ic_rate-cont"></div>
                                                                        <script type="text/javascript">
                                                                            $(document).ready(function() {
                                                                                $('#sup_ic_rate<?php echo $sup->u_id ?>').raty({
                                                                                    readOnly: true,
                                                                                    score: <?php echo $general_feedback ?>,
                                                                                    width: 150,
                                                                                    path: "<?php echo base_url() . 'images/' ?>"
                                                                                });
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                    <div class='clear'></div>
                                                                    <div>
                                                                        <p>Avarage lead time: <span><?php echo $this->suppliers->average_lead_time($sup->u_id); ?> business Days</span> </p>
                                                                    </div>
                                                                    <div class='clear'></div>
                                                                    <div>
                                                                        <p>Returns: <span>None</span></p>
                                                                    </div>
                                                                    <div class='clear'></div>
                                                                    <div>
                                                                        <p>Line in Hand: <span>100%</span></p>
                                                                    </div>
                                                                    <div class='clear'></div>
                                                                    <div>
                                                                        <p>Country:<span></span></p>
                                                                    </div>
                                                                    <div class='clear'></div>
                                                                    <div>
                                                                        <p>Launch Date:<span></span></p>
                                                                    </div>
                                                                </div>

                                                                <div class='fr inner-right-sup-stat'>
                                                                    <p class='feedback-top'>(Feedbacks: <span><?= $fb_number ?></span>)</p>
                                                                    <p class='date-feedback'>
                                                                        <?= $fb_max_date ?>
                                                                    </p>
                                                                    <p style="word-wrap: break-word;">
                                                                        <?= $fb_max_text ?>
                                                                    </p>
                                                                    <p class='bottom-feedback-auth'>
                                                                        by <a href="#"><?= $fb_max_user ?></a>
                                                                    </p>
                                                                </div>

                                                            </div>
                                                            <div class='clear'></div>
                                                            <div class='bottom-arrow-pop'></div>
                                                        </div>
                                                        <!-- /Supplier status popup-->
                                                        </p>
                                                <nobr>
                                                    <div class='star-cont fl'>
                                                        <p class='fl percent'><?= ($sup_num == 1 ? '100%' : '56%') ?></p><button class='star-rate fr'></button>
                                                    </div>
                                                    <div class='action-icon-cont fl' style="margin-top: 0px;">
                                                        <!-- Return policy popup  -->
                                                        <div class='supplier-status-cont float-cont' id='supplierreturn<?php echo $sup->ic_id ?>' style="margin-left:-19px;margin-top: -150px;">
                                                            <div class='inner-sup-stat' style="width: 225px; height: 140px;">

                                                                <div class='heading-violet-full'>
                                                                    <p class='fl'><?php //echo $sup->u_company  ?>Return Policy</p>
                                                                </div>
                                                                <div class="textblock">
                                                                    <?echo $sup->u_return;?>
                                                                </div>

                                                            </div>
                                                            <div class='clear'></div>
                                                            <div class='bottom-arrow-pop'></div>
                                                        </div>
                                                        <!-- / Return policy popup  -->
                                                        <a class='overview-icon fl' onclick='return show_sup_return(<?php echo $sup->ic_id ?>)' href="#"></a>
                                                        <!-- Restrictions popup  -->
                                                        <div class='supplier-status-cont float-cont' id='supplierrestrict<?php echo $sup->ic_id ?>' style="margin-left:8px;margin-top: -150px;">
                                                            <div class='inner-sup-stat' style="width: 225px; height: 140px;">

                                                                <div class='heading-violet-full'>
                                                                    <p class='fl'><?php // echo $sup->u_company  ?>Supplier Restrictions</p>
                                                                </div>
                                                                <div class="textblock">
                                                                    <?echo $sup->u_restriction;?>
                                                                </div>

                                                            </div>
                                                            <div class='clear'></div>
                                                            <div class='bottom-arrow-pop'></div>
                                                        </div>
                                                        <!-- / Restrictions popup  -->
                                                        <a class='restriction-icon fl' onclick='return show_sup_restrict(<?php echo $sup->ic_id ?>)' href="#"></a>
                                                        <!-- <a class='returnPolicy-icon fl' href="#"></a> -->
                                                    </div>
                                                </nobr>
                                                </td>
                                                <td><?php $min_order = (!empty($sup->ic_min_order)) ? $sup->ic_min_order : 1;
                                                                        echo $min_order; ?></td>
                                                <td>New</td>
                                                <td><?php echo $remaining_quantity ?></td>
                                                <?php if ($this->session->userdata('is_login') == TRUE) { ?>
                                                    <td><?php echo number_format($sup->ic_price, 2) ?></td>
                                                <?php } ?>
                                                <td><?php echo number_format($sup->ic_retail_price, 2) ?></td>
                                                <td><?php echo number_format($sup->ic_ship_cost, 2) ?></td>
                                                <td><?php echo $sup->c_code ?></td>
                                                <td style="text-align: center;">
                                                    <div class="tip" data-tip="<?php echo $sup->ic_prom_text ?>"><img src="/images/icon-note.png" style="width: 16px;" /></div>
                                                </td>
                                                <td><button onclick="return add_to_cart(<?php echo $sup->ic_id ?>)" class='add-quick-cart'></button></td>
                                                </tr>
                                            <?php }
                                        } ?>
                                </table>
                                <br/><p><b>Min Order</b>: <?php $min_order = (!empty($sup->ic_min_order)) ? $sup->ic_min_order : 1;
                                    echo $min_order; ?></p>
                            </div>
                        </li>
                    </ul>

                </div> <!-- END List Wrap -->

            </div>

        </div>
        <br/>
        <div class="prodinfoblock prodininfo">
            <div class="prodinfotitle">
                Feedback
            </div>
            <div class='inner-feedback-cont'>
                <ul class='arrow-bullet clearfix'>
                    <li>If you need help or have a question for <a class="blue" href="mailto:support@oceantailer.com?subject=I%20need%20help%20or%20I%20have%20a%20question&body=%0A%0A%0A<?= current_url(); ?>">Customer Service.</a></li>
                    <li>Did you find an error or have a <a class="blue" href="mailto:support@oceantailer.com?subject=I%20found%20an%20error%20or%20I%20have%20a%20suggestion&body=%0A%0A%0A<?= current_url(); ?>">suggestion</a> about the product?</li>
                    <li>Did you see the <a class="blue" href="mailto:support@oceantailer.com?subject=I%20found%20this%20product%20cheaper%20elsewhere&body=I%20found%20it%20at:%0AHere%20is%20the%20link:%0A%0A%0A<?= current_url(); ?>"><?php echo $product->tr_title ?></a> cheaper somewhere else?</li>
                </ul>
                <?php
                $hide_feedback_btn = true;
                if ($this->session->userdata('is_login') == TRUE) {
                    $user_type = $this->session->userdata('type'); //get user type;
                    if ($user_type == 1) { //1 is Admin
                        $hide_feedback_btn = false;
                    }
                }
                ?>
<?php if ($this->session->userdata('is_login') == TRUE) {
    $user_type = $this->session->userdata('type');
} ?>
                <?if(!$is_in_feed && $user_type == 3){?><input type='button' class='greenbutton addtofeed' prodid="<?= $product->i_id ?>" value='Add this product to feed' /><?}?>
                <div class="addedtofeed"<?if(!$is_in_feed){?> style="display:none;"<?}?>><img src="/images/check_mark_green.png" align="left"/>&nbsp;This product has been added to feed</div>
                <?
                //echo '<pre>';print_r($this->_ci_cached_vars['product']);echo '</pre>'; // product ID
                //echo '<pre>';print_r($this->session->userdata['id']);echo '</pre>'; // user ID
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.tip').tipr();
    });


    function show_sup_status(id)
    {
        $('#supplierstat' + id).fadeIn();
        return false;
    }

    function show_sup_return(id)
    {
        $('#supplierreturn' + id).fadeIn();
        return false;
    }

    function show_sup_restrict(id)
    {
        $('#supplierrestrict' + id).fadeIn();
        return false;
    }

    $(document).mouseup(function(e)
    {
        var container = $(".supplier-status-cont");

        if (container.has(e.target).length === 0)
        {
            container.hide();
        }
    });
    var quan = 1;
    $('.stepper-up').click(function() {
        quan = $('#quantity-cart').val();
        $('#quantity-cart').val(parseInt(quan) + 1);
        quan = $('#quantity-cart').val();
    });

    $('.stepper-down').click(function() {

        quan = $('#quantity-cart').val();
        if (parseInt(quan) != 1)
            $('#quantity-cart').val(parseInt(quan) - 1);
        quan = $('#quantity-cart').val();
    });

    function add_to_cart(icid)
    {
        var quan = parseInt($("#quantity-cart").val());
        $.post("<?php echo base_url() ?>cart/add", {icid: icid, quan: quan, '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>'}, function(result) {
//		alert(JSON.stringify(result));

            var crt = JSON.parse(result);
            if (crt.error) {
                alert(crt.error);
                return;
            }

            if (crt.total_item_add <= crt.rem_qty) {
                $('#num-total-item').html(crt.total_item);
                $(window.location).attr('href', '<?php echo base_url() ?>cart');//redirect to the user page
            }
        });
    }
    function message_supplier(icid)
    {
        $("#message_supplier_popup_cover").show();
        $("#message_supplier_popup").show();
        $("#message_supplier_name").focus();
        $("#message_supplier_icid").val(icid);
    }


    $(function() {
        
        
$("#message_supplier_submit").on("click", function(){
    var name    = $("#message_supplier_name").val();
    var email    = $("#message_supplier_email").val();
    var phone    = $("#message_supplier_phone").val();
    var link    = $("#message_supplier_link").val();
    var message    = $("#message_supplier_body").val();
    var icid    = $("#message_supplier_icid").val();
    var csrf  = $("#csrf").val();
    
    if(!name || !email || !phone || !link || !message){
        alert("You left required fields blank.");
    }
    else{
       		$.ajax({
                    type:"POST",
                    url:"<?php echo base_url();?>supplier/message_to_supplier/",
                data:{name:name,email:email,phone:phone,link:link,message:message,icid:icid, csrf:csrf}, 
                success: function(result){
		var  convert = JSON.parse(result);
	            if(convert.result == 1)
	            {
                       alert(convert.message);
                       document.getElementById("message_supplier_popup").style.display = "none";
                       document.getElementById("message_supplier_popup_cover").style.display = "none";
                    }
	            else
	            {
	                alert(convert.message);
	            }
		}
            });
    }
    });

        $("#message_supplier_popup_cover").on("click", function() {
            document.getElementById("message_supplier_popup").style.display = "none";
            document.getElementById("message_supplier_popup_cover").style.display = "none";
        });

        
        
        $("a.img_preview_small img").click(function() {
            var img_num = $(this).attr("data-num");
            var el = $("body").find(".flex-control-nav li:nth-child(" + img_num + ") a");
            el.trigger('click');
            return false;
        });

//        $("#supplier-product-tab").organicTabs();

        $(".addtofeed").on("click", function() {
            prod_id = $(this).attr('prodid');
            var wasvalue = $(".addtofeed").prop('value');

            $.ajax({
                url: '/datafeed/add/?product_id=' + prod_id,
                dataType: 'json',
                beforeSend: function() {
                    $(".addtofeed").prop('value', 'working...');
                },
                success: function(data) {
                    if (data.result == 'true') {
                        $(".addtofeed").fadeOut('slow', function() {
                            $(".addedtofeed").fadeIn('slow');
                        });
                    } else {
                        alert('some error occured');
                        $(".addtofeed").prop('value', wasvalue);
                    }
                },
                error: function() {
                    $(".addtofeed").prop('value', wasvalue);
                }
            });
        });
    });
    $(window).load(function() {
        $(".radio-type-sel").click(function() {
            if (!$(this).hasClass('radio-type-sel-active')) {
                $(this).addClass('radio-type-sel-active');
                //  show only selected type/s
                $("tr[id^='type-']").fadeOut(0);
                var quan = 0;
                $.each($(".radio-type-sel-active"), function(index, value) {
                    var id = $(this).attr("id");
                    $("tr[id^='" + id + "']").fadeIn(0);
                    quan = quan + $("tr[id^='" + id + "']").length;
                });
                $("#suppliers_num").text(quan + '');
            }
            else {
                var quan = 0;
                $(this).removeClass('radio-type-sel-active');
                //  show only selected
                //  or all if no type is selected
                if ($(".radio-type-sel-active").length) {
                    $("tr[id^='type-']").fadeOut(0);
                    $.each($(".radio-type-sel-active"), function(index, value) {
                        var id = $(this).attr("id");
                        $("tr[id^='" + id + "']").fadeIn(0);
                        quan = quan + $("tr[id^='" + id + "']").length;
                    });
                    $("#suppliers_num").text(quan);
                }
                else {
                    $("tr[id^='type-']").fadeIn(0);
                    $("#suppliers_num").text($("tr[id^='type-']").length);
                }
            }

        });




        $("#quantity-cart").keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and . (comma - 190)
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
                    // Allow: Ctrl+A
                            (e.keyCode == 65 && e.ctrlKey === true) ||
                            // Allow: home, end, left, right
                                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });


<?php if (count($image_list) != 0 && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('http://' . $_SERVER['HTTP_HOST'] . '/', '', base_url() . $img->ii_link))) { ?>
            $('.inner-img-prod-list div.flexslider div.flex-viewport ul.slides li a ').imgPreview({
                containerID: 'preview-slides',
                imgCSS: {
                    // Limit preview size:
                    height: 200
                },
                // When container is shown:
                onShow: function(link) {
                    $('<span>' + $(link).text() + '</span>').appendTo(this);
                },
                // When container hides:
                onHide: function(link) {
                    $('span', this).remove();
                }
            });
<?php } ?>
    });
</script>
<?php if ($user_type == 2): ?>
    <script tyle="text/javascript">
        $(function() {
            $('.productNavigation a').click(function() {
                if ($(this).html() == 'Home') {
                    return true;
                } else {
                    return false;
                }
            })
        });
    </script>
<?php endif ?>

<script src="<?php echo base_url() ?>js/imgpreview.full.jquery.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo base_url() ?>js/jquery.raty.min.js"></script>
<?php
if ($this->session->userdata('is_login') == TRUE) {
    $user_type = $this->session->userdata('type'); //get user type;
    if ($user_type == 2) { //1 is suplier
        echo $this->load->view('supplier/footer');
    } elseif ($user_type == 3) { //3 is Buyer
        echo $this->load->view('buyer/footer');
    } elseif ($user_type == 1) { //1 Admin
        echo $this->load->view('admin/footer');
    }
} else
    echo $this->load->view('footer');
?>

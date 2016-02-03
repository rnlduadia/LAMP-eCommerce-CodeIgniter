<!-- Lanz Editted - June 7, 2013 -->

<?php echo $this->load->view('supplier/header') ?>

<!-- LEFT SIDEBAR CONTAINER-->

<div class="nav-bar floatL">

    <?php echo $this->load->view('supplier/sidebar') ?>

</div>


<!-- RIGHT CONTENT CONTAINER-->

<div class='sliderLg floatR'>


    <div class='right-inner clearfix'>

        <!-- First Row Container-->

        <div class="topBrands searching-for">

            <div class="topBrandsHeader">

                <div class'floatl'="">Buyer's Feedbacks</div>

        </div>

    </div>

    <div class='padded-cont'>

        <div class='violet-table'>

            <table>

                <tr>

                    <td>Company</td>

                    <td>Rate</td>

                    <td>Feedback</td>

                    <td>Date</td>

                </tr>

                <?php foreach($feedback_detail as $feedback){?>

                    <tr>

                        <td><?php echo $feedback->u_company ?></td>

                        <td>

                            <div id="buyer_ic_rate<?php echo $feedback->u_id?>" class="fl sup_ic_rate-cont"></div>

                            <script type="text/javascript">

                                $(document).ready(function(){

                                    $('#buyer_ic_rate<?php echo $feedback->u_id?>').raty({

                                        readOnly : true,

                                        score    : <?php echo $feedback->bsd_buyer_rate ?>,

                                        width    : 150,

                                        path     :"<?php echo base_url().'images/'?>"

                                    });

                                });

                            </script>

                        </td>

                        <td><?php echo $feedback->bsd_buyer_feedback ?> </td>

                        <td><?php echo date('d/M/Y',strtotime($feedback->u_time)) ?></td>

                    </tr>

                <?php }?>

            </table>

        </div>

    </div>

</div>



</div>



<script type="text/javascript" charset="utf-8" src="<?php echo base_url()?>js/jquery.raty.min.js"></script>

<?php echo $this->load->view('supplier/footer') ?>
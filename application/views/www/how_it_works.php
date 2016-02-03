<?php echo $this->load->view('www/header',array($title))?>

<?php
if(preg_match("/firefox/i", $ua['name'])){
    $style = "
        <style>
        div.timeBoxes p{
            font-size:1.3vw !important;
        }
        div.firstTimeBox p{
            font-size:1.3vw !important;
        }
        </style>
    ";
}
if(isset($style)) echo $style;
?>
    <div id="content">
        <div id="otherBgHolder">
            <h2>How OceanTailer works</h2>
        </div>
        <div id="mainContentCenter">
            <div id="mainContentChild">
                <div class="howIntro">
                    <p><b>OceanTailer</b> acts as the sole buyer for all its suppliers
                        and acts as a sole seller for all its buyers. Because of
                        that, we are able to guarantee the cheapest price and the
                        best services from supplier whether a buyer will try to go
                        on their own for direct relationship.</p>
                </div>
            </div>
            <div id="howBottomHolder">
                <div class="howColumn" id="howColumnFirst">
                    <div class="firstTimeBox boxLeft">
                        <p>Buyers and sellers register to OceanTailer</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxLeft">
                        <p>Sellers set their terms, lead time and inventory levels
                            and why they are the best in the field.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxLeft">
                        <p>From the catalog, buyers order products with PayPal or Credit Card.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxLeft">
                        <p>Seller provides proof of shipment for the order.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxLeft">
                        <p>Seller is paid minus the agreed commission paid to OceanTailer
                            for the transaction.</p>
                    </div>
                </div>
                <div class="howColumn howColumnMiddle">
                    <img src="<?php echo base_url()?>images/www/howItWorksGrid.png">
                </div>
                <div class="howColumn" id="howColumnLast">
                    <div class="firstBoxFill">

                    </div>
                    <div class="timeBoxes boxRight">
                        <p>OceanTailer validates their entities to ensure all business
                            are legitimate.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxRight">
                        <p>OceanTailer publish the seller's products for the
                            relevant buyers.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxRight">
                        <p>OceanTailer passes on the order to the seller.</p>
                    </div>
                    <div class="boxFill">

                    </div>
                    <div class="timeBoxes boxRight">
                        <p>The buyer is charged</p>
                    </div>
                </div>
                 <div class="bgButtons">
                    <a href="buyer_register">find products</a>
                    <a href="seller_register">start selling</a>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>

<?php echo $this->load->view('www/footer')?>

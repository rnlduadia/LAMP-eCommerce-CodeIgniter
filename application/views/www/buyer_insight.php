<?php echo $this->load->view('www/header',array($title))?>

    <div id="content">
        <div id="otherBgHolder">
            <h2>Supplier's Insight</h2>
        </div>
        <div id="supplyInfoHolder">
            <table>
                <tr><td>
            <h2>Seeing what's available to order</h2>
            <p>You have the ability to search for items</p>
            <p>Read title, description and products specifications</p>
            <p>Review MAP/MSRP (if applicable)</p>
            <p>View product images</p>
            <p>Add specific items for your realtime data feeds.</p>

                    </td>
                 <td>
                <img src='<?php echo base_url()?>images/www/product_description.png' height='350' width='450' />

            </td>
                </tr><tr>
                     <td>
                <img src='<?php echo base_url()?>images/www/product_inventory.png' height='350' width='450' />

            </td>
                    <td>
            <h2>Review pricing and seller's offering</h2>
            <p>Compare pricing from various suppliers</p>
            <p>Review supplier's performance. If they are not here, you need to ask yourself why.</p>
            <p>Review supplier's promotions</p>
            <br>
            </td></tr><tr>
             <td>
            <h2>Submit & Handle Orders - All in one platform</h2>
            <p>See list of orders</p>
            <p>See Order #, Payment Method and Order Date</p>
            <p>See Billto Address</p>
            <p>See Shipto Address</p>
            <p>See line items ordered with main image (avoid mixup in shipments)</p>
            <p>Communicate any freight cost changes with the seller</p>
            <p>Receive proof of shipment from the seller (Carrier, Tracking, and Ship Date)</p>
            <p>Ability to request for returning the order in case of lost/damage/buyer's remorse</p>
            </td> <td>
                <img src='<?php echo base_url()?>images/www/review orders.png' height='350' width='450' />

            </td>

                </tr><tr>
                    <td>
                <img src='<?php echo base_url()?>images/www/buyer_profile.png' height='350' width='450' />

            </td>
                    <td>
            <h2>Profile Management</h2>
            <p>Manage your own profile</p>
            <p>Manage your company profile</p>
            <p>Set up roles and permissions</p>
            <p>Manage data feeds</p>

            </td></tr>
            </table>
        </div>
    </div>

<?php echo $this->load->view('www/footer')?>

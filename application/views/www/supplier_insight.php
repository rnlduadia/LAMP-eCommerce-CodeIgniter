<?php echo $this->load->view('www/header',array($title))?>

    <div id="content">
        <div id="otherBgHolder">
            <h2>Supplier's Insight</h2>
        </div>
        <div id="supplyInfoHolder">
            <table>
                <tr><td>
            <h2>Overview of Your Account</h2>
            <p>See your own statistics.</p>
            <p>Have the ability to receive feedback from customers about your products</p>
            <p>Set your return policy</p>
            <p>Set any restrictions about reselling your products to the end consumer</p>
            <p>Review statement (Current pay period and past)</p>
                    </td>
                 <td>
                <img src='<?php echo base_url()?>images/www/Overview.png' height='350' width='450' />

            </td>
                </tr><tr>
                     <td>
                <img src='<?php echo base_url()?>images/www/Product Page.png' height='350' width='450' />

            </td>
                    <td>
            <h2>Manage your Product Sheet Online</h2>
            <p>Categorize the products</p>
            <p>Set up the title/description</p>
            <p>Set up tier pricing</p>
            <p>Set up MAP/MSRP (if applicable)</p>
            <p>Set up multiple images for the products</p>
            <p>Control your inventory</p>
            <p>Manage it all via datafeeds or on the platform</p>
            <br>
            </td></tr><tr>
             <td>
            <h2>Receive & Handle Orders - All in one platform</h2>
            <p>See Order #, Payment Method and Order Date</p>
            <p>See Billto Address</p>
            <p>See Shipto Address</p>
            <p>See line items ordered with main image (avoid mixup in shipments)</p>
            <p>Communicate any freight cost changes with the buyer</p>
            <p>Provide proof of shipment to the buyer (Carrier, Tracking, and Ship Date)</p>
            <p>Refund the order in case of return/damage</p>
            </td> <td>
                <img src='<?php echo base_url()?>images/www/Order Detail.png' height='350' width='450' />

            </td>

                </tr><tr>
                    <td>
                <img src='<?php echo base_url()?>images/www/Profile.png' height='350' width='450' />

            </td>
                    <td>
            <h2>Profile Management</h2>
            <p>Manage your own profile</p>
            <p>Manage your company profile</p>
            <p>Set up roles and permissions</p>
            <p>Review Profile Statistics</p>

            </td></tr>
            </table>
        </div>
    </div>

<?php echo $this->load->view('www/footer')?>

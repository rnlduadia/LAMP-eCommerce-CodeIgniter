<?php echo $this->load->view('www/header',array($title))?>

    <div id="content">
        <div id="otherBgHolder">
            <h2>CONTACT US</h2>
            <p>We'd love to hear from you. Interested in working together? Fill out the form below
                with some info about your project and we will get back to you as soon as we can. Please
                allow a couple of days for us to respond.</p>
        </div>
        <div id="contactHolder">
            <div>
                <div class="contactColumn">
                    <input type="text"  name="contactName" id="contactName" placeholder="Name">
                    <input type="text"  name="contactEmail" id="contactEmail" placeholder="Email">
                    <input type="text"  name="contactPhone" id="contactPhone" placeholder="Phone">
                </div>
                <div class="contactColumn">
                    <textarea id="contactMessage" placeholder="Put your message here"></textarea>
                </div>
            </div>
            <div class="clear"></div>
            <button type="button" id="sendMessage" class="contactSubmit">Send</button>
            <div class="clear"></div>
            <div id="popupConfirm" style="position:fixed;">
                <p id="contactMessage"></p>
            </div>
        </div>
    </div>

<?php echo $this->load->view('www/footer')?>

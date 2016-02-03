<?php echo $this->load->view('www/header',array($title))?>


<form action="#" target="_TOP" method="post">
    <div id="registerMain">
        <h2 id="registerIntro">Buyer's Registration</h2>
        <font size="4px"<p>If you are a brick & mortar retailer, online retailer or a business representative, you have arrived at the right place.</p></font>
        <div class="registerBar">
            <p>Basic Information</p>
        </div>
        <div>
              <div class="firstRegisterGroup">
                <input type="text" name="firstName" id="firstName" placeholder="First name">
                <input type="text" name="lastName" id="lastName" placeholder="Last name">
                <input type="text" name="userName" id="userName" placeholder="User name">
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div class="firstRegisterGroup">
                <input type="text" name="company" id="company" placeholder="Company name">
                <input type="text" name="permit" id="permit" placeholder="Company's License Number">
                <input type="password" name="newPassword" id="newPassword" placeholder="Password">
                <input type="Password" name="confirmedPassword"  id="confirmedPassword" placeholder="Confirm password">
            </div>
        </div>
        <div style="clear:both;"></div>
        <!--<div class="registerBar">
            <p>Credit Card Information - The card will be used only when you purchase</p>
        </div>
        <div style="height:100px;">
            <select class="registerCredit" placeholder="Credit Card Type" id="cardType" name="cardType">
                <option value="0">Credit card type</option>
                <option value="3">American Express</option>
                <option value="4">Discover</option>
                <option value="2">Master</option>
                <option value="1">Visa</option>
            </select>
            <input type="text" class="registerCredit" placeholder="Cardholder's name" id="cardholderName" name="cardholderName">
            <input type="text" class="registerCredit" placeholder="Credit Card Number" id="cardNumber" name="cardNumber">
            <input type="text" class="registerCredit" placeholder="CVV" id="cardCVV" name="cardCVV">
            <select name="creditExpire" class="registerCredit" placeholder="Expiration month" id="ccExpMonth">
                <option value="0">Expiration Date</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
            <input type="text" class="registerCredit" placeholder="Year" id="ccExpYear" name="ccExpYear">
        </div>
        <div style="clear:both;"></div>-->
        <div class="registerBar">
            <p>Billing Address</p>
        </div>
        <div>
            <div class="registerLocationLeft">
                <select name="country" id="country">
                    <option value="236">USA</option>
                </select>
				<input type="text" name="state-textbox" id="state-textbox" placeholder="Choose Province" style="display:none;">
                <input type="text" name="city" id="city" placeholder="City/Town">
                <select name="state" id="state">
                           <option value="0">Choose State</option>
<option value ="AL">Alabama</option>
<option value ="AK">Alaska</option>
<option value ="AZ">Arizona</option>
<option value ="AR">Arkansas</option>
<option value ="CA">California</option>
<option value ="CO">Colorado</option>
<option value ="CT">Connecticut</option>
<option value ="DE">Delaware</option>
<option value ="FL">Florida</option>
<option value ="GA">Georgia</option>
<option value ="HI">Hawaii</option>
<option value ="ID">Idaho</option>
<option value ="IL">Illinois</option>
<option value ="IN">Indiana</option>
<option value ="IA">Iowa</option>
<option value ="KS">Kansas</option>
<option value ="KY">Kentucky</option>
<option value ="LA">Louisiana</option>
<option value ="ME">Maine</option>
<option value ="MD">Maryland</option>
<option value ="MA">Massachusetts</option>
<option value ="MI">Michigan</option>
<option value ="MN">Minnesota</option>
<option value ="MS">Mississippi</option>
<option value ="MO">Missouri</option>
<option value ="MT">Montana</option>
<option value ="NE">Nebraska</option>
<option value ="NV">Nevada</option>
<option value ="NH">New Hampshire</option>
<option value ="NJ">New Jersey</option>
<option value ="NM">New Mexico</option>
<option value ="NY">New York</option>
<option value ="NC">North Carolina</option>
<option value ="ND">North Dakota</option>
<option value ="OH">Ohio</option>
<option value ="OK">Oklahoma</option>
<option value ="OR">Oregon</option>
<option value ="PA">Pennsylvania</option>
<option value ="RI">Rhode Island</option>
<option value ="SC">South Carolina</option>
<option value ="SD">South Dakota</option>
<option value ="TN">Tennessee</option>
<option value ="TX">Texas</option>
<option value ="UT">Utah</option>
<option value ="VT">Vermont</option>
<option value ="VA">Virginia</option>
<option value ="WA">Washington</option>
<option value ="WV">West Virginia</option>
<option value ="WI">Wisconsin</option>
<option value ="WY">Wyoming</option>

                </select>
            </div>
            <div class="registerLocationRight">
                <input type="text" name="address1" id="address1" placeholder="Address 1">
                <input type="text" name="address2" id="address2" placeholder="Address 2">
                <div id="registerBottomInputHolder">
                    <input type="text" name="zip" id="zip" placeholder="Zip code">
                    <input type="text" name="phone" id="phone" placeholder="Phone number">
                    <input type="text" name="phoneExt" id="phoneExt" placeholder="Phone Extension">
                </div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div class="registerBar">
            <p>Tell us more about you and your expectations:</p>
        </div>
        <div>
        	<div class="lastRegisterGroup">
                <input type="text" name="website" id="website" placeholder="Website address">
                <input type="text" name="how_you_find" id="how_you_find" placeholder="How did you find us?">
           </div>
            <div class="lastRegisterGroup">
                <input type="text" name="important" id="important" placeholder="What's most important to you from your suppliers?">
                <input type="text" name="avg_sales" id="avg_sales" placeholder="Current average annual sales">
            </div>

        </div>
        <div id="registerFooter">
            <p class="reqisterRequired">All fields of '<span style='color:red;'>Basic Information</span>' & '<span style='color:red;'>Billing Address</span>' sections are required!</p>
            <div id="submitHolder">
                <div id="termsHolder">
                    <p>I agree to the <a href="terms_of_use.php" target='_blank'>Terms of Use</a>
                    <input type="checkbox" id="termsConfirm" name="termsConfirm"></p>
                </div>
                 <input type='button' id="submit-buyer" name="submit-buyer" value='SUBMIT' class='normal-button' />

            </div>

        </div>
           <div class='validate-result' style>

		</div>
    </div>


</form>

<?php echo $this->load->view('www/footer')?>


<script type="text/javascript">

	var is_state = true;

	$('#state-textbox').hide();

	$(function(){
		 $.post("http://" + defaultPageSettings.site + "/country/load",{type:'listing'},function(result){
			if(result != 0) {

				$('#country').html(result);
				var sel = $('#country').val()-1;
				$('#country').prop('selectedIndex', sel).change();
			}

		 });
	});

	$('#country').change(function(){
		var country_sel = this.value;
		$.post("http://" + defaultPageSettings.site + "/country/load",{id:country_sel,type:'dropdown'},function(result){

			if(result != 0)
			{
				$('#state').html(result);
				$('#state').fadeIn();
				$('#state-textbox').hide();
				is_state = true;
			}
			else
			{
				is_state = false;
				$('#state-textbox').fadeIn();
				$('#state').hide();
			}
		});
	});

	$('#submit-buyer').click(function(){

        var firstname = $('#firstName').val();
		var lastname = $('#lastName').val();

		var uname = $('#userName').val();
		var email = $('#email').val();
		var company = $('#company').val();
		var permit = $('#permit').val();

		var pass = $('#newPassword').val();
		var conpass = $('#confirmedPassword').val();

		var cctype =  $('#cardType').val();

                if (cctype==0)
                {
                     alert("Please select credit card type")
                     return;
                }

                var ccuname =  $('#cardholderName').val();
		var ccunum = $('#cardNumber').val();
		var ccuccv = $('#cardCVV').val();
		var exp_month = $('#ccExpMonth').val();
		var exp_year = $('#ccExpYear').val();

		var bnk_country ="";// $('#bnk_country').val();
		var bk_owner ="";// $('#bk_owner').val();
		var bk_name = "";//$('#bk_name').val();
		var bk_name_add ="";// $('#bk_name_add').val();
		var bk_acc ="";// $('#bk_acc').val();
		var bnk_code ="";// $('#bnk_code').val();


		var country = $('#country').val();
		var add1 = $('#address1').val();
		var add2 = $('#address2').val();
		var city = $('#city').val();

		var website = $('#website').val();
		var how_you_find = $('#how_you_find').val();
		var important = $('#important').val();
		var avg_sales = $('#avg_sales').val();

		var prov = '';
		if(is_state)
			prov = $('#state').val();
		else
			prov = $('#state-textbox').val();

                if (prov==0)
                {
                   alert("Please select state");
                   return;

                }

		var postal = $('#zip').val();
		var phone_num = $('#phone').val(function(i, v)
                {
                     var replacedata="";
                       for (var i = 0; i < v.length; i++)
                            {
                                var c = v.charAt(i).replace('-','');
                                replacedata += c;
                            }
                         return replacedata;
                    }).val();
		var phone_ext = $('#phoneExt').val();

		var is_checked = $('#termsConfirm').is(":checked");

		if(is_checked)
		{
                    $.post("http://" + defaultPageSettings.site + "/buyer/add"
                ,{firstname:firstname,lastname:lastname,uname:uname,email:email,company:company,permit:permit,pass:pass,conpass:conpass,
			cctype:cctype,ccuname:ccuname,ccunum:ccunum,ccuccv:ccuccv,exp_month:exp_month,exp_year:exp_year,
			bnk_country:bnk_country,bk_owner:bk_owner,bk_name:bk_name,bk_name_add:bk_name_add,bk_acc:bk_acc,bnk_code:bnk_code,
			country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,
			website:website,how_you_find:how_you_find,important:important,avg_sales:avg_sales,
			action:'register'},function(result){

				var  convert = JSON.parse(result);

                                if (convert.message.indexOf("success-cont")>-1)
                                {
                                     $(location).attr('href','http://www.oceantailer.com/completed_registration.php')
                                     return;
                                }



				$('.validate-result').hide();
                                $('.validate-result').html(convert.message);
                                $('.validate-result').offsetHeight;
                                $('.validate-result').show();


			});
                        }
                        else
                        {
                            alert("Please agree to the use of terms prior to your registration")
                        }


	});
</script>
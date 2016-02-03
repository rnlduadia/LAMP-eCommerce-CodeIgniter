<?php echo $this->load->view('www/header',array($title))?>


<form action="#" target="_TOP" method="post">
    <div id="registerMain" style="height: 1100px">
        <h2 id="registerIntro">Seller's Registration</h2>
        <font size="4px"><p>If you wish to sell your products to retailers for reselling purposes or for businesses representative not for reselling purposes, you came to the right place.</p></font>
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
                <input type="text" name="permit" id="permit" placeholder="FEID or State License Number">
                <input type="password" name="newPassword" id="newPassword" placeholder="Password">
                <input type="Password" name="confirmedPassword"  id="confirmedPassword" placeholder="Confirm password">
            </div>
        </div>
         <div>
            <div class="firstRegisterGroup" style="height: 120px;">
                <input type="radio" name="u_module" id="u_module" value="1" style="width: 20px;">I wish to advertise my products only through OceanTailer.<br/>
                <input type="radio" name="u_module" id="u_module" value="2" style="width: 20px;">I wish to advertise and receive orders through OceanTailer.
            </div>
            <div class="firstRegisterGroup" style="height: 120px;"></div>
            </div>
        <div style="clear:both;"></div>
        <div class="registerBar">
            <p>Billing Address</p>
        </div>
        <div>
            <div class="registerLocationLeft">
                <select name="country" id="country">
                    <option value="14">Australia</option>
                    <option value="40">Canada</option>
                    <option value="46">China</option>
                    <option value="102">India</option>
                    <option value="111">Japan</option>
                    <option value="157">New Zealand</option>
                    <option value="218">Taiwan</option>
                    <option value="235">United Kingdom</option>
                    <option selected value="236">USA</option>
                </select>
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
                <input type="text" name="avg_sales" id="avg_sales" placeholder="Current average annual sales">
            </div>

        </div>
        <div id="registerFooter">
            <p class="reqisterRequired">All fields are required! </p>
            <div id="submitHolder">
                <div id="termsHolder">
                    <p style="width: auto; text-align: right">I agree to <a href="terms_of_use.php" target='_blank'>Terms of Use</a> <input type="checkbox" name="termsConfirm" id="termsConfirm"></p>
                </div>
                <input type='button' id="submit-supplier" name="submit-supplier" value='SUBMIT' class='normal-button' />
                <div class='validate-result'>

		</div>
            </div>
        </div>
    </div>
</form>

<?php echo $this->load->view('www/footer')?>
<script type="text/javascript">

	var is_state = true;
        $('#country').change(function(){
		var country_sel = this.value;
                
              //  if( country_sel == 236 ){
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
           /* }else{
                $('#state-textbox').fadeIn();
		$('#state').hide();
            }*/
	});

	//$('#state-textbox').hide();

	$('#submit-supplier').click(function(){
		var firstname = $('#firstName').val();
		var lastname = $('#lastName').val();

		var uname = $('#userName').val();
		var email = $('#email').val();
		var company = $('#company').val();
		var permit = $('#permit').val();

		var pass = $('#newPassword').val();
		var conpass = $('#confirmedPassword').val();

		var cctype = "";// $('#cctype').val();
		var ccuname = "";// $('#ccuname').val();
		var ccunum ="";//  $('#ccunum').val();
		var ccuccv ="";// $('#ccuccv').val();
		var exp_month ="";// $('#exp_month').val();
		var exp_year ="";// $('#exp_year').val();

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
		var avg_sales = $('#avg_sales').val();
                
                var u_module = $('#u_module').val();


		var prov = '';
		if(is_state)
			prov = $('#state').val();
		else
			prov = $('#province').val();

		var postal = $('#zip').val();
		var phone_num = $('#phone').val();
		var phone_ext = $('#phoneExt').val();

		var is_checked = $('#termsConfirm').is(":checked");

		if(is_checked)
		{
                    $.post("http://"+ defaultPageSettings.site+ "/supplier/add"
                ,{firstname:firstname,lastname:lastname,uname:uname,email:email,company:company,permit:permit,pass:pass,conpass:conpass,
			cctype:cctype,ccuname:ccuname,ccunum:ccunum,ccuccv:ccuccv,exp_month:exp_month,exp_year:exp_year,
			bnk_country:bnk_country,bk_owner:bk_owner,bk_name:bk_name,bk_name_add:bk_name_add,bk_acc:bk_acc,bnk_code:bnk_code,
			country:country,add1:add1,add2:add2,city:city,prov:prov,postal:postal,phone_num:phone_num,phone_ext:phone_ext,
			u_module:u_module,website:website,how_you_find:how_you_find,avg_sales:avg_sales,
			action:'register'},function(result){

				var  convert = JSON.parse(result);

                                if (convert.message.indexOf("success-cont")>-1)
                                {
                                    $(location).attr('href','http://www.oceantailer.com/completed_registration.php')
                                    return;
                                }

				$('.validate-result').hide();

                                //<div class='success-cont
                                $('.validate-result').html(convert.message);
				$('.validate-result').show();
				//setSizesDynamic();

			});
                        }
                        else
                        {
                            alert("Please agree to the use of terms prior to your registration")
                        }


	});
</script>
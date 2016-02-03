<!-- Lanz Editted - May 31, 2013 -->
<?php echo $this->load->view('buyer/header') ?>
<!-- LEFT SIDEBAR CONTAINER-->
<div class="nav-bar floatL">
    <?php echo $this->load->view('buyer/sidebar') ?>
</div>

<!-- RIGHT CONTENT CONTAINER-->
<div class='sliderLg floatR'>

<div class='right-inner clearfix'>


<div class='right-inner clearfix'>
    <!-- First Row Container-->
    <div class="topBrands searching-for">
        <div class="topBrandsHeader dynamic">
            <div class="floatl">
                Extract all of the products on the site
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['all']['xml']) ?>" target="_blank"><img src="/images/icons/icon-xml.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['all']['csv']) ?>" target="_blank"><img src="/images/icons/icon-csv.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['all']['txt']) ?>" target="_blank"><img src="/images/icons/icon-text.gif" height="32" style="vertical-align: middle;" /></a>
	            <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['all']['xls']) ?>" target="_blank"><img src="/images/icons/icon-xlsx.png" height="32" style="vertical-align: middle;" /></a>
            </div>
        </div>
    </div>
    <br/><br/>
</div>


<div class='right-inner clearfix'>
    <!-- First Row Container-->
    <div class="topBrands searching-for">
        <div class="topBrandsHeader dynamic">
            <div class="floatl">Extract all of the products that available for dropshipping
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['dp']['xml']) ?>" target="_blank"><img src="/images/icons/icon-xml.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['dp']['csv']) ?>" target="_blank"><img src="/images/icons/icon-csv.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['dp']['txt']) ?>" target="_blank"><img src="/images/icons/icon-text.gif" height="32" style="vertical-align: middle;" /></a>
	            <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['dp']['xls']) ?>" target="_blank"><img src="/images/icons/icon-xlsx.png" height="32" style="vertical-align: middle;" /></a>
            </div>
        </div>
    </div>
    <br/><br/>
</div>

<div class='right-inner clearfix'>
    <!-- First Row Container-->
    <div class="topBrands searching-for">
        <div class="topBrandsHeader">
            <div class="floatl">Extract a specific supplier's data to a feed </div>
        </div>
    </div>
    <br/><br/>
    <table class="gtable" id="supplierstable">
        <thead>
        <tr>
            <th style="width: 70%;">Supplier</th>
            <th>Feed</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="floatR">
        <?php if($suppliers_total > 1): ?>
            <ul id="supplierpagination">
                <?php for($i = 1; $i <= $suppliers_total; $i++): ?>
                    <li><a href="#" class="<?php if($i == 1): ?>current<?php endif ?>"><?php echo $i ?></a></li>
                <?php endfor; ?>
            </ul>
        <?php endif ?>
    </div>
    <br clear="both" />
    <br/><br/>
</div>

<div class='right-inner clearfix'>
    <!-- First Row Container-->
    <div class="topBrands searching-for">
        <div class="topBrandsHeader dynamic">
            <div class="floatl">Extract specific products data to a feed
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['custom']['xml']) ?>" target="_blank"><img src="/images/icons/icon-xml.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['custom']['csv']) ?>" target="_blank"><img src="/images/icons/icon-csv.png" height="32" style="vertical-align: middle;" /></a>
                <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['custom']['txt']) ?>" target="_blank"><img src="/images/icons/icon-text.gif" height="32" style="vertical-align: middle;" /></a>
	            <a href="/datafeed/download/?hash=<?php echo urlencode($hashes['custom']['xls']) ?>" target="_blank"><img src="/images/icons/icon-xlsx.png" height="32" style="vertical-align: middle;" /></a>
            </div>
        </div>
    </div>
    <br/><br/>
    <table class="gtable" id="datafeeditems">
        <thead>
        <tr>
            <th>Title</th>
            <th>SKU</th>
            <th>GTIN (UPC/EAN)</th>
            <th>Manufacture part No.</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <br/>
    <div class="clearfix">
        <div class="floatL">
            <!--<input type='button' class='greenbutton goexport' value='Extract' what="datafeed" />&nbsp;-->
            <input type='button' class='greenbutton js-delete-datafeed' data-id="all" value='Delete all' />
        </div>
        <div class="floatR">
            <?php if($datafeed_total > 1): ?>
                <ul id="datafeedpagination">
                    <?php for($i=1; $i <= $datafeed_total; $i++): ?>
                        <li><a href="#" class="<?php if($i == 1): ?>current<?php endif ?>"><?php echo $i ?></a></li>
                    <?php endfor; ?>
                </ul>
            <?php endif ?>
        </div>
        <br clear="both" />
    </div>
    <br/><br/>
</div>
</div>
<script type="text/javascript">
$(function() {

    var loadSuppliers = function(page) {
        $.get('/buyer/list_suppliers?page=' + page,
            function(data) {
                var tableBody = $('#supplierstable tbody');

                tableBody.html('');
                 if(data) {
                    for(var index in data.items) {
                        var row = data.items[index];
                        tableBody.append('<tr>' +
                        '<td>' + row.u_company + '</td>' +
                        '<td style="text-align: center;">' +
                        '<a href="/datafeed/download/?hash=' + encodeURIComponent(row.hashes.xml) + '" target="_blank"><img src="/images/icons/icon-xml.png" height="32" style="vertical-align: middle;" /></a>' +
                        '<a href="/datafeed/download/?hash=' + encodeURIComponent(row.hashes.csv) + '" target="_blank"><img src="/images/icons/icon-csv.png" height="32" style="vertical-align: middle;" /></a>' +
                        '<a href="/datafeed/download/?hash=' + encodeURIComponent(row.hashes.txt) + '" target="_blank"><img src="/images/icons/icon-text.gif" height="32" style="vertical-align: middle;" /></a>' +
                        '<a href="/datafeed/download/?hash=' + encodeURIComponent(row.hashes.xls) + '" target="_blank"><img src="/images/icons/icon-xlsx.png" height="32" style="vertical-align: middle;" /></a>' +
                        '</td>' +
                        '</tr>');
                    }
                }
            },
            'json'
        );
    };

    $('#supplierpagination a').click(function() {
        loadSuppliers($(this).html());
        $('#supplierpagination a').removeClass('current');
        $(this).addClass('current');
        return false;
    });

    loadSuppliers(1);

    var loadPage = function(page) {
        $.ajax({
            url: '/buyer/datafeed?page=' + page,
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#datafeeditems').find('tbody');
                tableBody.html('');
                var pages = $('#datafeedpagination');
                if(data) {
                    for(var index in data.items) {
                        var row  = data.items[index];
                        tableBody.append('<tr>' +
                        '<td>' + row.tr_title + '</td>' +
                        '<td>' + row.SKU + '</td>' +
                        '<td>' + row.upc_ean + '</td>' +
                        '<td>' + row.manuf_num + '</td>' +
                        '<td>' + row.b_name + '</td>' +
                        '<td>' + row.c_name + '</td>' +
                        '<td><a href="#" class="js-delete-datafeed" data-id="' + row.i_id + '">Delete</a>' +
                        '</tr>');
                    }
                }
            }
        });

    };


    $('#datafeedpagination a').click(function() {
        loadPage($(this).html());
        $('#datafeedpagination a').removeClass('current');
        $(this).addClass('current');
        return false;
    });
    loadPage(1);

    var base_url = '<?=base_url()?>';
    $(".goexport").on('click', function(){
        what = $(this).attr("what");
        button = $(this);
        var wasvalue = button.prop('value');
        var supplier = "";
        if(what == "suppliers"){
            supplier = $("#supplier-sel").val();
            if(!supplier) {
                alert("Supplier is not specified");
                return;
            }
        }

        $.ajax({
            url: '/datafeed/export/?what='+what+'&supplier='+supplier,
            dataType: 'json',
            beforeSend: function(){
                button.prop('value', 'working...');
            },
            success: function(data){
                if(data.result=='true'){
                    alert('Data was exported successfully');
                    if(what != "datafeed"){
                        $("#current-file-" + what).html("<a href='"+base_url+"user_export_files/"+data.info.filename+"' download>Download</a>");
                        $("#current-csvfile-" + what).html("<a href='#' class='js-csv' data-filename='"+data.info.filename+"'>Download</a>");
                        $("#current-date-" + what).text(data.info.date);
                    }
                    else {
                        var rows_quan = parseInt($("#datafeed-wrapper").attr("data-rows"));
                        if(rows_quan == 0){ //  Don't need to clone
                            $("#current-file-" + what).html("<a href='"+base_url+"user_export_files/"+data.info.filename+"' download>Download</a>");
                            $("#current-csvfile-" + what).html("<a href='#' class='js-csv' data-filename='"+data.info.filename+"'>Download</a>");
                            $("#current-date-" + what).text(data.info.date);
                            $("#current-actions-" + what).html("<a href='#' class='js-delete-file' data-id='"+data.info.id+"'>Delete</a>");
                            $("#datafeed-wrapper").attr("data-rows", rows_quan++);
                        }
                        else{
                            $new_tr = $(".datafeed-item:first").clone();
                            $new_tr.find("#current-file-" + what).html("<a href='"+base_url+"user_export_files/"+data.info.filename+"' download>Download</a>");
                            $new_tr.find("#current-csvfile-" + what).html("<a href='#' class='js-csv' data-filename='"+data.info.filename+"'>Download</a>");
                            $new_tr.find("#current-date-" + what).text(data.info.date);
                            $new_tr.find("#current-actions-" + what).find(".js-delete-file").attr("data-id", data.info.id);
                            $("#datafeed-wrapper tbody").prepend($new_tr);
                            $("#datafeed-wrapper tbody tr:first").remove();
                            $("#datafeed-wrapper").attr("data-rows", rows_quan++);
                        }
                    }
                }else{
                    alert('some error occured');
                }
                button.prop('value', wasvalue);
            },

            error: function(){
                alert('Error');
                button.prop('value', wasvalue);
            }
        });
    });

    $("body").on('click', '.js-csv', function(e){
        var filename = $(this).attr("data-filename");
        setTimeout(function(){$.ajax({
            url: '/datafeed/csv',
            data:{filename:filename},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(data){
                if(data.result=='true'){
                    e.preventDefault();  //stop the browser from following
                    window.location.href = base_url+"user_export_files/"+data.filename;
                }else{
                    alert('Some error occured');
                }
            },
            error: function(){
                alert('Error: .csv file wasn\'t created');
            }
        });}, 1000);
    });


    $('body').on('click', ".js-delete-datafeed", function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");  // 'all' or product_id
        $.ajax({
            url: '/datafeed/delete',
            data:{id:id},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(data){
                if(data.result=='true'){
                    alert("Deleted");
                    location.reload();
                }else{
                    alert('Some error occured');
                }
            },
            error: function(){
                alert('Error: data wasn\'t deleted');
            }
        });
    });

    $('body').on('click', ".js-delete-file", function(){
        var id = $(this).attr("data-id");  // 'all' or product_id
        $.ajax({
            url: '/datafeed/delete_file',
            data:{id:id},
            dataType: 'json',
            beforeSend: function(){
            },
            success: function(data){
                if(data.result=='true'){
                    alert("Deleted");
                    location.reload();
                }else{
                    alert('Some error occured');
                }
            },
            error: function(){
                alert('Error: data wasn\'t deleted');
            }
        });
    });
});
</script>
<?php echo $this->load->view('buyer/footer') ?>
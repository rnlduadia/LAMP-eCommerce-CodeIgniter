 defaultPageSettings = {
    site: location.origin//window.site//location.hostname
};
 function runSearch()
        {
            var search_filter = $(".search-box .search-field").val();
		var chosencat = $("#chosencat").text();
		cat = $(".search ul li a")
			.filter(function() {
			        return $(this).text() === chosencat;
			}).attr("data-id")

		;
//		alert(cat);
		$(".search input[name='cat']").val(cat);
		$(".search form").attr("action", $(".search form").attr("action") + escape(encodeURIComponent(search_filter)) + '/');
//		alert($(".search form").attr("action"));
		$(".search form").submit();
//		window.location.href = '/inventory/search/product/' + encodeURIComponent(search_filter) + '/';


        }

 var initPagination = function(){
    var links = $('ul.pagination').find('a'),
        form = $('ul.pagination').parents('form').eq(0);
     $(links).on('click',function(){
         var href = $(this).attr('href');
         if(href != 'javascript:void(0);')
            $(form).attr('action',href).trigger('submit');
         return false;
     });
 };
 var initSorter = function(){
     var links = $('table.tablesorter td.sortable').find('a'),
         form = $('table.tablesorter').parents('form').eq(0);
     $(links).on('click',function(){
         var new_by = $(this).attr('rel'),
             cur_sort = $('table.tablesorter').find('td.tablesorter-headerDesc, td.tablesorter-headerAsc').eq(0),
             new_order = 'desc';
         if($(cur_sort).find('a').eq(0).attr('rel') == new_by)
            new_order = $(cur_sort).hasClass('tablesorter-headerDesc')?'asc':'desc';
         $(form).find('input#sort_by').eq(0).val(new_by);
         $(form).find('input#sort_direction').eq(0).val(new_order);
         $(form).trigger('submit');
         return false;
     });
 };

 var toggleTop = function(bId,tkn_name,tkn_val){
     data = {};
     data['bid']=bId;
     data['is_top']=$('#toggle-top-'+bId).hasClass('deny')?1:0;
     data[tkn_name]=tkn_val;
     $.ajax(defaultPageSettings.site +"/brand/toggletop/",{
         'data': data,
         'dataType': 'json',
         'type': 'post',
         'error': function(jqXHR, textStatus, errorThrown){
            console.log(textStatus);
         },
         'success' : function(d, textStatus, jqXHR){
            if(d.res == 1) {
                console.log(data['is_top']);
                $('#toggle-top-' + bId).removeClass((data['is_top'] == 1)?'deny':'approve').addClass((data['is_top'] == 0)?'deny':'approve');
                $('#toggle-top-' + bId).text((data['is_top'] == 1)?'On':'Off');
            }
            else
            {
                alert('error during changing');
            }
         }
     });
 };

$(document).ready(function()
{


    $(".js-brand").click(function(){
		window.location.href = $(this).attr("href");
	});

        $(".search-box .form-control.search-field").keydown(function(e)
        {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code==13)
            {
                runSearch();
            }
        });

	$(".search-box .input-group-addon").click(function()
        {
            runSearch();
        });

		$(".dropdown-menu>li>a").on("click", function(){
			text = $(this).text();
			$("#chosencat").text(text);
		});
});

$(window).load(function(){
	$("a").click(function(event) {
    var csrf = $("#csrf").val();
 	var href = $(this).attr('href');
  	var link_tit = $(this).text();
 	 $.post(defaultPageSettings.site +"/user/click_link",{title:link_tit,href:href,csrf:csrf}, function(){
 	 });
	});
});


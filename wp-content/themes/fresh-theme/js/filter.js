jQuery(document).ready(function() {

     const ajaxurl = themeData.ajaxurl; 
     const templatedirectory = themeData.templatedirectory; 

     function brand(){

          let checkedValues1 = '';
          jQuery('#multiSelectDropdown1 input').each(function(){

               if(jQuery(this).is(':checked')){
                    checkedValues1 += jQuery(this).val() + ',';
               }

          });

          return checkedValues1 = checkedValues1.trim();

     }

     function category(){

          let checkedValues2 = '';
          jQuery('#multiSelectDropdown2 input').each(function(){

               if(jQuery(this).is(':checked')){
                    checkedValues2 = jQuery(this).val();
               }

          });

          return checkedValues2 = checkedValues2.trim();
     }

     jQuery('.tax1').click(function(){
          
          resetelement();
          var searchtext = jQuery('#searchtext').val();
          var data = { 'action': 'filter_product', 'category': category(), 'brand' : brand(), 'searchtext': searchtext, 'pageno': 1};

          console.log(data);

          jQuery.ajax({
               url    : ajaxurl,
               type   : 'POST',
               data   : data,      
               beforeSend: function() {
                    jQuery('#products').html('<img class="loader card-img-top img-fluid" width="100" src="'+templatedirectory+'/images/74H81.gif" alt="Loading...">');
                 },         
               success: function(response) {

                    jQuery('#products').empty().append(response);
                    jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );

               },

          });
     });



     jQuery('.tax2').click(function(){

          resetelement();
          var searchtext = jQuery('#searchtext').val();
          var data = { 'action': 'filter_product', 'category': category(), 'brand' : brand(), 'searchtext': searchtext, 'pageno': 1};

          console.log(data);

          jQuery.ajax({
               url    : ajaxurl,
               type   : 'POST',
               data   : data,      
               beforeSend: function() {
                    jQuery('#products').html('<img class="loader" width="100"  src="'+templatedirectory+'/images/74H81.gif" alt="Loading...">');
                 },         
               success: function(response) {

                    jQuery('#products').empty().append(response);
                    jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );

               },

          });
     });


     var pageno = jQuery('#pageno').val();
     var data = { 'action': 'filter_product','pageno': pageno};

     jQuery.ajax({
          url    : ajaxurl,
          type   : 'POST',
          data   : data,      
          beforeSend: function() {
               jQuery('#products').html('<img class="loader card-img-top img-fluid" width="100" src="'+templatedirectory+'/images/74H81.gif" alt="Loading...">');
          },         
          success: function(response) {

               jQuery('#products').empty().append(response);
               jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );

          },

     });


     jQuery(document).keydown(function(e) { 
          if (e.which === 13) {

               resetelement();
               var searchtext = jQuery('#searchtext').val();
               var data = { 'action': 'filter_product', 'category': category(), 'brand' : brand(), 'searchtext': searchtext, 'pageno': 1};

               console.log(data);

               jQuery.ajax({
                    url    : ajaxurl,
                    type   : 'POST',
                    data   : data,      
                    beforeSend: function() {
                         jQuery('#products').html('<img class="loader" width="100"  src="'+templatedirectory+'/images/74H81.gif" alt="Loading...">');
                      },         
                    success: function(response) {

                         jQuery('#products').empty().append(response);
                         jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );

                    },

               });

          }
     });



     jQuery('#loadmore').click(function(){

          var searchtext = jQuery('#searchtext').val();
          var pageno = jQuery('#pageno').val();
          var data = { 'action': 'filter_product', 'category': category(), 'brand' : brand(), 'searchtext': searchtext, 'pageno': pageno};


          jQuery.ajax({
               url    : ajaxurl,
               type   : 'POST',
               data   : data,      
               beforeSend: function() {
                   
                 },         
               success: function(response) {
                    
                    console.log(response);
                    console.log(typeof(response));
                    console.log(response.length);
                    if(response !=""){
                         jQuery('.loader').hide();
                         jQuery('#products').append(response);
                         jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );  
                    }

                    if(response.length == 0 ){
                         jQuery('#loadmore').text('No More Posts');
                    }

               },

          });

     });


     jQuery('#reset').click(function(){
          resetelement();
          jQuery('#searchtext').val('');
          jQuery('#multiSelectDropdown1 input[type="checkbox"],#multiSelectDropdown2 input[type="radio"]').prop('checked', false);

          var pageno = jQuery('#pageno').val();
          var data = { 'action': 'filter_product','pageno': pageno};

          jQuery.ajax({
               url    : ajaxurl,
               type   : 'POST',
               data   : data,      
               beforeSend: function() {
                    jQuery('#products').html('<img class="loader" width="100" src="'+templatedirectory+'/images/74H81.gif" alt="Loading...">');
               },         
               success: function(response) {

                    jQuery('#products').empty().append(response);
                    jQuery('#pageno').val( parseInt(jQuery('#pageno').val()) +1 );

               },

          });


     });

     function resetelement(){
          jQuery('#pageno').val('1');
          jQuery('#loadmore').text('Load More');
     }
});
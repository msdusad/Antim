//slider///
$(window).load(function(){
      $('.slider')._TMS({
              show:0,
              pauseOnHover:false,
              prevBu:'.prev',
              nextBu:'.next',
              playBu:false,
              duration:1000,
              preset:'fade', 
              pagination:true,//'.pagination',true,'<ul></ul>'
              pagNums:false,
              slideshow:10000,
              numStatus:false,
              banners:false,
          waitBannerAnimation:false,
        progressBar:false
      })  
      });    
     $(window).load (
function(){$('.carousel1').carouFredSel({auto: false,prev: '.prev',next: '.next', width: 1229, items: {
      visible : {min: 1,
       max: 4
},
height: 'auto',
width: 400,
    }, responsive: false, 
    scroll: 4, 
    mousewheel: false,    
    swipe: {onMouse: false, onTouch: false}});
   });

//filter sub category////
function showData(cat)
{  
     $.ajax({
          type: "POST",
          data: { cat:cat},
          url: "get_data.php",
          success: function(data) 
          { 
              //alert(data);
              $("#hide").html(data);
          }
        });
    //var fullid="hide-"+show;
    //alert(show);
    //document.getElementById(fullid).style.display="block";
    //document.getElementById(hide).style.display="none";    
}

//filter country state city in select box//
$(document).ready(function()
{
 $("#country").change(function()
 {
  var id=$(this).val();
  var dataString = 'stateid='+ id;
  $.ajax
  ({
   type: "POST",
   url: "get_data.php",
   data: dataString,
   cache: false,
   success: function(html)
   {
      $("#state").html(html);
   } 
   });
  });
 $("#state").change(function()
 {
  var id=$(this).val();  
  var dataString='cityid='+ id;
 $.ajax
  ({
   type: "POST",
   url: "get_data.php",
   data: dataString,
   cache: false,
   success: function(html)
   { 
    $("#city").html(html);
   } 
   });
  }); 
});

//filter product select subcat value///
function subcat(catval,subcat){
        $.ajax
        ({
        type: "POST",
        url: "get_data.php",
        data: {cat_value:catval,sub_cat:subcat},
        success: function(html)
        {   
            //alert(html);
            $("#pro_items").html(html);
        } 
        });
    }

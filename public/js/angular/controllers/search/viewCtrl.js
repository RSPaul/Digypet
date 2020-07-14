searchApp.controller('ViewCtrl', function($scope, $http, $timeout, $locale, $location, $rootScope) {

	$(' .owl_1').owlCarousel({
           loop:false,
           margin:2,    
           responsiveClass:true,autoplayHoverPause:true,
           autoplay:true,
           slideSpeed: 400,
           paginationSpeed: 400,
           autoplayTimeout:3000,
           responsive:{
            0:{
            items:2,
            nav:true,
            loop:false
            },
            600:{
            items:3,
            nav:true,
            loop:false
            },
            1000:{
            items:4,
            nav:true,
            loop:false
            }
          }
         })  
         
         
         $(' .owl_2').owlCarousel({
           loop:false,
           margin:2,    
           responsiveClass:true,autoplayHoverPause:true,
           autoplay:true,
           slideSpeed: 400,
           paginationSpeed: 400,
           autoplayTimeout:3000,
           responsive:{
            0:{
            items:2,
            nav:true,
            loop:false
            },
            600:{
            items:3,
            nav:true,
            loop:false
            },
            1000:{
            items:6,
            nav:true,
            loop:false
            }
          }
         })   
         
         
         $(document) .ready(function(){
         var li =  $(".owl-item li ");
         $(".owl-item li").click(function(){
         li.removeClass('active');
         });
         });   

});
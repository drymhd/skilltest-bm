<template>
    <main>
         <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <router-link to="/" class="logo">
                            <img src="/images/logo.png" alt="logo">
                        </router-link>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><router-link :to="{name: 'home'}">Home</router-link></li>
                            <li><router-link :to="{name: 'keranjang'}">Keranjang</router-link></li>
                            <li><router-link :to="{name: 'transaksi'}">transaksi</router-link></li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <router-view></router-view>
    
    </main>
</template>


<script>
export default {
    mounted(){
        
        	$(window).scroll(function() {
	  var scroll = $(window).scrollTop();
	  var box = 365;
	  var header = $('header').height();

    //   console.log(box)
      console.log(header)

	  if (scroll >= box - header) {
	    $("header").addClass("background-header");
	  } else {
	    $("header").removeClass("background-header");
	  }
	});
	
	if($('.menu-trigger').length){
		$(".menu-trigger").on('click', function() {	
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}




	$(document).on("click", ".naccs .menu div", function() {
		var numberIndex = $(this).index();
	
		if (!$(this).is("active")) {
			$(".naccs .menu div").removeClass("active");
			$(".naccs ul li").removeClass("active");
	
			$(this).addClass("active");
			$(".naccs ul").find("li:eq(" + numberIndex + ")").addClass("active");
	
			var listItemHeight = $(".naccs ul")
				.find("li:eq(" + numberIndex + ")")
				.innerHeight();
			$(".naccs ul").height(listItemHeight + "px");
		}
	});
    }
}
</script>
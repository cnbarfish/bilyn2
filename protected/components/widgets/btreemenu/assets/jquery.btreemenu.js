;(function($) {

	// TODO rewrite as a widget, removing all the extra plugins
	$.extend($.fn, {		
		btreemenu: function(settings) {

			//alert("1");
			// hide all the sub-menus
			$(".btreemenu span.toggle").next().next().hide();
			$(".btreemenu span.toggle").next().css("padding-left","0px");

			// add a link nudging animation effect to each link
			$(".btreemenu span.toggle").hover(function() {
				$(this).stop().animate({
				//	fontSize : "20px",
				//	paddingLeft : "5px",
					color : "red"
				}, 300);
			}, function() {
				$(this).stop().animate({
					fontSize : "14px",
			//		paddingLeft : "0px",
					color : "black"
				}, 300);
			});

			// set the cursor of the toggling span elements
			$(".btreemenu span.toggle").css("cursor", "pointer");

			// prepend a plus sign to signify that the sub-menus aren't expanded
			//$(".btreemenu span.toggle").prepend("+ ");

			// add a click function that toggles the sub-menu when the
			// corresponding
			// span element is clicked
			$(".btreemenu span.toggle").click(function() {
			//	$("ul.close").next().toggleClass("open");
			//	$("ul.open").next().toggleClass("close");
				
				$(this).next().next().toggle(300);

				// switch the plus to a minus sign or vice-versa
				var v = $(this).html().substring(0, 1);
				if (v == "+")
					$(this).html("-" + $(this).html().substring(1));
				else if (v == "-")
					$(this).html("+" + $(this).html().substring(1));
			});
			
			return this;
		}
	});

	

})(jQuery);
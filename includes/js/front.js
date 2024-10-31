
jQuery( document ).ready(function() {
    jQuery(".slider-display").each(function() {
        var step=jQuery(this).attr("step");
        var min=jQuery(this).attr("min");
        var max=jQuery(this).attr("max");
        var prefixx=jQuery(this).attr("Prefix");
        var prefixpos=jQuery(this).attr("sliderposition");
        var color=jQuery(this).attr("color");
        var tooltipposition=jQuery(this).attr("tooltipposition");
        var istep = parseInt(step);
        var imin = parseInt(min);
        var imax = parseInt(max);
        if(tooltipposition == "top"){
            var tooltip = jQuery('<div  class="top rstooltip"/>').css({
                top: -35,      
            })
        }
        if(tooltipposition == "left"){
            var tooltip = jQuery('<div  class="left rstooltip "/>').css({
                right: 35
            })
        }
        if(tooltipposition == "right"){
            var tooltip = jQuery('<div class="right rstooltip "/>').css({ 
                left: 35                
            })
        }
        if(tooltipposition == "bottom"){
          // alert("hello");
            var tooltip = jQuery('<div class="bottom rstooltip"/>').css({
                bottom: -35 

            })
        }
   
        if(prefixx == null){
            prefix = " ";
        }else{
            prefix = prefixx;
        }

        if(prefixpos == "left") {
            tooltip.text(prefix + min);
        }else {  
            tooltip.text(min + prefix);        
        }

        var curr = jQuery(this);
        jQuery(this).slider({
            step:istep,
            min:imin,
            max:imax,
            values: imin,
            create: attachSlider,
            slide: function(event, ui ) {
                 curr.find("input").val(ui.value); 
                var clr = jQuery(this).attr("color");
                var pre = jQuery(this).attr("prefix");
                if(pre == null){
                    prefix = "";
                }else{
                    prefix = pre;
                }
                if(prefixpos == "left"){
                    curr.find(".rstooltip").text(prefix  + ui.value);  
                }else {
                   curr.find(".rstooltip").text(ui.value + prefix);
                }

                curr.find(".ui-state-default").attr('style', 'background:'+clr+'!important');
                
            }        
        }).find(".ui-slider-handle").append(tooltip).hover(function() {
            tooltip.show()
        })
        function attachSlider() {
            jQuery(this).find(".ui-slider-handle").attr('style','background:'+color+'!important');
        
        }
    });
});
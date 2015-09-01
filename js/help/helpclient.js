HelpAjax = Class.create();
HelpAjax.prototype =
{
	
    linkClass : 'a.page-helpclient',
    top_helpclient_selector: '.header-helpclient',
    base_url : null,
    video_url : null,
    video_width : 560,
    video_height : 315,
    

    initialize : function(options) {
            
        this.base_url = options['base_url'];    
        this.video_url = options['video_url'];
        this.video_width = options['video_width'];
        this.video_height = options['video_height'];
    },

    createHelpContainer: function() {

        var mainDiv = $$(this.top_helpclient_selector)[0];
        var container = $('helpclient_container'); 

        Event.observe(container, 'mouseover',function() {HelpAjaxObj.showMinicart()} );
        Event.observe(container, 'mouseout',function() {HelpAjaxObj.hideMinicart()} );
        Event.observe(mainDiv,   'mouseover',function() {HelpAjaxObj.showMinicart()} );
        Event.observe(mainDiv,   'mouseout',function() {HelpAjaxObj.hideMinicart()} );
    },

    showMinicart: function() {
        //Effect.toggle('helpclient_container', 'appear'); return false;
        $('helpclient_container').show();
    },

    hideMinicart: function() {
        //Effect.toggle('helpclient_container', 'appear'); return false;
        $('helpclient_container').hide();
    },

    openMyPopup: function() {
    	//function openMyPopup() {
	 
        var url = this.video_url;
 
        if ($('browser_window') && typeof(Windows) != 'undefined') {
            Windows.focus('browser_window');
            return;
        }
        var dialogWindow = Dialog.info(null, {
            closable:true,
            resizable:true,
            draggable:true,
            className:'magento',
            windowClassName:'helpclient_window',
            title:'How to Use MageTraining help',
            top:50,
            width:this.video_width,
            height:this.video_height,
            zIndex:1000,
            recenterAuto:false,
            hideEffect:Element.hide,
            showEffect:Element.show,
            id:'helpclient_window',
            url:url,
            onClose:function (param, el) {
                //alert('onClose');
            }
        });
    },

    locate: function(ele) {

    	var keyPressed = ele.keyCode || ele.which;
        if(keyPressed==13)
        {
            var str = $('helpquery_search').getValue();
			str = str.replace(/\s/g, "+");

	    	var searchUrl = this.base_url+'/catalogsearch/result/?q='+str;
    		keyPressed=null;
    		window.open(
			  searchUrl,
			  '_blank'
			);
        }else{
            return false;
        }
    	
    }
}

document.observe("dom:loaded", function() {
	HelpAjaxObj.createHelpContainer();
});
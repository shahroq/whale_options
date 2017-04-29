jQuery(document).ready(function($) {
    //select all checkbox
    $('#ccm-list-cb-all').click(function(){
        $("input[type='checkbox']").prop('checked', this.checked);
    });

    //expand/collapse
    //$("a.show-hide").click(function (e) {
    $('body').on('click', 'a.show-hide', function(e) {
        e.preventDefault();
        var ref = $(this).attr("href");
        //var target = $(ref);
		var target = $(this).closest("div.well").find(ref);
        //console.log("==>");
        //console.log(target);
        if (target.is(":visible")) {
            $(this).find("i").attr("class", "fa fa-chevron-down");
            target.stop(true, true).slideUp();
        } else {
            $(this).find("i").attr("class", "fa fa-chevron-up");
            target.stop(true, true).slideDown();
        }
        return false
    });

    $('#embed').on('click', function(e){
        $(this).select();
    });    



    $('#refresh_summary_w1')
    .add('#refresh_pages_w1')
    .add('#refresh_search_w1')
    .add('#refresh_agents_w1')
    .add('#refresh_agents_w2')
    .add('#refresh_visitors_w1')
    .add('#refresh_map_w1')
    .on('click', function(e){
        e.preventDefault();
        var btn = $(this); 
        var id = btn.attr('id');
        var url = btn.attr('href').substr(1); //remove # 
        var date_from = $('input#date_from').val();
        var date_to = $('input#date_to').val();
        //url = url + '?date_from='+date_from+'&date_to='+date_to;
        var canvas = btn.closest('.well').find('.wsp-container'); //ajax container
        //console.log(canvas);
        
        $.ajax({
            method: 'POST',
            url: url,
            data: {date_from: date_from, date_to: date_to},
            dataType: 'html',
            success: function(rslt) {
                canvas.html('');
                canvas.html(rslt);
                //serializePositions();
                //selectableTags();
                btn.find('i').removeClass('fa-spin');
            },
            beforeSend: function(){
                canvas.html('');
                //console.log($(this).attr('id'));
                //console.log(btn); 
                btn.find('i').addClass('fa-spin');
            },
            error: function() {
                //canvas.html(errorHTML);
            }

        });
        
    });

    //initiate
    $('#refresh_summary_w1').click();
    $('#whale-form .nav-tabs.nav li:first-child a').attr('data-clicked', 1);
    $('#whale-form .nav-tabs.nav li a').on('click', function(e){
        if($( this ).attr('data-clicked')!=1){
            container = $('#ccm-tab-content-'+$(this).data('tab'));
            btnsToCLick = container.find('.refresh');
            $( this ).attr('data-clicked', 1); //load content on click only for the first time, then user need to click refresh manually
            btnsToCLick.each(function() {
                $( this ).click();

            });
        };    
    });
    /*
    $('#refresh_pages_w1').click();
    $('#refresh_engine_w1').click();
    $('#refresh_agents_w1').click();
    $('#refresh_agents_w2').click();
    $('#form_visitors_w1').click();
    $('#refresh_map_w1').click();
    */
   ////
});

/*Summary*/
$.fn.drawSummary = function(data) {
    Morris.Line({
        element: 'summary-w1-graph',
        data: data,
        /*
        data: [
         { y: '2012-02-24', a: 100, b: 90 },
        { y: '2012-02-25', a: 75,  b: 65 },
        { y: '2012-02-26', a: 50,  b: 40 },
        { y: '2012-02-27', a: 75,  b: 65 },
        { y: '2012-02-28', a: 50,  b: 40 },
        { y: '2012-02-29', a: 75,  b: 65 },
        { y: '2012-02-30', a: 100, b: 90 }
        ],
        */    
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Views', 'Visitors']
    });
}

/*Agents: Platform*/
$.fn.drawSearchEngines = function(data) {
    Morris.Donut({
      element: 'search-w1-graph',
      resize: true,
      data: data
    });
}

$.fn.drawAgentsPlaforms = function(data) {
    Morris.Donut({
      element: 'agents-w1-graph',
      resize: true,
      data: data
    });
}
$.fn.drawAgentsBrowsers = function(data) {
    Morris.Donut({
      element: 'agents-w2-graph',
      resize: true,
      data: data
    });
}

/*visitor tracker accordion*/
$.fn.expandVisitorsTracker = function() {
    $('a#expand_visitors_tracker').on('click', function(e){
        e.preventDefault();
        btn = $(this); 
        i = btn.find('i');
        url = $('input[name="expand_visitors_tracker"]').val(); //hidden field keep url from main controller
        canvas = btn.closest('.table').find('tbody'); //ajax container
        id = btn.closest('.table').attr('data-id');

        if(i.hasClass('fa-minus-square-o')){
            canvas.html('');
            i.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        }else{
            $.ajax({
                url: url,
                data: {id:id},
                dataType: 'html',
                success: function(rslt) {
                    canvas.html('');
                    canvas.html(rslt);
                    //serializePositions();
                    //selectableTags();
                    i.removeClass('fa-spin');
                    i.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                },
                beforeSend: function(){
                    //canvas.html(loaderHTML);
                    //console.log($(this).attr('id'));
                    //console.log(btn); 
                    i.addClass('fa-spin');
                },
                error: function() {
                    //canvas.html(errorHTML);
                }
            });
        }
        
        
    });
    return this;
};
    
$.fn.drawMap = function(data) {
    //console.log("555");
    //console.log(data);
    //data = {"ru":20,"ir":101,"us":70};
    var max = 0,
        min = 0,
        cc,
        startColor = [255, 255, 255],
        endColor = [255,0,0],
        colors = {},
        hex;


    //find maximum and minimum values
    for (cc in data)
    {
        if (parseFloat(data[cc]) > max)
        {
            max = parseFloat(data[cc]);
        }
        if (parseFloat(data[cc]) < min)
        {
            min = parseFloat(data[cc]);
        }
    }

    //set colors according to values of GDP
    for (cc in data)
    {
        if (data[cc] > 0)
        {
            colors[cc] = '#';
            for (var i = 0; i<3; i++)
            {
                hex = Math.round(startColor[i]
                    + (endColor[i]
                    - startColor[i])
                    * (data[cc] / (max - min))).toString(16);

                if (hex.length == 1)
                {
                    hex = '0'+hex;
                }

                colors[cc] += (hex.length == 1 ? '0' : '') + hex;
            }
        }
    }

    jQuery('#map-w1-graph').vectorMap({
        map: 'world_en',
        colors: colors,
        hoverOpacity: 0.7,
        hoverColor: false,
        selectedColor: false,
        onLabelShow: function(event, label, code)
        {
            txt = code.toUpperCase();
            if(data[code]==undefined){
                txt+= " (0)";
            }else{
                txt+= " ("+data[code]+"%)";
            }
            
            label.text(txt);
        },
    });
    

    return this;

};


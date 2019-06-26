// $Id: juitter.js,v 1.4 2009/08/23 07:33:20 doublethink Exp $

if (Drupal.jsEnabled) {	
	Drupal.behaviors.Juitter = function (context) {
		var juitter = Drupal.settings.Juitter;
		juitter.get_tweets = function(id) {
			$.Juitter.start({
				'searchType': eval('juitter.' + id + '.searchType'),
				'searchObject': eval('juitter.' + id + '.searchObject'),
				'lang': eval('juitter.' + id + '.lang'),
				'live': "live-" + eval('juitter.' + id + '.live'),
				'placeHolder': 'juitterContainer',
				'loadMSG': eval('juitter.' + id + '.loadMSG'),
				'imgName': eval('juitter.' + id + '.imgName'),
				'total': eval('juitter.' + id + '.total'),
				'readMore': eval('juitter.' + id + '.readMore'),
				'nameUser': eval('juitter.' + id + '.nameUser'),
				'openExternalLinks': eval('juitter.' + id + '.openExternalLinks'),
		        'filter': eval('juitter.' + id + '.filter')
			});
		};
		juitter.get_tweets($('#juitterTabsWrapper a:first').attr('id'));
		$("a.juitterTab").click(function(){
			var id = $(this).attr('id');
			$("li.juitterTab").removeClass("active");
			$("a.juitterTab").removeClass("active");
			$(this).addClass("active");
			$(this).parent("li.juitterTab").addClass("active");
			if(eval('juitter.' + id) == false) {
				$('#juitterContainer').html(Drupal.t('Please set the settings for this trend.'));
			}
			else { juitter.get_tweets(id); }
			return false;
		});
		
		/* Search box */
		if (juitter.search) {
	        $("#juitterSearch").submit(function(){
				$.Juitter.start({
					'searchType':"searchWord",
					'searchObject':$(".juitterSearch").val(),
					'live':"live-20",
					'filter':"sex->*BAD word*,porn->*BAD word*,fuck->*BAD word*,shit->*BAD word*"
				});
		        return false;
			});
	        $(".juitterSearch").blur(function(){
	            if($(this).val()=="") $(this).val(Drupal.t(juitter.search.text));
	        });
	        $(".juitterSearch").click(function(){
	            if($(this).val()==Drupal.t(juitter.search.text)) $(this).val("");
	        });
		};
        /* /Search box */
	};
};


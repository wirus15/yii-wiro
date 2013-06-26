(function($) {
    $.fn.photosManager = function() {
	return this.each(function() {
	    var th = $(this);
	    var button = th.find('.upload-button');
	    var input = th.find('input[type="file"]');
	    var uploadForm = input.parents('form');
	    var thumbnails = th.find('ul.thumbnails');
	    var loader = th.find('.ajax-loader');
	    
	    function saveSort() {
		var form = thumbnails.parents('form');
		var action = form.attr('action');
		
		loader.fadeIn();
		$.post(action, form.serialize(), function() {
		    loader.fadeOut();
		});
	    };
	    
	    function saveRemove(e) {
		var self = $(this);
		var thumbnail = self.parents('li');
		e.preventDefault();
		
		thumbnail.fadeOut('normal', function() {
		    thumbnail.remove();
		});
		
		loader.fadeIn();
		$.post(self.attr('href'), { 
		    'PhotosManager[image]': self.attr('data-image'),
		    'PhotosManager[action]': 'remove'
		}, function() { loader.fadeOut(); });
	    };
	    
	    input.css({
		position: 'absolute',
		left: -9999
	    });
	    
	    button.click(function() { input.click(); });
	    input.change(function() { uploadForm.submit(); });
	    thumbnails.find('a.remove-button').click(saveRemove);
	    
	    thumbnails.sortable({
		update: saveSort
	    });
	});
    };
})(jQuery);
$(document).ready(function() {
	$.get("https://www.googleapis.com/youtube/v3/playlistItems", {
		part: 'snippet',
		maxResults: 1,
		playlistId: 'UUP4eZIghdl2Pneq5vH4XiRA',
		forUsername: 'coursmaths_ac',
		key: 'AIzaSyDnHrh5DobcXSGN5FhZj6O1JUh7lZt4zOM'
	}, function (data) {
		$.each(data.items, function (i, item) {
			$('#result-iframe-youtube').append('<iframe src="https://www.youtube.com/embed/' + item.snippet.resourceId.videoId + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
			$('#result-title-youtube').html(item.snippet.title);
			$('#result-text-youtube').html(item.snippet.description.replace(/(\r\n|\n|\r)/gm, "<br/>").substring(0, 175) + " ...");
			$('#result-url-youtube').attr("href", "https://youtu.be/qbpaa7qzhjo" + item.snippet.resourceId.videoId);
		})
	});
});

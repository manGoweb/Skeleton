$(function() {
	$('.control-map').each(function(i, el) {
		var map = new L.Map($(el).attr('id'), {
			center: new L.LatLng($(el).data('lat'), $(el).data('lng')),
			zoom: $(el).data('zoom')
		});
		L.tileLayer.provider('Stamen.Watercolor').addTo(map);
	});
});

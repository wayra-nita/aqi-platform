var MapView = Backbone.View.extend({
    el: $('body'),
    
    mapModel: null,
    
    initialize: function (){
        this.mapModel = new MapModel();
        
    },
    
    renderMap: function (){
        var self = this;
        function initializeMap(){
            var mapOptions = {
                center: self.mapModel.createLatLngObj(),
                zoom: self.mapModel.get('zoom'),
                mapTypeId: self.mapModel.get('mapTypeId')
            };
            var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
            
            var imageBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(40.712216,-74.22655),
      new google.maps.LatLng(40.773941,-74.12544));
      
      var oldmap = new google.maps.GroundOverlay(
        "http://www.lib.utexas.edu/maps/historical/newark_nj_1922.jpg",
        imageBounds);
    oldmap.setMap(map);
        }
      google.maps.event.addDomListener(window, 'load', initializeMap);
      
      
    }
});


var MapView = Backbone.View.extend({
    el: $('body'),
    
    mapModel: null,
    
    initialize: function (){
        this.mapModel = new MapModel('map_canvas');
        
    },
    
    renderMap: function (){
        var self = this;
        this.mapModel.triggerMap();
        setTimeout(function (){
            self.mapModel.makeCoordinatesRequest();
        }, 3000);
        
    }
});


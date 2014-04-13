var MapView = Backbone.View.extend({
    el: $('body'),
    
    mapModel: null,
    
    initialize: function (){
        this.mapModel = new MapModel('map_canvas');
        
    },
    
    renderMap: function (){
        this.mapModel.triggerMap();            
    }
});


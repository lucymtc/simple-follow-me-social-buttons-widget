/**
 * List of icons
 */
sfmsb.IconsView = Backbone.View.extend({
	initialize: function(){
		this.render();
	},

	render: function(){
		this.$el.empty();
		this.collection.each( this.addOne, this );
	},

	/**
	 * Add 1 icon to the collection
	 */
	addOne: function( model ) {
		var item = new sfmsb.IconView({ model: model });
		this.$el.append( item.render().el );
	}

});

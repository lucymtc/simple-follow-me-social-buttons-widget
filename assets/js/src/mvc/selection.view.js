/**
 * List of icons
 */
sfmsb.SelectionView = Backbone.View.extend({

	initialize: function(){
		this.render();
		this.listenTo( this.collection, 'add remove', this.addRemove, this );
	},

	render: function(){
		this.$el.empty();
		this.collection.each( this.addOne, this );
	},

	/**
	 * Add 1 icon to the collection
	 */
	addOne: function( model ) {
		var item = new sfmsb.SelectionIconView({ model: model });
		this.$el.append( item.render().el );
	},

	/**
	 * Make sure settings get updated only when render has finished
	 */
	addRemove: function(){
		this.render();
		// var self = this;
		// $.when( self.render() ).done(function() {
  	//
		// });
		//
	},

});

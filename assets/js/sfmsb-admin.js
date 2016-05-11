/*! Simple Follow Me Social Buttons Widget - v0.1.0
 * http://wordpress.org/plugins
 * Copyright (c) 2016; * Licensed GPLv2+ */

 window.sfmsb = window.sfmsb || {};

( function( $, window, undefined ) { 
 'use strict'; 

sfmsb.IconView = Backbone.View.extend({

	template: _.template( $(document.getElementById( 'sfmsb-icon' )).html() ),
	tagName: 'a',

	events: {
		'click': 'addToSelection'
	},

	attributes: function(){
		return {
			class: 'sfmsb-icon-' + this.model.get('id') + ' sfmsb-' + this.model.get('style')
		};
	},

	initialize: function(){
		this.render();
	},

	render: function() {
		this.$el.html( this.template( this.model.attributes ) );
		return this;
	},

	addToSelection: function( event ){

		var selection = sfmsb.iconsListsCollections.selection;

		var model = new sfmsb.IconModel({
			id: this.model.get('id'), // used for backbone's reference
			name: this.model.get('name'),
			color: this.model.get('color'),
			hoverColor: this.model.get('hoverColor'),
			group: this.model.get('group'),
			style: this.model.get('style'),
			order: null
		});

		selection.add( model );
	}

});

sfmsb.SelectionIconView = Backbone.View.extend({

	template: _.template( $(document.getElementById( 'sfmsb-icon' )).html() ),
	tagName: 'a',

	events: {
		'click': 'displaySettings'
	},

	attributes: function(){
		return {
			class: 'sfmsb-icon-' + this.model.get('id') + ' sfmsb-' + this.model.get('style')
		};
	},

	initialize: function(){
		this.render();
	},

	render: function() {
		this.$el.html( this.template( this.model.attributes ) );
		return this;
	},

	displaySettings: function(){
		console.log('display settings');
	}

});

sfmsb.IconModel = Backbone.Model.extend({
	defaults: {
		id: null, // used for backbone's reference
		name: '',
		slug: '',
		color: sfmsbWidget.iconColor,
		hoverColor: sfmsbWidget.iconHoverColor,
		group: sfmsbWidget.defaultGroup,
		style: sfmsbWidget.defaultStyle,
		order: null
	}
});

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

sfmsb.SelectionView = Backbone.View.extend({

	el: '.sfmsb-selection',

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

sfmsb.IconsCollection = Backbone.Collection.extend({
	model: sfmsb.IconModel
});

sfmsb.widget = (function(){

	function initialize(){
		sfmsb.iconsListsCollections = [];
		sfmsb.iconsLists = [];

		// Each group of icons to select from.
		_.each( sfmsbWidget.collections, function( collection, key ){
			sfmsb.iconsListsCollections[key] = new sfmsb.IconsCollection( collection.icons );
			sfmsb.iconsLists[key] = new sfmsb.IconsView({
				collection: sfmsb.iconsListsCollections[key],
				el: '.sfmsb-group-' + key
			});
		});

		// Users selection.
		var selection = {};
		sfmsb.iconsListsCollections.selection = new sfmsb.IconsCollection( selection );
		sfmsb.iconsLists.selection = new sfmsb.SelectionView({
			collection: sfmsb.iconsListsCollections.selection
		});
	}

	/**
 	 * public init function
 	 * @uses  initialize
 	 * @return void
 	 */
 	return{
 		init: initialize
 	};

})();

sfmsb.widget.init();

} )( jQuery, this );
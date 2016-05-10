/**
 * Single icon view
 */
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

/**
 * Single icon view
 */
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

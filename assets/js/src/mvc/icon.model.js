/**
 * Single icon model
 */
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

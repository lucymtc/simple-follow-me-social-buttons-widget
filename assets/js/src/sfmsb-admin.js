/**
 * Simple Follow Me Social Buttons Widget
 * http://wordpress.org/plugins
 *
 * Copyright (c) 2016 Lucy Tomas
 * Licensed under the GPLv2+ license.
 */

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
		//
		_.each( document.querySelectorAll( '.sfmsb-selection' ), function( el, key ){
			var widgetID = el.dataset.widget;
			var selection = {};

			sfmsb.iconsListsCollections.selection = sfmsb.iconsListsCollections.selection || [];
			sfmsb.iconsLists.selection = sfmsb.iconsLists.selection || [];

			sfmsb.iconsListsCollections.selection[ widgetID ] = new sfmsb.IconsCollection( selection );
			sfmsb.iconsLists.selection[ widgetID ] = new sfmsb.SelectionView({
				collection: sfmsb.iconsListsCollections.selection[ widgetID ],
				el: '#sfmsb-selection-' + widgetID,
			});
			console.log( sfmsb.iconsListsCollections.selection[ widgetID ] );
			console.log( sfmsb.iconsLists.selection[ widgetID ] );
			console.log('------');
		});

		console.log( 'end', sfmsb.iconsLists.selection );

		// var selection = {};
		// sfmsb.iconsListsCollections.selection = new sfmsb.IconsCollection( selection );
		// sfmsb.iconsLists.selection = new sfmsb.SelectionView({
		// 	collection: sfmsb.iconsListsCollections.selection
		// });
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

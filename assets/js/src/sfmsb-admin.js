/**
 * Simple Follow Me Social Buttons Widget
 * http://wordpress.org/plugins
 *
 * Copyright (c) 2016 Lucy Tomas
 * Licensed under the GPLv2+ license.
 */

sfmsb.widget = (function(){

	function initialize(){
		//sfmsb.iconsListsCollections = [];
		//sfmsb.iconsLists = [];

		// Each group of icons to select from.
		// _.each( sfmsbWidget.collections, function( collection, key ){
		// 	sfmsb.iconsListsCollections[key] = new sfmsb.IconsCollection( collection.icons );
		// 	sfmsb.iconsLists[key] = new sfmsb.IconsView({
		// 		collection: sfmsb.iconsListsCollections[key],
		// 		el: '.sfmsb-group-' + key
		// 	});
		// });

			sfmsb.iconsListsCollections = new sfmsb.IconsCollection( sfmsbWidget.collections['social-networking'].icons );
			sfmsb.iconsLists = new sfmsb.IconsView({
				collection: sfmsb.iconsListsCollections,
				el: '.sfmsb-group-' + 'social-networking'
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

define([
	'angular'
], function(angular) {

	var directive = function(magezonBuilderUrl) {
		return {
			replace: true,
			templateUrl: function(elem) {
				return magezonBuilderUrl.getTemplateUrl(elem, 'Magezon_Builder/js/templates/builder/element/list.html');
			},
			controller: function($scope, $controller) {
				var parent = $controller('listController', {$scope: $scope});
				angular.extend(this, parent);
			},
			controllerAs: 'mgz'
		}
	}

	return directive;
});
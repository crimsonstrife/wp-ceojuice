/** @format */

angular
	.module("app", [])
	.controller("ctrl-toggle-switch", [
		"$scope",
		function ($scope) {
			var switches = [
				{
					id: "001",
					IsRightAligned: false,
					IsChecked: true,
					IsDisabled: false,
				},
				{
					id: "002",
					IsRightAligned: false,
					IsChecked: true,
					IsDisabled: true,
				},
				{
					id: "003",
					IsRightAligned: false,
					IsChecked: false,
					IsDisabled: true,
				},
				{
					id: "004",
					IsRightAligned: true,
					IsChecked: false,
					IsDisabled: false,
				},
			];
			$scope.title = "CSS Toggle Switch - Checkbox";
			$scope.switches = switches;
		},
	])
	.controller("ctrl-radio", [
		"$scope",
		function ($scope) {
			var radios = [
				{
					id: "001",
					IsRightAligned: false,
					IsDisabled: false,
				},
				{
					id: "002",
					IsRightAligned: false,
					IsDisabled: true,
				},
				{
					id: "003",
					IsRightAligned: false,
					IsDisabled: true,
				},
				{
					id: "004",
					IsRightAligned: true,
					IsDisabled: false,
				},
			];

			$scope.selectedRadio = "002";

			$scope.title = "CSS Radios";
			$scope.radios = radios;
		},
	]);

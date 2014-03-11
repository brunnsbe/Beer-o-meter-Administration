'use strict';

var app = angular.module('beerOMeter',
	['beerOMeter.directives', 'beerOMeter.services', 'ngRoute', 'ui.bootstrap', 'pascalprecht.translate']);

//############################################################################################	
	
app.config(['$routeProvider', function($routeProvider) {
	$routeProvider
	  .when('/languages', {
		controller: 'LanguagesListCtrl',
		templateUrl:'/views/languages/list.html'
	  })
	  .when('/countries', {
		controller: 'CountriesListCtrl',
		templateUrl:'/views/countries/list.html'
	  })
	  .when('/districts', {
		controller: 'DistrictsListCtrl',
		templateUrl:'/views/districts/list.html'
	  })
	  .when('/candidates', {
		controller: 'CandidatesListCtrl',
		templateUrl:'/views/candidates/list.html'
	  })
	  .when('/parties', {
		controller: 'PartiesListCtrl',
		templateUrl:'/views/parties/list.html'
	  })
	  .when('/questions', {
		controller: 'QuestionsListCtrl',
		templateUrl:'/views/questions/list.html'
	  })	  
	  .otherwise({redirectTo: '/parties'});
}]);

//############################################################################################

app.config(['$translateProvider', function ($translateProvider) {	
	$translateProvider.useUrlLoader('/languagekeys/api');
	$translateProvider.preferredLanguage('en');
}]);

//############################################################################################

app.controller('NavBarCtrl', ['$scope', '$location',
	function($scope, $location) {
		$scope.isActive = function (viewLocation) { 
			return viewLocation === $location.path();
		};		
}]);

//############################################################################################

app.controller('LanguagesListCtrl', ['$scope', '$location', '$modal', '$translate', 'Language', 'LanguageCode',
	function($scope, $location, $modal, $translate, Language, LanguageCode) {
		$scope.languages = {};	
		$scope.languageFilterForm = {};
		
		LanguageCode.query({}, function(response) {
			$scope.languageFilterForm.languageCodes = response;
			$scope.languageFilterForm.LanguageCodeId = response[0].Id;
		});	
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;			
		
			Language.query(filters, function(response) {
				$scope.languages = response;
				$scope.pagination = {
					totalItems: ($scope.languages.length > 0) ? $scope.languages[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {
							wildcardsearch: $scope.languageFilterForm.wildcardSearch,
							LanguageCodeId: $scope.languageFilterForm.LanguageCodeId				
						});	
					}
				};
			/*
				$scope.$parent.$on('$translateChangeSuccess', function () {
						$translate('Generic.Button.Previous').then(function (text) {
							$scope.pagination.previousText = text;
						});
				});		
			*/				
			});					
		};
		loadList(1, {
			wildcardsearch: $scope.languageFilterForm.wildcardSearch,
			LanguageCodeId: $scope.languageFilterForm.LanguageCodeId
		});	
		
		$scope.open = function(language) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/languages/edit.html',
				controller: 'LanguagesEditCtrl',
		 		resolve: {
					language: function() { return language; }
				}
			});
		};
		
		$scope.delete = function(language) {
			var modalInstance = $modal.open({
				templateUrl: '/views/languages/delete.html',
				controller: 'LanguagesDeleteCtrl',
				resolve: {
					languages: function() { return $scope.languages; },
					language: function() { return language; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.filter = function() {
			loadList(1, {
				wildcardsearch: $scope.languageFilterForm.wildcardSearch,
				LanguageCodeId: $scope.languageFilterForm.LanguageCodeId				
			});	
		}
}]);

app.controller('LanguagesDeleteCtrl', ['$scope', '$route', '$modalInstance', 'languages', 'language', 'pagination',
	function($scope, $route, $modalInstance, languages, language, pagination) {

	$scope.language = language;

	$scope.delete = function() {		
			language.$delete(
				{id: (language.Id) ? (language.Id) : null},
				function () {
					var index = languages.indexOf(language);
					languages.splice(index, 1);
					pagination.totalItems -= 1;					
					if (languages.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);	

app.controller('LanguagesEditCtrl', ['$scope', '$route', '$modalInstance', 'language', 'Language', 'LanguageCode',
	function($scope, $route, $modalInstance, language, Language, LanguageCode) {
	
	$scope.language = language || new Language({});		
	var backup = angular.copy($scope.language);		
	
	LanguageCode.query({}, function(response) {
		$scope.languageCodes = response;
		if (!$scope.language.LanguageCodeId) {
			$scope.language.LanguageCodeId = response[0].Id;
		}
	});		
  
	$scope.save = function() {
		$scope.language.$save(
			{id: ($scope.language.Id) ? ($scope.language.Id) : null},
			function() {
				if (!$scope.language.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.language);		
		$modalInstance.close();
	};
}]);

//############################################################################################

app.controller('CountriesListCtrl', ['$scope', '$location', '$modal', '$translate', 'Country',
	function($scope, $location, $modal, $translate, Country) {
		$scope.countries = {};	
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;
		
			Country.query(filters, function(response) {
				$scope.countries = response;
				$scope.pagination = {
					totalItems: ($scope.countries.length > 0) ? $scope.countries[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {});	
					}
				};
			/*
				$scope.$parent.$on('$translateChangeSuccess', function () {
						$translate('Generic.Button.Previous').then(function (text) {
							$scope.pagination.previousText = text;
						});
				});		
			*/				
			});					
		};
		loadList(1, {});
		
		$scope.open = function(country) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/countries/edit.html',
				controller: 'CountriesEditCtrl',
		 		resolve: {
					country: function() { return country; }
				}
			});
		};
		
		$scope.delete = function(country) {
			var modalInstance = $modal.open({
				templateUrl: '/views/countries/delete.html',
				controller: 'CountriesDeleteCtrl',
				resolve: {
					countries: function() { return $scope.countries; },
					country: function() { return country; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.filter = function() {
			loadList(1, {});
		}
}]);

app.controller('CountriesEditCtrl', ['$scope', '$route', '$modalInstance', 'country', 'Country', 'LanguageCode',
	function($scope, $route, $modalInstance, country, Country, LanguageCode) {
	
	$scope.country = country || new Country({});		
	var backup = angular.copy($scope.country);
	
	LanguageCode.query({}, function(response) {
		$scope.languageCodes = response;
	});
  
	$scope.save = function() {
		$scope.country.$save(
			{id: ($scope.country.Id) ? ($scope.country.Id) : null},
			function() {
				if (!$scope.country.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.country);		
		$modalInstance.close();
	};
	
	$scope.idInCodeSelection = function(id) {
		return $scope.country.LanguageCodeId.indexOf(id) != -1;
	};
	
	$scope.toggleIdInCodeSelection = function(id) {
		var index = $scope.country.LanguageCodeId.indexOf(id);
		if (index != -1) {
			$scope.country.LanguageCodeId.splice(index, 1);
		} else {
			$scope.country.LanguageCodeId.push(id);	
		}		
	};
}]);

app.controller('CountriesDeleteCtrl', ['$scope', '$route', '$modalInstance', 'countries', 'country', 'pagination',
	function($scope, $route, $modalInstance, countries, country, pagination) {
	
	$scope.country = country;

	$scope.delete = function() {		
			country.$delete(
				{id: (country.Id) ? (country.Id) : null},
				function () {
					var index = countries.indexOf(country);
					countries.splice(index, 1);
					pagination.totalItems -= 1;					
					if (countries.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);

//############################################################################################

app.controller('QuestionsListCtrl', ['$scope', '$location', '$modal', '$translate', 'Question',
	function($scope, $location, $modal, $translate, Question) {
		$scope.questions = {};
		$scope.order = 'OrderNumber';
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;
		
			Question.query(filters, function(response) {
				$scope.questions = response;
				$scope.pagination = {
					totalItems: ($scope.questions.length > 0) ? $scope.questions[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {});	
					}
				};			
			});					
		};
		loadList(1, {});
		
		$scope.open = function(question) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/questions/edit.html',
				controller: 'QuestionsEditCtrl',
		 		resolve: {
					question: function() { return question; }
				}
			});
		};
		
		$scope.delete = function(question) {
			var modalInstance = $modal.open({
				templateUrl: '/views/questions/delete.html',
				controller: 'QuestionsDeleteCtrl',
				resolve: {
					questions: function() { return $scope.questions; },
					question: function() { return question; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.changeOrder = function(question, order) {
			question.OrderNumber += order;
			question.$save(
				{id: question.Id}
			);
		}
		
		$scope.filter = function() {
			loadList(1, {});
		}
}]);

app.controller('QuestionsEditCtrl', ['$scope', '$route', '$modalInstance', 'question', 'Question',
	function($scope, $route, $modalInstance, question, Question) {
	
	$scope.question = question || new Question({});		
	var backup = angular.copy($scope.question);
  
	$scope.save = function() {
		$scope.question.$save(
			{id: ($scope.question.Id) ? ($scope.question.Id) : null},
			function() {
				if (!$scope.question.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.question);		
		$modalInstance.close();
	};
}]);

app.controller('QuestionsDeleteCtrl', ['$scope', '$route', '$modalInstance', 'questions', 'question', 'pagination',
	function($scope, $route, $modalInstance, questions, question, pagination) {
	
	$scope.question = question;

	$scope.delete = function() {		
			question.$delete(
				{id: (question.Id) ? (question.Id) : null},
				function () {
					var index = questions.indexOf(question);
					questions.splice(index, 1);
					pagination.totalItems -= 1;					
					if (questions.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);

//############################################################################################

app.controller('DistrictsListCtrl', ['$scope', '$location', '$modal', '$translate', 'District', 'Country',
	function($scope, $location, $modal, $translate, District, Country) {
		$scope.districts = {};	
		$scope.FilterForm = {};
		
		Country.query({}, function(response) {
			$scope.FilterForm.countries = response;
			$scope.FilterForm.CountryId = response[0].Id;
		});	
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;			
		
			District.query(filters, function(response) {
				$scope.districts = response;
				$scope.pagination = {
					totalItems: ($scope.districts.length > 0) ? $scope.districts[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {
							wildcardsearch: $scope.FilterForm.wildcardSearch,
							CountryId: $scope.FilterForm.CountryId				
						});	
					}
				};
			/*
				$scope.$parent.$on('$translateChangeSuccess', function () {
						$translate('Generic.Button.Previous').then(function (text) {
							$scope.pagination.previousText = text;
						});
				});		
			*/				
			});					
		};
		loadList(1, {
			wildcardsearch: $scope.FilterForm.wildcardSearch,
			CountryId: $scope.FilterForm.CountryId
		});	
		
		$scope.open = function(district) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/districts/edit.html',
				controller: 'DistrictsEditCtrl',
		 		resolve: {
					district: function() { return district; }
				}
			});
		};
		
		$scope.delete = function(district) {
			var modalInstance = $modal.open({
				templateUrl: '/views/districts/delete.html',
				controller: 'DistrictsDeleteCtrl',
				resolve: {
					districts: function() { return $scope.districts; },
					district: function() { return district; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.filter = function() {
			loadList(1, {
				wildcardsearch: $scope.FilterForm.wildcardSearch,
				CountryId: $scope.FilterForm.CountryId				
			});	
		}
}]);

app.controller('DistrictsDeleteCtrl', ['$scope', '$route', '$modalInstance', 'districts', 'district', 'pagination',
	function($scope, $route, $modalInstance, districts, district, pagination) {

	$scope.district = district;

	$scope.delete = function() {		
			district.$delete(
				{id: (district.Id) ? (district.Id) : null},
				function () {
					var index = districts.indexOf(district);
					districts.splice(index, 1);
					pagination.totalItems -= 1;					
					if (districts.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);	

app.controller('DistrictsEditCtrl', ['$scope', '$route', '$modalInstance', 'district', 'District', 'Country',
	function($scope, $route, $modalInstance, district, District, Country) {
	
	$scope.district = district || new District({});
	var backup = angular.copy($scope.district);		
	
	Country.query({}, function(response) {
		$scope.countries = response;
		if (!$scope.district.CountryId) {
			$scope.district.CountryId = response[0].Id;
		}
	});		
  
	$scope.save = function() {
		$scope.district.$save(
			{id: ($scope.district.Id) ? ($scope.district.Id) : null},
			function() {
				if (!$scope.district.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.district);		
		$modalInstance.close();
	};
}]);

//############################################################################################

app.controller('PartiesListCtrl', ['$scope', '$location', '$modal', '$translate', 'Party', 'Country',
	function($scope, $location, $modal, $translate, Party, Country) {
		$scope.parties = {};	
		$scope.FilterForm = {};
		
		Country.query({}, function(response) {
			$scope.FilterForm.countries = response;
			$scope.FilterForm.CountryId = response[0].Id;
		});	
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;			
		
			Party.query(filters, function(response) {
				$scope.parties = response;
				$scope.pagination = {
					totalItems: ($scope.parties.length > 0) ? $scope.parties[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {
							wildcardsearch: $scope.FilterForm.wildcardSearch,
							CountryId: $scope.FilterForm.CountryId				
						});	
					}
				};
			/*
				$scope.$parent.$on('$translateChangeSuccess', function () {
						$translate('Generic.Button.Previous').then(function (text) {
							$scope.pagination.previousText = text;
						});
				});		
			*/				
			});					
		};
		loadList(1, {
			wildcardsearch: $scope.FilterForm.wildcardSearch,
			CountryId: $scope.FilterForm.CountryId
		});	
		
		$scope.open = function(party) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/parties/edit.html',
				controller: 'PartiesEditCtrl',
		 		resolve: {
					party: function() { return party; },
					parties: function() { return $scope.parties; }
				}
			});
		};
		
		$scope.delete = function(party) {
			var modalInstance = $modal.open({
				templateUrl: '/views/parties/delete.html',
				controller: 'PartiesDeleteCtrl',
				resolve: {
					parties: function() { return $scope.parties; },
					party: function() { return party; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.filter = function() {
			loadList(1, {
				wildcardsearch: $scope.FilterForm.wildcardSearch,
				CountryId: $scope.FilterForm.CountryId				
			});	
		}
}]);

app.controller('PartiesDeleteCtrl', ['$scope', '$route', '$modalInstance', 'parties', 'party', 'pagination',
	function($scope, $route, $modalInstance, parties, party, pagination) {

	$scope.party = party;

	$scope.delete = function() {		
			party.$delete(
				{id: (party.Id) ? (party.Id) : null},
				function () {
					var index = parties.indexOf(party);
					parties.splice(index, 1);
					pagination.totalItems -= 1;					
					if (parties.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);	

app.controller('PartiesEditCtrl', ['$scope', '$route', '$modalInstance', 'party', 'parties', 'Party', 'Country',
	function($scope, $route, $modalInstance, party, parties, Party, Country) {
	
	$scope.party = party || new Party({});		
	var backup = angular.copy($scope.party);		
	
	Country.query({}, function(response) {
		$scope.countries = response;
		if (!$scope.party.CountryId) {
			$scope.party.CountryId = response[0].Id;
		}
	});		
  
	$scope.save = function() {
		$scope.party.$save(
			{id: ($scope.party.Id) ? ($scope.party.Id) : null},
			function() {
				if (!$scope.party.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.party);		
		$modalInstance.close();
	};
}]);

//############################################################################################

app.controller('CandidatesListCtrl', ['$scope', '$location', '$modal', '$translate', 'Candidate', 'Country',
	function($scope, $location, $modal, $translate, Candidate, Country) {
		$scope.candidates = {};	
		$scope.FilterForm = {};
		
		Country.query({}, function(response) {
			$scope.FilterForm.countries = response;
			$scope.FilterForm.CountryId = response[0].Id;
		});	
	
		var loadList = function(pageNumber, filters) {
			filters = filters || {};
			filters.offset = (pageNumber - 1) * 20;			
		
			Candidate.query(filters, function(response) {
				$scope.candidates = response;
				$scope.pagination = {
					totalItems: ($scope.candidates.length > 0) ? $scope.candidates[0].TotalCount : 0,
					currentPage: pageNumber,
					itemsPerPage: 20,
					setPage: function(pageNumber) {
						loadList(pageNumber, {
							wildcardsearch: $scope.FilterForm.wildcardSearch,
							CountryId: $scope.FilterForm.CountryId				
						});	
					}
				};
			/*
				$scope.$parent.$on('$translateChangeSuccess', function () {
						$translate('Generic.Button.Previous').then(function (text) {
							$scope.pagination.previousText = text;
						});
				});		
			*/				
			});					
		};
		loadList(1, {
			wildcardsearch: $scope.FilterForm.wildcardSearch,
			CountryId: $scope.FilterForm.CountryId
		});	
		
		$scope.open = function(candidate) {		
			var modalInstance = $modal.open({
				templateUrl: '/views/candidates/edit.html',
				controller: 'CandidatesEditCtrl',
		 		resolve: {
					candidate: function() { return candidate; },
					candidates: function() { return $scope.candidates; }
				}
			});
		};
		
		$scope.delete = function(candidate) {
			var modalInstance = $modal.open({
				templateUrl: '/views/candidates/delete.html',
				controller: 'CandidatesDeleteCtrl',
				resolve: {
					candidates: function() { return $scope.candidates; },
					candidate: function() { return candidate; },
					pagination: function() { return $scope.pagination; }
				}
			});		
		};
		
		$scope.filter = function() {
			loadList(1, {
				wildcardsearch: $scope.FilterForm.wildcardSearch,
				CountryId: $scope.FilterForm.CountryId				
			});	
		}
}]);

app.controller('CandidatesDeleteCtrl', ['$scope', '$route', '$modalInstance', 'candidates', 'candidate', 'pagination',
	function($scope, $route, $modalInstance, candidates, candidate, pagination) {

	$scope.candidate = candidate;

	$scope.delete = function() {		
			candidate.$delete(
				{id: (candidate.Id) ? (candidate.Id) : null},
				function () {
					var index = candidates.indexOf(candidate);
					candidates.splice(index, 1);
					pagination.totalItems -= 1;					
					if (candidates.length === 0 && pagination.currentPage > 1) {
						pagination.setPage(pagination.currentPage -= 1);
					}
					$modalInstance.close();
				},
				function(data) {
					alert(data);
				}
			);
		};

	$scope.cancel = function() {
		$modalInstance.close();
	};
}]);	

app.controller('CandidatesEditCtrl', ['$scope', '$route', '$modalInstance', 'candidate', 'candidates', 'Candidate', 'District', 'Party',
	function($scope, $route, $modalInstance, candidate, candidates, Candidate, District, Party) {
	
	$scope.candidate = candidate || new Candidate({});		
	var backup = angular.copy($scope.candidate);		
	
	District.query({}, function(response) {
		$scope.districts = response;
		if (!$scope.candidate.DistrictId) {
			$scope.candidate.DistrictId = response[0].Id;
		}
	});
	
	Party.query({}, function(response) {
		$scope.parties = response;
		if (!$scope.candidate.PartyId) {
			$scope.candidate.PartyId = response[0].Id;
		}
	});	
	
	$scope.save = function() {
		$scope.candidate.$save(
			{id: ($scope.candidate.Id) ? ($scope.candidate.Id) : null},
			function() {
				if (!$scope.candidate.Id) {
					$route.reload();
				}
				$modalInstance.close();
			},
			function(data) {
				alert(data);
			}
		);
	};

	$scope.cancel = function() {
		angular.copy(backup, $scope.candidate);		
		$modalInstance.close();
	};
}]);
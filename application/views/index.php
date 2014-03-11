<!DOCTYPE html>
<html lang="en" ng-app="beerOMeter">
	<head>
		<title>Beer-o-Meter</title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">		  
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
		<style>
			.nav, .pagination, .carousel, .panel-title a { cursor: pointer; }		
		</style>
	</head>
	<body style="padding-top: 70px">
		<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Beer-o-meter</a>
			</div>	
			<div class="navbar-collapse collapse" ng-controller="NavBarCtrl">
			  <ul class="nav navbar-nav">		
				<li ng-class="{ active: isActive('/parties')}"><a href="#/parties">Parties</a></li>
				<li ng-class="{ active: isActive('/candidates')}"><a href="#/candidates">Candidates</a></li>
				<li ng-class="{ active: isActive('/districts')}"><a href="#/districts">Districts</a></li>
				<li ng-class="{ active: isActive('/questions')}"><a href="#/questions">Questions</a></li>
				<li ng-class="{ active: isActive('/countries')}"><a href="#/countries">Countries</a></li>
				<li ng-class="{ active: isActive('/languages')}"><a ng-href="#/languages">Language keys</a></li>
			</ul>
		</div>
		</div>
		</div>
		<div class="container-fluid" ng-view></div>
		<div butterbar>My loading text...</div>
		
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular-resource.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.14/angular-route.js"></script>
		<script src="/scripts/vendor/angular-translate.min.js"></script>
		<script src="/scripts/vendor/angular-translate-loader-url.min.js"></script>
		<script src="/scripts/vendor/ui-bootstrap-tpls-0.10.0.min.js"></script>
		<script src="/scripts/directives/directives.js"></script>
		<script src="/scripts/services/services.js"></script>
		<script src="/scripts/controllers/controllers.js"></script>
	</body>
</html>
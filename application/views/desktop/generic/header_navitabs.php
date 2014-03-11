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
		<div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">		
			<li><a data-toggle="tab" href="#tab-dashboard" data-link="<?php echo CONTROLLER_MY_PAGE_DASHBOARD; ?>">Dashboard</a></li>				
			<li><a data-toggle="tab" href="#tab-questions" data-link="<?php echo CONTROLLER_QUESTIONS_LISTALL; ?>">Questions</a></li>    				
			<li><a data-toggle="tab" href="#tab-parties" data-link="<?php echo CONTROLLER_PARTIES_LISTALL; ?>">Parties</a></li>
			<li><a data-toggle="tab" href="#tab-candidates" data-link="<?php echo CONTROLLER_CANDIDATES_LISTALL; ?>">Candidates</a></li>
			<li><a data-toggle="tab" href="#tab-districts" data-link="<?php echo CONTROLLER_DISTRICTS_LISTALL; ?>">Districts</a></li>		
			<li><a data-toggle="tab" href="#tab-countries" data-link="<?php echo CONTROLLER_COUNTRIES_LISTALL; ?>">Countries</a></li>
			<li><a data-toggle="tab" href="#tab-language_keys" data-link="<?php echo CONTROLLER_LANGUAGES_LISTALL; ?>">Language keys</a></li>
		</ul>
	</div>
</div>
</div>
<div class="container-fluid" id="maindiv"></div>

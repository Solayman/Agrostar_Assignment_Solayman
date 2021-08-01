<header>
	<label for="check">
		<i class="fa fa-bars" id="sidebar_btn"></i>
	</label>
	<div class="left_area">
		<h3>Agrostar Farm  <span>Limited</span></h3>
	</div>
	<div class="right_area">
		<a class="logout_btn" href="{{ route('logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			<span data-i18n="drpdwn.page-logout">Logout</span>
			<!--<span class="float-right fw-n">&commat;codexlantern</span>-->
		</a>
		<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
			@csrf
		</form>
		
		
	</div>
</header>
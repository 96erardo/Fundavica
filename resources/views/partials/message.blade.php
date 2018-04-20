@if(session('status'))
	<div class="notification is-success">
		<button class="delete"></button>
		{{ session('status') }}
	</div>
@endif
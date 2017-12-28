<div class="modal" id="delete-modal">
	<div class="modal-background delete-button"></div>
	<div class="model-content">
		<div class="modal-card">
    		<div class="hero is-danger">
				<div class="hero-body has-text-centered">
					<h4 class="title is-4">¿ Seguro que desea eliminar esta información ?</h4>
					<p class="subtitle is-4">
						Una vez eliminado, no podrá recuperar esta información
					</p>
				</div>                    
			</div>
			<footer class="modal-card-foot">
				<div class="level">
					<div class="level-left"></div>
					<div class="level-right">
						<a class="button is-success level-item" id="delete-button" href="#">
							<span>Eliminar</span>
							<span class="icon">
								<i class="fa fa-eraser" aria-hidden="true"></i>
							</span>
						</a>
						<a class="button is-danger level-item delete-button" href="{{ url('/') }}">
							<span>Cancelar</span>
							<span class="icon">
								<i class="fa fa-ban" aria-hidden="true"></i>
							</span>
						</a>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<button class="modal-close is-large delete-button" aria-label="close"></button>
</div>
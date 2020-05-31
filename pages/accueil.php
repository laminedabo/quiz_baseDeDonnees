<div class="container col-md-6 col-sm-8 col-xs-12 accueil">
    <div class="row">
        <div>
            <?php
				echo "<a onclick=\"if(!confirm('Vous souhaitez vous déconncter?')){event.preventDefault();}\" href='index.php?statut=logout'><button id='deconnexion'>Déconnexion</button></a>";
			?>
        </div>
    </div>
</div>
<?php
print_r($_SESSION);
?>
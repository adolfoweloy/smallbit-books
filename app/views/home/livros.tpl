<html>
	<div id="main">
	    <div id="content">
		    <div id="form-content" style="width: 50%">
			    <h3>loja de livros - java magazine - {$categoria}</h3>
			    <hr/>
			    
			    <ul>
		        {foreach from=$livros item=livro}
                    <ul>
                        <li><a href="/home/detalhes/{$livro->id_livro}">{$livro->titulo}</a></li>
                    </ul>
		        {/foreach}
		        </ul>
		        
		    </div>
		</div>
	</div>
</html>

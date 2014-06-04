<html>
	<div id="main">
	    <div id="content">
		    <div id="form-content" style="width: 50%">
			    <h3>loja de livros - java magazine</h3>
			    <hr/>
			    
			    <ul>
		        {foreach from=$livros item=livro}
		        	<li>
		        		<a href="/home/livros/{$livro->categoria}">{$livro->categoria}</a>({$livro->quantidade})
		        	</li>
		        {/foreach}
		        </ul>
		        
		    </div>
		</div>
	</div>
</html>

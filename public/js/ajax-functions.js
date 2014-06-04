/** busca tipos de servicos */
function searchTipoServico(request, response) {
	$.ajax({
		type: "POST",
		url: "/tiposervicows/search",
		data: {termo: request.term},
		dataType: 'json',

		success: function(data) {
			if (data.rows.length > 0) {
				response(data.rows);
			}
		},

		error: function() {
			alert('Erro tentando recuperar categorias');
		}
		
	});
}

/** busca unidades federais / estados */
function searchUnidadeFederal(request, response) {
	$.ajax({
		type: "POST",
		url: "/localidade/search",
		data: {term: request.term},
		dataType: 'json',

		success: function(data) {
			if (data.rows.length > 0) {
				response(data.rows);
			}
		},

		error: function() {
			alert('Erro tentando buscar a localidade');
		}
	});
}

function geoAutoComplete( inputId, ufId, cidadeId ) {
	var input = document.getElementById(inputId);
	var autocomplete = new google.maps.places.Autocomplete(input);
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		var place = autocomplete.getPlace();
		
		var i = 0;
		var cidade = null;
		var uf = null;
		
		for (i = 0; i < place.address_components.length; i++) {
			var component = place.address_components[i];
			
			if (cidade == null) {
	    		for (j = 0; j < component.types.length; j++) {
	    			var type = component.types[j];
	    			if (type == 'locality' || type == 'political') {
	    				cidade = component.long_name;
	    				break;
	    			}
	    		}
			}
			
			if (uf == null) {
	    		for (j = 0; j < component.types.length; j++) {
	    			var type = component.types[j];
	    			if (type == 'administrative_area_level_1') {
	    				uf = component.long_name;
	    				break;
	    			}
	    		}
			}
			
			if (cidade != null && uf != null) {
				$('#' + ufId).val(uf);
				$('#' + cidadeId).val(cidade);
				break;
			}
		}
		
	});
}

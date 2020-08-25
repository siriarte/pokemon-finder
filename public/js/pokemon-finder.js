function showResultMsg($msg){
    $("#table_result_title").text($msg);
}

function clearTable(){
    showResultMsg("");
    $("#footer").hide();
    $("#table_result tr").remove();
}

function verifyResponse(data, status){
    if(status != 'success'){
        showResultMsg("Internal error")
        return false;
    }
    if(data.status == '400'){
        showResultMsg(data.error)
        return false;
    }
    if(data.status == '200'){
        return true;
    }
    return false;
}

function showResults(pokemonArray){
    showResultMsg("Resultado de la búsqueda: " +  pokemonArray.length  + " Pokemons");
    const tr = '<tr><th class="th-img"></th><th class="th-name">Nombre</th><th class="th-type">Tipos</th></tr>';
    $("#table_result_head").append(tr);
    pokemonArray.forEach(pokemon => {
        const types = getTypes(pokemon.types);
        const img_src = pokemon.picture ? pokemon.picture : "img/no_image_available.png"; 
        const td_img = "<td class='td-img'><img src='"+ img_src + "'></td>";
        const td_name = "<td class='td-name'><p class='td-name-text'>" + pokemon.name + "</p></td>";
        const td_types = "<td class='td-type'><p class='td-name-text'>" + types + "</p></td>";
        const tr = "<tr>" + td_img + td_name + td_types + "</tr>";
        $("#table_result_body").append(tr);
    });
}

function getTypes(types){
    if(!Array.isArray(types) || types.length == 0){
        return "No posee";
    }

    var typesString = "";
    types.forEach(element => {
        typesString += element.type.name + ', ';
    });

    // Remove last ','
    return typesString.slice(0, -2)
}

function onSearchSuccess(data, status){
    clearTable();
    hidePleaseWait()
    if(!verifyResponse(data, status)){
        return;
    }
    showResults(data.results);
}

function showPleaseWait() {    
    $("#pleaseWaitDialog").modal("show");
}

function hidePleaseWait() {
    $("#pleaseWaitDialog").modal("hide");
}

$(document).ready(function(){
    $("#btn_search").click(function(e){
        const textInput = $("input[name=input_search]").val();
        const url = '/search/' + textInput;
        if(!textInput){
            return;
        }
        e.preventDefault();
        $.get(url, onSearchSuccess);
        showPleaseWait()
    });
});
let list_for_search = [];
async function yousef() {
    
    let api = await fetch(`api_get.php/products.json`);
    
    let Json = await api.json();
    Json.forEach(element => {
        Object_yousef= {name: element['product_name']}
        list_for_search.push(Object_yousef);
    });
    console.log(Json);
}
yousef()

function performSearch(ele) {
    var search_id = 'searchInput';
    var div_id = 'suggestions';
    
if(ele.id == 'searchInput'){
    search_id = 'searchInput';
    div_id = 'suggestions';
}else if(ele.id == 'searchInput_down'){
    search_id = 'searchInput_down';
    div_id = 'suggestions_down';
}
const query = document.getElementById(search_id).value.toLowerCase();
const suggestionsDiv = document.getElementById(div_id);

  suggestionsDiv.innerHTML = '';

  if (query.length === 0) {
      return;
  }

  const filteredData = list_for_search.filter(item => item.name.toLowerCase().includes(query));

  if (filteredData.length > 0) {
      filteredData.forEach(item => {
          const div = document.createElement('div');
          div.textContent = item.name;
          div.className = 'suggestion-item';
          div.onclick = () => selectSuggestion(item.name);
          suggestionsDiv.appendChild(div);
      });
  }
}

function selectSuggestion(suggestion) {
    document.getElementById(search_id).value = suggestion;
  document.getElementById(suggestion).innerHTML = '';
}


// عشان لما تطلع من الاينبوت يحذف الخيارات

document.getElementById('searchInput').addEventListener('focusout', onfocusout);
document.getElementById('searchInput_down').addEventListener('blur', onfocusout_down);

function onfocusout(){
    document.getElementById('suggestions').innerHTML = '';
}
function onfocusout_down(){
      document.getElementById('suggestions_down').innerHTML = '';
}

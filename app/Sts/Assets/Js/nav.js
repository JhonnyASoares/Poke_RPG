const apiUrl = 'http://pokerpg.shop/api/search/';
const searchResults = document.getElementById('search_results');

// Adiciona um evento de clique no documento
/*
document.addEventListener('click', function(event) {
  // Verifica se o clique foi fora da div
  if (!searchResults.contains(event.target)) {
    searchResults.style.display = 'none'; // Esconde a div
  }
});*/
async function search(input) {
    console.log(input);
    let inputValue = input.value.toLowerCase();
    const response = await fetch(apiUrl + inputValue, {
        method: "GET"
    });
    console.log(response);
    const data = await response.json(); // converte a resposta para JSON
    console.log(data);

    if (data.length > 0) {
        let html = '';
        for (let i = 0; i < data.length; i++) {
            let item = data[i];
            html += `
                <a href="/pokemon?name=${item.name}">
                    <div>
                        <img src="${item.front_default}" alt="${item.name}">
                    </div>
                    <span>${item.name}</span>
                </a>
            `;
        }
        searchResults.style.display = 'flex';
        searchResults.innerHTML = html;
    } else {
        searchResults.innerHTML = '';
    }
    if (inputValue.length == 0) {
        searchResults.innerHTML = '';
    }
    

}
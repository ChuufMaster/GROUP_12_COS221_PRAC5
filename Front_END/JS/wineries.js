
  // Function to delete all existing winery cards
  function deleteWineryCards() {
    const wineryContainer = document.querySelector('.row');
    wineryContainer.innerHTML = '';
  }

  // Function to create a new winery card
  function createWineryCard(winery) {
    const wineryContainer = document.querySelector('.row');

    // Create elements for the winery card
    const col = document.createElement('div');
    col.classList.add('col-md-4');

    const card = document.createElement('div');
    card.classList.add('card','mb-4','box-shadow');

    const cardBody = document.createElement('div');
    cardBody.classList.add('card-body','text-center','align-items-center');

    const title = document.createElement('h5');
    title.classList.add('card-title');
    title.textContent = winery.winery_name;

    const text = document.createElement('p');
    text.classList.add('card-text');
    text.innerHTML = `
      Eco-friendly: ${winery.eco_friendly ? 'Yes' : 'No'}<br>
      Operational: ${winery.operational ? 'Yes' : 'No'}<br>
      Offers Tours: ${winery.offers_tours ? 'Yes' : 'No'}<br>
      Owner: ${winery.first_name} ${winery.last_name}
    `;

    const btnGroup = document.createElement('div');
    btnGroup.classList.add('justify-content-between', 'align-items-center');

    const btn = document.createElement('button');
    btn.classList.add('btn', 'btn-sm', 'btn-outline-primary');
    btn.textContent = 'View Their Wines';

    // Add event listener to the button
    btn.addEventListener('click', () => {
        fetchFromWinery(winery.winery_id);
    });

    // Append elements to build the card
    cardBody.appendChild(title);
    cardBody.appendChild(text);
    btnGroup.appendChild(btn);
    cardBody.appendChild(btnGroup);
    card.appendChild(cardBody);
    col.appendChild(card);
    wineryContainer.appendChild(col);
  }

  // Fetch data from the API
  function fetchData() {
    var xhr = new XMLHttpRequest();
    var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    const request_body = {
        "type": "get_by_conditions",
        "table": "wineries",
        "details": "wineries.*, all_users.first_name, all_users.last_name",
        "limit": 30,
        "joins": "JOIN all_users ON wineries.api_key = all_users.api_key",
        "conditions": "*",
        "options": "*"
    };
    var json_request_body = JSON.stringify(request_body);
    xhr.send(json_request_body);
    xhr.onload = function() {
      var data = JSON.parse(xhr.responseText).data;
      
      deleteWineryCards();
      data.forEach(winery => {
      createWineryCard(winery);
    });
    }
  }

  // Call the fetchData function to load data and create winery cards initially
  fetchData();


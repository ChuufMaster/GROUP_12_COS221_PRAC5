    // Function to delete all existing wine cards
    function deleteWineCards() {
        const wineContainer = document.querySelector('.row');
        wineContainer.innerHTML = '';
    }
  
  // Function to create a new wine card
    function createWineCard(wine) {
        const wineContainer = document.querySelector('.row');
    
        // Create elements for the wine card
        const col = document.createElement('div');
        col.classList.add('col-md-4');
    
        const card = document.createElement('div');
        card.classList.add('card', 'mb-4', 'box-shadow');
    
        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body');
    
        const image = document.createElement('img');
        image.classList.add('card-img');
        image.src = wine.image;
        image.alt = wine.designation;
    
        const title = document.createElement('h5');
        title.classList.add('card-title');
        title.textContent = wine.designation + " " + wine.type;
    
        const text = document.createElement('p');
        text.classList.add('card-text');
        text.textContent = wine.description;
    
        const btnGroup = document.createElement('div');
        btnGroup.classList.add('d-flex', 'justify-content-between', 'align-items-center');
    
        const btn = document.createElement('button');
        btn.classList.add('btn', 'btn-sm', 'btn-outline-primary', 'view-details-btn');
        btn.textContent = 'View Details';
        btn.dataset.wineId = wine.id;
    
        const price = document.createElement('small');
        price.classList.add('text-muted');
        price.textContent = 'Price: ' + wine.price;
    
        // Append elements to build the card
        cardBody.appendChild(image);
        cardBody.appendChild(title);
        cardBody.appendChild(text);
        btnGroup.appendChild(btn);
        btnGroup.appendChild(price);
        cardBody.appendChild(btnGroup);
        card.appendChild(cardBody);
        col.appendChild(card);
        wineContainer.appendChild(col);

        btn.addEventListener('click', () => {
            openWineModal(wine);
        });
    }
  
  // Fetch data from the API
  function fetchData() {
    var xhr = new XMLHttpRequest();
    var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    const request_body = {
      "type": "get_by_conditions",
      "table": "wines",
      "limit": 30,
      "details": "*",
      "conditions": {
        "image": "IS NOT NULL"
      },
      "options": "*"
    };
    
    var json_request_body = JSON.stringify(request_body);
    xhr.send(json_request_body);
    xhr.onload = function() {
      var data = JSON.parse(xhr.responseText).data;
  
      deleteWineCards();
      data.forEach(wine => {
        createWineCard(wine);
      });
    }
  }
  
  function fetchFromWinery(winery_id) {
    var xhr = new XMLHttpRequest();
    var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    const request_body = {
      "type": "get_by_conditions",
      "table": "wines",
      "limit": 30,
      "details": "*",
      "conditions": {
        "image": "IS NOT NULL",
        "winery_id": winery_id
      },
      "options": "*"
    };

    var json_request_body = JSON.stringify(request_body);
    xhr.send(json_request_body);
    xhr.onload = function() {
      var data = JSON.parse(xhr.responseText).data;
  
      deleteWineCards();
      data.forEach(wine => {
        createWineCard(wine);
      });
    }
  }

  function openWineModal(wine) {
    const wineName = wine.designation + " " + wine.type;
    const wineDetails = 'Wine details and additional information go here for wine ';
  
    // Replace the following lines with the code to fetch the wine data from the database
    const wineType = wine.type;
    const wineUserRating = (Math.random() * 6).toFixed(1);
    const wineQuality = Math.floor(Math.random() * (101 - 50) + 50);
    const wineAlcoholPercentage = (Math.random() * (15 - 10) + 10).toFixed(1);
    const wineGrapeType = wine.grape_type;
    const wineRatingPercentile = (Math.random() * 100).toFixed(0);
    const winePricePercentile = (Math.random() * 100).toFixed(0);
  
    $('#wineModalLabel').text(wineName);
    $('#wineModal .modal-body p').text(wineDetails);
  
    // Update the table data with the fetched wine data
    $('#wineType').text(wineType);
    $('#wineUserRating').text(wineUserRating);
    $('#wineQuality').text(wineQuality);
    $('#alcoholPercentage').text(wineAlcoholPercentage);
    $('#wineGrapeType').text(wineGrapeType);
    $('#wineRatingPercentile').text(wineRatingPercentile);
    $('#winePricePercentile').text(winePricePercentile);
  
    $('#wineModal').modal('show');

    $('#wineModal .close, #wineModal .modal-footer .btn-secondary').click(function () {
        $('#wineModal').modal('hide');
    });
  }
  // Call the fetchData function to load data and create wine cards initially
  fetchData();



  
  

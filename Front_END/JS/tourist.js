document.getElementById('suggestButton').addEventListener('click', function() {
    var country = document.getElementById('countryInput').value;
    var region = document.getElementById('regionInput').value;
    var province = document.getElementById('provinceInput').value;

    var location = {};

    if (country !== "") {
      location.country = country;
    }

    if (region !== "") {
      location.region = region;
    }

    if (province !== "") {
      location.province = province;
    }

    var data = {
      "type": "suggest",
      "options": {
        "order": "ASC",
        "sort_type": "quality"
      },
      "location": location,
      "limit": 5
    };

    console.log(JSON.stringify(data));
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.status === "Success") {
            displaySuggestedWineries(response.data);
          } else {
            console.log("Error: " + response.message);
          }
        } else {
          console.log("Error: " + xhr.status);
        }
      }
    };

    xhr.send(JSON.stringify(data));
  });

  function displaySuggestedWineries(wineries) {
    var suggestionResult = document.getElementById('suggestionResult');
    suggestionResult.innerHTML = '';

    wineries.forEach(function(winery) {
      var wineryCard = document.createElement('div');
      wineryCard.classList.add('col-md-4');
      wineryCard.innerHTML = `
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">${winery.winery_name}</h5>
            <p class="card-text">Location: ${winery.country} ${winery.province}</p>
            <p class="card-text">Certified?: ${ winery.certified === '1'? 'YES' : 'NO'}</p>
            <p class="card-text">Address: ${ winery.address}</p>
          </div>
        </div>
      `;
      suggestionResult.appendChild(wineryCard);
    });
  }
$(document).ready(function () {
  var data = fetch_wines();
});

function populate_wines(data) {
  var table = "";

  // Generate table rows
  $.each(data.data, function (index, item) {
    table += '<tr class="table-row">';
    table += '<td data-column-name="wine_id">' + item.wine_id + "</td>";
    table += '<td data-column-name="type">' + item.type + "</td>";
    table += '<td data-column-name="grape_type">' + item.grape_type + "</td>";
    table += '<td data-column-name="image">';
    if (item.image !== null) {
      table += '<img src="' + item.image + '" class="wine-image">';
    }
    table += "</td>";
    table +=
      '<td data-column-name="description"><p class="overflow-auto" style="height: 100%">' +
      item.description +
      "</p></td>";
    table += '<td data-column-name="price">' + item.price + "</td>";
    table += '<td data-column-name="quality">' + item.quality + "</td>";
    table += '<td data-column-name="alcohol">' + item.alcohol + "</td>";
    table += '<td data-column-name="designation">' + item.designation + "</td>";
    table += '<td data-column-name="winery_id">' + item.winery_id + "</td>";
    table += '<td data-column-name="location_id">' + item.location_id + "</td>";
    table += '<td data-column-name="btn-type">';
    table += '<div class="btn-group">';
    table += '<button class="btn btn-primary update-btn">Update</button>';
    table += '<button class="btn btn-danger delete-btn">Delete</button>';
    table += "</div>";
    table += "</td>";
    table += "</tr>";
  });
  $("#wine-table tbody").html("");
  $("#wine-table tbody").append(table);
}

function fetch_wines() {
  var xhr = new XMLHttpRequest();
  var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
  xhr.open("POST", url, true);
  const request_body = {
    type: "get_by_conditions",
    table: "wines",
    limit: 10,
    details: "*",
    conditions: "*",
    options: "*",
  };

  var json_request_body = JSON.stringify(request_body);
  xhr.send(json_request_body);
  xhr.onload = function () {
    var data = JSON.parse(xhr.responseText);

    populate_wines(data);
  };
}

$("#wine-table").on("click", ".update-btn", function () {
  handleUpdateButtonClick($(this));
});

function handleUpdateButtonClick(button) {
  var row = $(button).closest("tr");
  var columns = row.find("td");
  var isEditMode = $(button).text().trim().toLowerCase() === "save";

  if (isEditMode) {
    // Save mode: Update column values and convert to JSON
    var rowData = {};
    columns.each(function (index, column) {
      var columnName = $(column).data("column-name");
      var inputValue = $(column).find("input, textarea").val();
      rowData[columnName] = inputValue;
      if (columnName === "description") {
        $(column).html(
          '<td data-column-name="description"><p class="overflow-auto" style="height: 100%">' +
            inputValue +
            "</p></td>"
        );
      } else $(column).text(inputValue);
    });
    console.log(JSON.stringify(rowData));
    var wine_id = rowData.wine_id;
    delete rowData['wine_id'];
    make_request(
      {
        type: "manage",
        options: {
          operation: "UPDATE",
          table: "wines",
        },
        details: {
          table: "wines",
          ID: wine_id,
          data: rowData,
        },
      },
      function (data) {
        console.log(data);
      }
    );
    $(button).removeClass("btn-success").addClass("btn-primary");
    $(button).text("Update");
  } else {
    // Edit mode: Replace column values with input fields
    columns.each(function (index, column) {
      var columnName = $(column).data("column-name");
      if (columnName !== "image" && columnName !== "btn-type") {
        var inputValue = $(column).text().trim();
        if (columnName === "description") {
          $(column).html(
            '<textarea class="form-control">' + inputValue + "</textarea>"
          );
        } else {
          $(column).html(
            '<input type="text" class="form-control" value="' +
              inputValue +
              '">'
          );
        }
      }
    });
    $(button).text("Save");
    $(button).removeClass("btn-primary").addClass("btn-success");
  }
}

function handleFilterChange() {
  var filterValues = {};

  // Iterate over each input filter
  $(".filter")
    .filter(function () {
      return $(this).val().trim() !== ""; // Filter out empty values
    })
    .each(function () {
      var columnName = $(this).attr("id"); // Get the column name from the input ID
      var value = $(this).val().trim(); // Get the input value

      filterValues[columnName] = value; // Add column name and value to the filter values object
    });

  console.log(filterValues); // Output the filter values object
  fetch_wines_filter(filterValues);
}

function fetch_wines_filter(conditions) {
  var xhr = new XMLHttpRequest();
  var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
  xhr.open("POST", url, true);
  const request_body = {
    type: "get_by_conditions",
    table: "wines",
    limit: 10,
    details: "*",
    conditions: conditions,
    options: "*",
    fuzzy: true,
  };

  var json_request_body = JSON.stringify(request_body);
  xhr.send(json_request_body);
  xhr.onload = function () {
    var data = JSON.parse(xhr.responseText);

    populate_wines(data);
  };
}

function make_request(request_body, call_back) {
  console.log(request_body);
  var xhr = new XMLHttpRequest();
  var url = "http://localhost/GROUP_12_COS221_PRAC5/Back_END/API/API.php";
  xhr.open("POST", url, true);

  var json_request_body = JSON.stringify(request_body);
  xhr.send(json_request_body);
  xhr.onload = function () {
    var data = JSON.parse(xhr.responseText);

    call_back(data);
  };
}

$(".filter").on("input", handleFilterChange);

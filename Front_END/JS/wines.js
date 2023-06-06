$(document).ready(function () {
    $('.view-details-btn').click(function () {
        var wineId = $(this).data('wine-id');
        var wineName = 'Wine Name ' + wineId;
        var wineDetails = 'Wine details and additional information go here for wine ' + wineId;

        // Replace the following lines with the code to fetch the wine data from the database
        var wineType = 'Red';
        var wineUserRating = 4.5;
        var wineQuality = 'High';
        var wineAlcoholPercentage = 12.5;
        var wineGrapeType = 'Cabernet Sauvignon';
        var wineRatingPercentile = 85;
        var winePricePercentile = 70;

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
    });

    $('#wineModal .close, #wineModal .modal-footer .btn-secondary').click(function () {
        $('#wineModal').modal('hide');
    });
});

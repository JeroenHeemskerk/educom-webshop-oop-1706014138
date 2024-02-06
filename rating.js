const MAXRATING = 5;
var ratings = Object();
$(document).ready(function() {
    showStarRatings();
    $(".star-container").on('mouseenter', '.star', function () {
        setStars($(this).parent().attr('id'), $(this).attr('data-value'));
    });
    $(".star-container").on('mouseleave', '.star', function () {
        resetStars($(this).parent().attr('id'));
    });
    $(".star-container").on('click', '.star', function () {
        submitRating($(this).parent().attr('id'), $(this).attr('data-value'));
    });
});



// ============================ FUNCTIONS ============================

async function submitRating(productId, newRating) {
    let userId = getUserId();
    getUserId().then((result) => {
        let obj = JSON.parse(result);
        userId = obj.userId;
        if (userId == null) {
            $(".rating-error").text('U moet inloggen om een beoordeling te delen.');
            //add error message telling people to login
        } else {
            $.ajax({
                url: "index.php",
                method: "POST",
                data: { action: 'ajax',
                        function: 'sendRating',
                        userId: userId,
                        productId: productId,
                        rating: newRating },
                success: function() {
                    getRating(productId);
                }
            });
        }
    });
}

function getRating(productId) {
    return $.ajax({
        url: "index.php?action=ajax&function=getRating&productId="+productId,
        method: "GET",
        success: function(result) {
            let obj = JSON.parse(result);
            ratings[productId.toString()] = parseInt(obj.avg_rating);
        }
    });
}

function getAllRatings() {
    return $.ajax({
        url: "index.php?action=ajax&function=getAllRatings",
        method: "GET"
    });
}

function getUserId() {
    return $.ajax({
        url: "index.php?action=ajax&function=getUserId",
        method: "GET"
    });
}

function setStars(id, value) {
    for (let i = 1; i <= MAXRATING; i++) {
        if (i <= value) {
            $('#prod_'+id+'_star_'+i).text('★');
        } else {
            $('#prod_'+id+'_star_'+i).text('☆');
        }
    }
}

function resetStars(id) {
    let rating = ratings[id.toString()];
    setStars(id, rating);
}

function showStarRatings() {
    let searchParams = new URLSearchParams(window.location.search);
    let page = searchParams.get('page');

    switch (page) {
        case 'webshop':
        case 'topfive':
            getAllRatings().then((result)=>{
                let obj = JSON.parse(result);
                addStarsToWebshopPage(obj);
            });
            break;
        case 'detail':
            detailId = searchParams.get('productId');
            getRating(detailId).then((result) => {
                let obj = JSON.parse(result);
                let rating = obj.avg_rating;
                addStarsToProduct(detailId, rating);});
            break;
    }
}

function addStarsToProduct(id, rating) {
    for (let i = 1; i <= MAXRATING; i++) {
        if (i <= rating) {
            $('#'+id).append('<div class="star" data-value="'+i+'" id="prod_'+id+'_star_'+i+'">★</div>');
        } else {
            $('#'+id).append('<div class="star" data-value="'+i+'" id="prod_'+id+'_star_'+i+'">☆</div>');
        }
    }
}

function addStarsToWebshopPage(result) {
    result.forEach(item => {
        let id = item.id;
        let rating = parseInt(item.avg_rating);
        ratings[id.toString()] = rating;
        addStarsToProduct(id, rating);
    });
}
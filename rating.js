const MAXRATING = 5;
var rating;
$(document).ready(function() {
    showStarRatings();
    $(".star-container").on('mouseenter', '.star', function () {
        setStars($(this).attr('data-value'));
    });
    $(".star-container").on('mouseleave', '.star', resetStars);
    $(".star-container").on('click', '.star', function () {
        submitRating($(this).attr('data-value'));
    });
});



function submitRating(newRating) {
    let userId = getUserId();
    if (userId == null) {
        $(".rating-error").text('U moet inloggen om een beoordeling te delen.');
        //add error message telling people to login
    } else {
        let searchParams = new URLSearchParams(window.location.search);
        let productId = searchParams.get('productId');
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
}

function getRating(productId) {
    $.ajax({
        url: "index.php?action=ajax&function=getRating&productId="+productId,
        method: "GET",
        success: function(result) {
            console.log(result);
            let obj = JSON.parse(result);
            rating = parseInt(obj.avg_rating);
        }
    });
}

function getUserId() {
    $.ajax({
        url: "index.php?action=ajax&function=getUserId",
        method: "GET",
        success: function(result) {
            console.log(result);
            let obj = JSON.parse(result);
            return parseInt(obj.userId);
        }
    });
}

function setStars(value) {
    for (let i = 1; i <= MAXRATING; i++) {
        if (i <= value) {
            $('#star_'+i).text('★');
        } else {
            $('#star_'+i).text('☆');
        }
    }
}

function resetStars() {
    setStars(rating);
}

function showStarRatings() {
    let searchParams = new URLSearchParams(window.location.search);
    let page = searchParams.get('page');

    switch (page) {
        case 'webshop':
            break;
        case 'detail':
            let productId = searchParams.get('productId');
            getRating(productId);
            addStarsToPage();
            break;
    }
}

function addStarsToPage() {
    for (let i = 1; i <= MAXRATING; i++) {
        if (i <= rating) {
            $('.star-container').append('<div class="star" data-value="'+i+'" id="star_'+i+'">★</div>');
        } else {
            $('.star-container').append('<div class="star" data-value="'+i+'" id="star_'+i+'">☆</div>');
        }
    }
}
// Load List of all Topics
export function loadTopicList() {
    $("#topic-list").empty();
    $.ajax({
        url: "php/read_place_list_sql.php", 
        method: "POST",
        success: function(response) {
            $("#topic-list").html(response);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred:", error);
        }
    });
}

// Load Msg of Selected Topic
export function loadTopicMessages(place_id) {
    $("#discussion").empty();
    $.ajax({
        url: "php/read_place_detail_sql.php", 
        method: "POST",
        data: { place_id: place_id }, 
        success: function(response) {
            $("#discussion").html(response);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred:", error);
        }
    });

}

// Load Msg of Selected Topic
export function loadReview(place_id) {
    $("#reviewArea").empty();
    $.ajax({
        url: "php/read_review_sql.php", 
        method: "POST",
        data: { place_id: place_id }, 
        success: function(response) {
            $("#reviewArea").html(response);
        },
        error: function(xhr, status, error) {
            console.error("An error occurred:", error);
        }
    });
}
import { loadTopicList, loadTopicMessages , loadReview} from './_interface.js';

$(document).ready(function () {

    /////////////////// Default Setting ///////////////////
    $("#topic-modal").hide();
    $("#reviewFormDiv").hide();
    $("body").removeClass("modal-active");
    loadTopicList();

    // Check for the query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const load_place_id = urlParams.get('loadReview');

    // If the parameter exists, call the function
    if (load_place_id) {
        $("#curr_place_id").text(load_place_id);
        loadTopicMessages(load_place_id);
        loadReview(load_place_id);
    }

    /////////////////// New Topic ///////////////////
    // Show pop-up for adding new topic
    $('#show-modal-btn').on('click', function () {
        $('#topic-modal').show();
    });

    // Close the pop-up without submitting
    $('#close-modal-btn').on('click', function () {
        $('#topic-modal').hide();
    });

    /////////////////// New Review ///////////////////
    // Show pop-up for adding new topic
    $('#show-modal-review-btn').on('click', function () {
        $('#reviewFormDiv').show();
    });

    // Close the pop-up without submitting
    $('#close-modal-review-btn').on('click', function () {
        $('#reviewFormDiv').hide();
    });
        
    $('#reviewForm').on('submit', function() {
        var curr_place_id = $('#curr_place_id').text(); 
        $('#hiddenPlaceValue').val(curr_place_id); 
        loadReview(curr_place_id);
    });

    /////////////////// Mark only Checked Icon ///////////////////
    $("input[name='user-icon']").change(function() {
        $("input[name='user-icon']").siblings("img").removeClass("border-blue-400");
        $("input[name='user-icon']:checked").siblings("img").addClass("border-blue-400");
        $("input[name='user-icon']:checked").siblings("img").addClass("border-4");
    });

    $("input[name='new-user-icon']").change(function() {
        $("input[name='new-user-icon']").siblings("img").removeClass("border-blue-400");
        $("input[name='new-user-icon']:checked").siblings("img").addClass("border-blue-400");
        $("input[name='new-user-icon']:checked").siblings("img").addClass("border-4");
    });
    
    /////////////////// Load Msg of Topic ///////////////////
    $('#topic-list').on('click', 'li', function () {
        const selected_place_id = $(this).attr("place_id");
        const selected_Topic = $(this).attr("currTopic");
        if (selected_place_id) {
            $("#currTopic").text(selected_Topic);
            $("#curr_place_id").text(selected_place_id);
            loadTopicMessages(selected_place_id);
            loadReview(selected_place_id);
        } else {
            console.error("selected_place_id is not defined. Please make sure it is set before this action.");
        }

    });
});

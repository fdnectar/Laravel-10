/**
 *--------------------------
    Global Variables
 *--------------------------
*/


var temporaryMessageId = 0;

const messageForm = $(".message-form"),
      messageInput = $(".message-input"),
      csrf_token = $("meta[name=csrf_token]").attr("content");

const getMessengerId = () => $("meta[name=id]").attr("content");
const setMessengerId = (id) => $("meta[name=id]").attr("content", id);



/**
 *--------------------------
    Reusable functions
 *--------------------------
*/

function enableChatBoxLoader () {
    $(".wsus__message_paceholder").removeClass('d-none')
}

function disableChatBoxLoader () {
    $(".wsus__message_paceholder").addClass('d-none')
}

function imagePreview(input, selector){
    if(input.files && input.files[0]) {
        var render = new FileReader();
        render.onload = function(e) {
            $(selector).attr('src', e.target.result);
        }

        render.readAsDataURL(input.files[0]);
    }
}

//Search User

let searchPage = 1;
let noMoreDataSearch = false;
let searchTempVal = "";
let searchLoading = false;
function searchUser(query) {

    if(query != searchTempVal) {
        searchPage = 1;
        noMoreDataSearch = false;
    }
    searchTempVal = query;

    if(!searchLoading && !noMoreDataSearch) {
        $.ajax({
            method: 'GET',
            url: '/messenger/search',
            data: {query: query, page:searchPage},
            beforeSend: function() {
                searchLoading = true;
                let loader = `
                    <div class="text-center mt-3">
                        <div class="spinner-border text-primary search-loader" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `
                $('.search_user_list_result').append(loader);
            },
            success: function(data) {
                searchLoading = false;
                $('.search_user_list_result').find('.search-loader').remove();
                if(searchPage < 2) {
                    $('.search_user_list_result').html(data.records);
                } else {
                    $('.search_user_list_result').append(data.records);
                }
                noMoreDataSearch = searchPage >= data?.last_page;
                if(!noMoreDataSearch) searchPage += 1;
            },
            error: function(xhr, status, error) {
                searchLoading = false;
                $('.search_user_list_result').find('.search-loader').remove();
            },
        });
    }
}


function actionOnScroll(selector, callback, topScroll = false) {
    $(selector).on('scroll', function () {
        let element = $(this).get(0);
        const condition = topScroll ? element.scrollTop == 0 :
            element.scrollTop + element.clientHeight >= element.scrollHeight;

        if (condition) {
            callback();
        }
    })
}

function debounce(callback, delay) {
    let timerId;
    return function(...args) {
        clearTimeout(timerId);
        timerId = setTimeout(() => {
            callback.apply(this, args);
        }, delay)
    }
}

/**
 *--------------------------
    Fetch User on click and show it in a view
 *--------------------------
*/

function idInfo(id) {
    $.ajax({
        method: 'GET',
        url: '/messenger/id-info',
        data: {id:id},
        beforeSend: function() {
            NProgress.start();
            enableChatBoxLoader();
        },
        success: function(data) {
            $(".messenger-user-details").find("img").attr("src", data.user.avatar);
            $(".messenger-user-details").find("h4").text(data.user.name);

            //sidebar details
            $(".messenger-user-sidebar-details .user_photo").find("img").attr("src", data.user.avatar);
            $(".messenger-user-sidebar-details").find(".user_name").text(data.user.name);
            $(".messenger-user-sidebar-details").find(".user_unique_name").text(data.user.username);
            NProgress.done();
            disableChatBoxLoader();
        },
        error: function(xhr, status, error) {
            disableChatBoxLoader();
        }
    });
}

/**
 *--------------------------
    Send Message
 *--------------------------
*/

function sendMessage() {
    temporaryMessageId += 1;
    let tempId = `temp_${temporaryMessageId}`;
    const inputValue = messageInput.val();
    if(inputValue > 0) {
        const formData = new FormData($(".message-form")[0]);
        console.log(formData);
        // $.ajax({
        //     method: "POST",
        //     url: '',
        //     data: {_token: csrf_token},
        //     success: function(data) {

        //     },
        //     error: function() {

        //     }
        // });
    }
}

/**
 *--------------------------
    On DOM Load
 *--------------------------
*/

$(document).ready(function() {
    $('#select_file').change(function() {
        imagePreview(this, '.profile-image-preview');
    });


    //search action on keyup
    const debouncedSearch = debounce(function() {
        const value = $('.search_user').val();
        searchUser(value);
    }, 500);

    $('.search_user').on('keyup', function() {
        let query = $(this).val();
        if(query.length > 0) {
            debouncedSearch();
        }
    });

    // search pagination
    actionOnScroll(".search_result_pagination", function () {
        let value = $('.search_user').val();
        searchUsers(value);
        // alert('working');
    });

    //click action on messenger list item

    $("body").on("click", ".messenger-list-item", function() {
        const dataId = $(this).attr("data-id");
        setMessengerId(dataId);
        idInfo(dataId);
    });

    //Message form
    $(".message-form").on("submit", function(e) {
        e.preventDefault();
        sendMessage();
    });
});

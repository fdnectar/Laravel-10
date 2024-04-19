/**
 *--------------------------
    Reusable functions
 *--------------------------
*/

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

// function actionOnScroll(selector, callback, topScroll = false) {
//     $(selector).on('scroll', function() {
//         let element = $(this).get(0);
//         const condition = topScroll ? element.scrollTop == 0 : element.scrollTop + element.clientHeight >= element.scrollHeight;
//         if(condition) {
//             callback();
//         }
//     });
// }

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
    })
});

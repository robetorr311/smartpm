var search_vars = {
    searchSchedule: undefined,
    TYPING_WAIT: 600
};

// Action Events

function addSearchEvents() {
    $('.search-box').click(function () {
        $(this).find('input').focus();
    });

    $('.search-box #search').keyup(function () {
        $('.search-box #search').removeClass('active-search');
        $(this).addClass('active-search');
        if (search_vars.searchSchedule) {
            clearTimeout(search_vars.searchSchedule);
        }
        search_vars.searchSchedule = setTimeout(searchRequest, search_vars.TYPING_WAIT);
    });

    $('.search-box #search').focus(function () {
        $(this).keyup();
    });

    $('.search-box #search').focusout(function () {
        $('.search-box .result-loading').removeClass('result-loading');
        $('.search-box .result-available').removeClass('result-available');
    });
}

// Utility Functions

async function searchRequest() {
    const search = $('.search-box #search.active-search').val().trim();
    console.log('search initiated for keyword ' + search);
    if (search.trim() != '') {
        $('.search-box .search-result').addClass('result-loading');
        // call search API
        var [leadsRes, tasksRes, usersRes] = await Promise.all([
            leadsSearch(search),
            tasksSearch(search),
            usersSearch(search)
        ]);
        if (leadsRes !== true && tasksRes !== true && usersRes !== true) {
            $('.search-box .search-result').addClass('result-empty');
            $('.search-box .result-loading').removeClass('result-loading');
            $('.search-box .result-available').removeClass('result-available');
        } else {
            $('.search-box .search-result').addClass('result-available');
            $('.search-box .result-loading').removeClass('result-loading');
        }
    } else {
        $('.search-box .result-loading').removeClass('result-loading');
        $('.search-box .result-available').removeClass('result-available');
    }
}

async function leadsSearch(search) {
    $('.search-box .search-result .leads-search-result').html('');
    try {
        var _res = await fetch('/search/leads', {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "keyword=" + encodeURIComponent(search)
        });
        var res = await _res.json();
        if (res.result && res.result.length) {
            var htmlRes = '<small class="title-result">LEADS</small>';

            res.result.forEach(e => {
                var sub_base_path = '';
                if (e.status === '8') {
                    sub_base_path = 'production-job/';
                } else if (e.status === '9') {
                    sub_base_path = 'completed-job/';
                } else if (e.category === '0') {
                    sub_base_path = 'insurance-job/';
                } else if (e.category === '1') {
                    sub_base_path = 'cash-job/';
                } else if (e.category === '2') {
                    sub_base_path = 'labor-job/';
                } else if (e.category === '3') {
                    sub_base_path = 'financial-job/';
                } else {
                    sub_base_path = '';
                }
                htmlRes += '<a href="/lead/' + sub_base_path + e.id + '" class="result-item">';
                htmlRes += (1600 + parseInt(e.id)) + ' - ' + e.firstname + ' ' + e.lastname + '<br />';
                htmlRes += e.address + '<br />';
                htmlRes += e.city + ', ' + e.state + ' - ' + e.zip + '<br />';
                htmlRes += e.phone1 + ', ' + e.phone2 + '<br />';
                htmlRes += e.email;
                htmlRes += '</a>';
            });

            $('.search-box .search-result .leads-search-result').addClass('result-available');
            $('.search-box .search-result .leads-search-result').html(htmlRes);
            return true;
            // console.log('response', res);
        }
    } catch (err) {
        console.error('error', err);
    }
    return false;
}

async function tasksSearch(search) {
    $('.search-box .search-result .tasks-search-result').html('');
    try {
        var _res = await fetch('/search/tasks', {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "keyword=" + encodeURIComponent(search)
        });
        var res = await _res.json();
        if (res.result && res.result.length) {
            var htmlRes = '<small class="title-result">TASKS</small>';

            res.result.forEach(e => {
                htmlRes += '<a href="/task/' + e.id + '" class="result-item">';
                htmlRes += e.name + '<br />';
                htmlRes += e.assigned_user_fullname;
                htmlRes += '</a>';
            });

            $('.search-box .search-result .tasks-search-result').addClass('result-available');
            $('.search-box .search-result .tasks-search-result').html(htmlRes);
            return true;
            // console.log('response', res);
        }
    } catch (err) {
        console.error('error', err);
    }
    return false;
}

async function usersSearch(search) {
    $('.search-box .search-result .users-search-result').html('');
    try {
        var _res = await fetch('/search/users', {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: "keyword=" + encodeURIComponent(search)
        });
        var res = await _res.json();
        if (res.result && res.result.length) {
            var htmlRes = '<small class="title-result">USERS</small>';

            res.result.forEach(e => {
                htmlRes += '<a href="/user/' + e.id + '" class="result-item">';
                htmlRes += e.first_name + ' ' + e.last_name + ' (@' + e.username + ')<br />';
                htmlRes += e.email_id + '<br />';
                htmlRes += e.office_phone + ', ' + e.home_phone + '<br />';
                htmlRes += e.cell_1 + ', ' + e.cell_2;
                htmlRes += '</a>';
            });

            $('.search-box .search-result .users-search-result').addClass('result-available');
            $('.search-box .search-result .users-search-result').html(htmlRes);
            return true;
            // console.log('response', res);
        }
    } catch (err) {
        console.error('error', err);
    }
    return false;
}
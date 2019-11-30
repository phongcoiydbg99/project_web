function searchTable(name,url)
    {
        $.ajax({
            url: baseUrl + url,
            type: 'post',
            data: {
                name : name
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.content_table').html(res);
            },
            error: function () {

            }
        })    
    }
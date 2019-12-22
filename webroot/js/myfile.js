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
function list(event,index,id)
    {
        check = false;
        $('#subjects'+id).val('');
        $( ".auto" ).each(function(index,e) {
            if ($(event).text() == $(e).val())
            {
                alert('Môn đăng ký của bạn bị trùng');
                check = true;
            }
        });
        if (!check){
        $('#subjects'+id).attr('name','subjects['+index+']');
        $('#subjects'+id).val($(event).text());
        }
        $('.autocomplete'+id).hide(0);

    }
function listTest(event,index,id)
    {
        check = false;
        var name = '';
        var t = 0;
        var room = '';
        var sub = '';
        var n = Math.floor(id/2);
        if (id%2 == 0) {
            name = 'testRooms';
            t = id + 1;
            room = $(event).text();
            sub = $('#tests'+t).val();
        }
        else {
            name = 'subjects';
            t = id - 1;
            room = $('#tests'+t).val();
            sub = $(event).text();
        } 
        $('#tests'+id).val('');
        
        var i = 0;
        $( ".auto" ).each(function(index,e) {
            if (i != id&& i!= t && i%2 == 0)
            {
                var j = i+1;
                if($('#tests'+i).val() == room || $('#tests'+j).val() == sub && room != '' && sub != '')
                {
                    alert('Ca đăng ký của bạn bị trùng');
                    check = true;
                }
            }
            i++;
        });
        $('#tests'+id).val('');
        if (!check){
        $('#tests'+id).attr('name',name+'['+n+']['+index+']');
        $('#tests'+id).val($(event).text());
        }
        $('.autocomplete'+id).hide(0);
    }
function listTestByTime(event,index,id,time_id)
    {
        check = false;
        var name = '';
        var t = 0;
        var room = '';
        var sub = '';
        var n = time_id;
        if (id%2 == 0) {
            name = 'testRooms';
        }
        else {
            name = 'subjects';
        } 
        $('#tests'+id).val('');
        if (!check){
        $('#tests'+id).attr('name',name+'['+n+']['+index+']');
        $('#tests'+id).val($(event).text());
        }
        $('.autocomplete'+id).hide(0);
    }
function addSubjects()
    {
        id++;
        $.ajax({
                url: baseUrl + 'admin/users/addSubjects',
                type: 'post',
                data: {
                    id :id,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'html',
                success: function (res) {
                    $('.add_content').append(res);
                },
                error: function () {

                }
            })    
    }
function autoclick(i)
    {

        $('.autocomplete'+i).slideDown(0); 
    }
function autoComplete(i,name,url)
    {
        $.ajax({
            url: baseUrl + url,
            type: 'post',
            data: {
                name : name,
                id : i
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.autocomplete'+i).html(res);
            },
            error: function () {

            }
        })    
    }
    
function deleteTestByTime(id)
    {
         $(".test_content"+id).remove();
    }
function deleteTests(id,subject_id)
    {
        $(".subject_content"+id).remove();
        if(typeof subject_id !== 'undefined')
        {
            $.ajax({
            url: baseUrl + 'admin/users/deleteTests',
            type: 'post',
            data: {
                id : subject_id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (res) {
                $('.add_content').append(res);
            },
            error: function () {

            }
        })       
        }
        
    }
function deleteTest(id)
    {
        $(".subject_content"+id).remove();
    }
    

function exportNote(){
    var css = (
     '<style>' +
     '@page print_area{size: 21cm 29.7cm;mso-page-orientation: landscape;}' +
     'div.print_area {page: print_area;}' +
     '</style>'
   );
   var header = "<html xmlns:o='urn:schemas-microsoft-com:office:office' "+
            "xmlns:w='urn:schemas-microsoft-com:office:word' "+
            "xmlns='http://www.w3.org/TR/REC-html40'>"+
            "<head><meta charset='utf-8'><title>Export HTML to Word Document with JavaScript</title>"+css+"</head><body>";
   var footer = "</body></html>";
   var sourceHTML = header+document.getElementById("print_area").innerHTML+footer;
   
   var source = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(sourceHTML);
   var fileDownload = document.createElement("a");
   document.body.appendChild(fileDownload);
   fileDownload.href = source;
   fileDownload.download = 'Ket_qua_dang_ki.doc';
   fileDownload.click();
   document.body.removeChild(fileDownload);
}
function printTest()
    {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById('print_area').innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }

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
                if($('#tests'+i).val() == room && $('#tests'+j).val() == sub && room != '' && sub != '')
                {
                    alert('Ca đăng ký của bạn bị trùng');
                    check = true;
                }
                if ($('#tests'+i).val() == room && room != '')
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
    
function selectTestday(check_name,subject_id){
        var check_day = check_name.value;
        console.log(check_day);
    $.ajax({
        url: baseUrl + '/subjects/checkTestday',
        type: 'post',
        data: {
            check_name: check_name.value,
            subject_id: subject_id
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        dataType: 'html',
        success: function (res) {
            $('.content_subject'+subject_id).html(res); 
        },
        error: function () {

        }
    })    
    }
    function selectTesttime(check_name,subject_id){
        console.log($('#test_day'+subject_id).val());
        var chech_day = $('#test_day'+subject_id).val();
    $.ajax({
        url: baseUrl + '/subjects/checkTesttime',
        type: 'post',
        data: {
            check_day: chech_day,
            check_name: check_name.value,
            subject_id: subject_id
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        dataType: 'html',
        success: function (res) {
            $('#test_time_'+subject_id).html(res);
            console.log($('#test_time_'+subject_id).val());
            var id = $('#test_time_'+subject_id).val();
            $.ajax({
                url: baseUrl + '/subjects/checkTest',
                type: 'post',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'html',
                success: function (ress) {
                    $('.test'+subject_id).html(ress);
                },
                error: function () {

                }
            })    
        },
        error: function () {

        }
    })    
    }
        
    function selectTest(check_test,subject_id)
    {
        var id = $(check_test).val();
        $.ajax({
            url: baseUrl + '/subjects/checkTest',
            type: 'post',
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            dataType: 'html',
            success: function (ress) {
                $('.test'+subject_id).html(ress);
            },
            error: function () {

            }
        })    
    }


    function testCheckBox(check,subject_id,test_room_id,id) {
        if ($(check).is(':checked'))
        {
            var subject_code = $(check).parent().parent().find('.subject_code').text();
            var test_day = $(check).parent().parent().find('.test_day').text();
            var test_time = $(check).parent().parent().find('.test_time').text();
            arrCheck.push([subject_code,test_day,test_time.slice(0,5),test_time.slice(-5)]);
            console.log(arrCheck);
                $( ".checkBox" ).each(function(index) {
                    var check_code = $(this).parent().parent().find('.subject_code').text();
                    var check_day = $(this).parent().parent().find('.test_day').text();
                    var check_time = $(this).parent().parent().find('.test_time').text();
                    var start_time = check_time.slice(0,5);
                    var last_time = check_time.slice(-5);
                    if ( subject_code == check_code)
                    {
                        $(this).prop('disabled',true);
                    }
                    else {
                        for (var i =0 ; i < arrCheck.length;i++)
                        {
                            if (check_day == arrCheck[i][1])
                            {
                                if ((start_time >= arrCheck[i][2]&& start_time <= arrCheck[i][3])||(last_time >= arrCheck[i][2]&& last_time <= arrCheck[i][3]))
                                    $(this).prop('disabled',true);
                            }
                        }
                    }
                    // $(check).prop('disabled',false);
                });
            $.ajax({
                url: baseUrl + '/subjects/checkBox',
                type: 'post',
                data: {
                    subject_id: subject_id,
                    test_room_id: test_room_id,
                    id : id
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: 'html',
                success: function (res) {
                    $('.check_content').append(res);
                },
                error: function () {

                }
            })
        }
    }
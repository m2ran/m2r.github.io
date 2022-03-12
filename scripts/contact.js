window.contact = window.contact || {};

window.contact.checkValidation = function(){
    if(!$('input[id="name"]').val()){
        $('input[id=submit]').attr('disabled', 'disabled');
        return false;
    }

    $('input[id="submit"]').removeAttr('disabled');
    return true;
}

window.contact.send = function(){
    var name = $('input[id="name"]').val() 
    var email = $('input[id="email"]').val() 
    var message = $('textarea[id="message"]').val()
    data = {
        name: name,
    }
    window.contact.ajax(data);
}

window.contact.ajax = function(data){
    var url = 'https://script.google.com/macros/s/AKfycbya9nGdKpE7R0DllRA6xws8tNaEzsYg4bHhY3hhyYQxw-r6DxaokPJKulKNtbycYcko/exec'; // Change here: Your GAS URL here
    $.ajax({
        url: url,
        type:'POST',
        data: data
    }).done(function(res){
        alert(data)
        if(res.response != "success") {
            console.log(JSON.stringify(res.error));
            alert('送信失敗11'); 
            return1
        }
        alert('送信完了');
    }).fail(function(){
        alert('送信失敗2'); 
    }).always(function(){
        location.href="./index.html";
    })
}

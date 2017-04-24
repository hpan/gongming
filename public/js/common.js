/**
 * Created by Admin on 2017/4/19 0019.
 */
$("#iptImage").on('change', function(){
    //alert("in..");
    console.log("2");
    console.log(this.files);
    //if(typeof(FileReader) != "undefined")
    //{
    //    var image_holder = $("#image-holder");
    //    //image_holder.empty();
    //    var reader = new FileReader();
    //    reader.onload = function(e){
    //        $("<img />", {"src": e.target.result,
    //        "class" : "cover_small"}).appendTo(image_holder);
    //    };
    //    image_holder.show();
    //    reader.readAsDataURL($(this)[0].files[0]);
    //}else{
    //    alert("浏览器不支持fileReader");
    //}
    var formData = new FormData();
    formData.append('file', $('#iptImage')[0].files[0]);
    $.ajaxSetup({
        headers: {
            'X-XSRF-TOKEN': $.cookie('XSRF-TOKEN')
        }
    });

    $.ajax({
        url: '/file/upload',
        type: 'POST',
        cache: false,
        data: formData,
        processData: false,
        contentType: false
    }).done(function(res) {})
        .fail(function(res) {});
})

window.onload = function(){
    var input = document.getElementById("file_input");
    var result,div;

    if(typeof FileReader==='undefined'){
        result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
        input.setAttribute('disabled','disabled');
    }else{
        input.addEventListener('change',readFile,false);
    }

    function readFile(){
        console.log("fileLength=" + this.files.length);
        console.log(this.files);
        for(var i=0;i<this.files.length;i++){
            if (!input['value'].match(/.jpg|.gif|.png|.bmp/i)){　　//判断上传文件格式
                return alert("上传的图片格式不正确，请重新选择")
            }
            var reader = new FileReader();
            reader.readAsDataURL(this.files[i]);
            reader.onload = function(e){
                    result = '<div id="result"><img src="'+this.result+'" alt=""/></div>';
                    div = document.createElement('div');
                    div.innerHTML = result;
                    document.getElementById('body').appendChild(div); 　　//插入dom树
                 }
            }
        }
}

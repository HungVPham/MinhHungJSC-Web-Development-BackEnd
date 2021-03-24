$(document).ready(function(){
    // Check Admin current pwd is correct or not.
    $("#current_pwd").keyup(function(){
        var current_pwd = $('#current_pwd').val(); 
        // alert(current_pwd); 
        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp=="false"){
                    $('#checkCurrentPwd').html("<font color=#cb1c22>Mật Khẩu Hiện Tại Sai</font>");
                }else if(resp=="true"){
                    $('#checkCurrentPwd').html("<font color=#333>Mật Khẩu Hiện Tại Đúng</font>");
                }
            },error:function(){
                alert("Error");
            }
        });
    });

    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        $.ajax({
            type:'post',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>chưa hoạt động</a>");
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<a class='updateSectionStatus' href='javascript:void(0)'>đang hoạt động</a>");
                }
            },error:function(){
                alert("Error");
            }
        })
    });

    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        $.ajax({
            type:'post',
            url:'/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>chưa hoạt động</a>");
                }else if(resp['status']==1){
                    $("#category-"+category_id).html("<a class='updateCategoryStatus' href='javascript:void(0)'>đang hoạt động</a>");
                }
            },error:function(){
                alert("Error");
            }
        })
    });
});
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

    // Update Section Status
    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr("section_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#228B22',
            cancelButtonColor: '#cb1c22',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                type:'post',
                url:'/admin/update-section-status',
                data:{status:status,section_id:section_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#section-"+section_id).html("<a class='updateSectionStatus' style='color: #cb1c22;' href='javascript:void(0)'>chưa hoạt động</a>");
                    }else if(resp['status']==1){
                        $("#section-"+section_id).html("<a class='updateSectionStatus' style='color: #228b22;' href='javascript:void(0)'>đang hoạt động</a>");
                        }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Update Category Status 
    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr("category_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#228B22',
            cancelButtonColor: '#cb1c22',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                type:'post',
                url:'/admin/update-category-status',
                data:{status:status,category_id:category_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#category-"+category_id).html("<a class='updateCategoryStatus' style='color: #cb1c22;' href='javascript:void(0)'>chưa hoạt động</a>");
                    }else if(resp['status']==1){
                        $("#category-"+category_id).html("<a class='updateCategoryStatus' style='color: #228b22;' href='javascript:void(0)'>đang hoạt động</a>");
                        }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Append Categories Level 
    $('#section_id').change(function(){
        var section_id = $(this).val();
        $.ajax({
            type:'post',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp);
            },error:function(){
                alert("Error");
            }
        });
    });

    // Confirm Deletion of Record
    // $(".confirmDelete").click(function(){
    //     var name = $(this).attr("name");
    //     if(confirm("Xác nhận xóa "+name+"?")){
    //         return true; 
    //     }
    //     return false;
    // });

    // Confirm Deletion of Record with SweetAlert2
    $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn sẽ không thay đổi được sau khi xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#228B22',
            cancelButtonColor: '#cb1c22',
            confirmButtonText: 'Xóa!',
            cancelButtonText: 'Không xóa.'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href="/admin/delete-"+record+"/"+recordid;
            }
          });
    });

    // Update Product Status 
    $(".updateProductStatus").click(function(){
        var status = $(this).text();
        var product_id = $(this).attr("product_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#228B22',
            cancelButtonColor: '#cb1c22',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:'post',
                    url:'/admin/update-product-status',
                    data:{status:status,product_id:product_id},
                    success:function(resp){
                        if(resp['status']==0){
                            $("#product-"+product_id).html("<a class='updateProductStatus' style='color: #cb1c22;' href='javascript:void(0)'>chưa hoạt động</a>");
                        }else if(resp['status']==1){
                            $("#product-"+product_id).html("<a class='updateProductStatus' style='color: #228b22;' href='javascript:void(0)'>đang hoạt động</a>");
                        }
                        },error:function(){
                            alert("Error");
                        }
                    })
                }
          });
    });
});
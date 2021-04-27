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
    $(document).on("click", ".updateSectionStatus", function(){
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
    $(document).on("click", ".updateCategoryStatus", function(){
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
    $(document).on("click", ".updateProductStatus", function(){
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

    // Product Attributes Add/Remove Script for CONSTRUCTION TOOLS
    var maxField = 10; //Input fields increment limitation
    var addButton1 = $('.add_button1'); //Add button selector
    var wrapper1 = $('.field_wrapper1'); //Input field wrapper
    var fieldHTML1 = '<div style="margin-top: 10px;"><input placeholder="nguồn điện [V]" style="width: 125px;" type="number" min="0" step="1" name="voltage[]"/>&nbsp;<input placeholder="công suất [W]" style="width: 125px;" type="number" min="0" step="1" name="power[]"/>&nbsp;<input required placeholder="mã SKU" style="width: 100px;" type="text" name="sku[]"/>&nbsp;<input required style="width: 100px;" type="number" min="0" step="1" placeholder="giá bán" name="price[]"/>&nbsp;<input placeholder="tồn kho" style="width: 100px;" type="number" min="0" step="1" required name="stock[]"/><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button1">&nbsp;&nbsp;<i class="fas fa-trash"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton1).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper1).append(fieldHTML1); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper1).on('click', '.remove_button1', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

     // Product Attributes Add/Remove Script for HYDRAULIC HOSES
     var maxField = 10; //Input fields increment limitation
     var addButton2 = $('.add_button2'); //Add button selector
     var wrapper2 = $('.field_wrapper2'); //Input field wrapper
     var fieldHTML2 = '<div style="margin-top: 10px;"><input placeholder="đường kính" style="width: 100px;" type="text" name="diameter[]"/>&nbsp;<input required placeholder="mã SKU" style="width: 100px;" type="text" name="sku[]"/>&nbsp;<input required placeholder="giá bán" style="width: 100px;" type="number" min="0" step="1" name="price[]"/>&nbsp;<input placeholder="tồn kho" style="width: 100px;" type="number" min="0" step="1" required name="stock[]"/><div style="width: 100%; margin-top: 10px;"><label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_embossed">In nổi: Có/Không</label><input id="hhose_spflex_embossed"  name="hhose_spflex_embossed[]" type="checkbox" name="hhose_spflex_embossed[]"/></div><div style="width: 100%;"><label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_smoothtexture">Da Trơn: Có/Không</label><input id="hhose_spflex_smoothtexture"  name="hhose_spflex_smoothtexture[]" type="checkbox" name="hhose_spflex_smoothtexture[]"/></div><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button2"><i class="fas fa-trash"></i></a></div>'; //New input field html 
     var x = 1; //Initial field counter is 1
     
     //Once add button is clicked
     $(addButton2).click(function(){
         //Check maximum number of input fields
         if(x < maxField){ 
             x++; //Increment field counter
             $(wrapper2).append(fieldHTML2); //Add field html
         }
     });
     
     //Once remove button is clicked
     $(wrapper2).on('click', '.remove_button2', function(e){
         e.preventDefault();
         $(this).parent('div').remove(); //Remove field html
         x--; //Decrement field counter
     });

    // Product Attributes Add/Remove Script for HYDRAULIC PUMPS
    var maxField = 10; //Input fields increment limitation
    var addButton3 = $('.add_button3'); //Add button selector
    var wrapper3 = $('.field_wrapper3'); //Input field wrapper
    var fieldHTML3 = '<div style="margin-top: 10px;"><input placeholder="nguồn điện [V]" style="width: 125px; margin-top: 5px;" type="number" min="0" step="1" name="voltage[]"/>&nbsp;<input placeholder="công suất [W]" style="width: 125px; margin-top: 5px;" type="number" min="0" step="1" name="power[]"/>&nbsp;<input id="maxflow"  name="maxflow[]" type="number" min="0" step="1" name="maxflow[]" placeholder="lưu lượng [m³/h]" style="width: 135px; margin-top: 5px;"/>&nbsp;<input placeholder="đẩy cao [m]" style="width: 100px; margin-top: 5px;" type="number" min="0" step="1" name="vertical[]"/>&nbsp;<input placeholder="họng hút [mm]" style="width: 125px; margin-top: 5px;" type="number" min="0" step="1" name="indiameter[]"/>&nbsp;<input placeholder="họng xả [mm]" style="width: 125px; margin-top: 5px;" type="number" min="0" step="1" name="oudiameter[]"/>&nbsp;<input required placeholder="mã SKU" style="width: 100px; margin-top: 5px;" type="text" name="sku[]"/>&nbsp;<input required placeholder="giá bán" style="width: 100px; margin-top: 5px;" type="number" min="0" step="1" name="price[]"/>&nbsp;<input placeholder="tồn kho" style="width: 100px; margin-top: 5px;" type="number" min="0" step="1" required name="stock[]"/><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button3">&nbsp;&nbsp;<i class="fas fa-trash"></i></a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton3).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper3).append(fieldHTML3); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper3).on('click', '.remove_button3', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
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
                    $('#checkCurrentPwd').html("<span style='color: var(--Delete-Red);'>&nbsp;mật khẩu hiện tại sai</span>");
                }else if(resp=="true"){
                    $('#checkCurrentPwd').html("<span style='color: var(--Positive-Green);'>&nbsp;mật khẩu hiện tại đúng</span>");
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
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-section-status',
                data:{status:status,section_id:section_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#section-"+section_id).html("<a class='updateSectionStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#section-"+section_id).html("<a class='updateSectionStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

      // Update Brand Status
    $(document).on("click", ".updateBrandStatus", function(){
        var status = $(this).text();
        var brand_id = $(this).attr("brand_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-brand-status',
                data:{status:status,brand_id:brand_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#brand-"+brand_id).html("<a class='updateBrandStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#brand-"+brand_id).html("<a class='updateBrandStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Update Cms Pages Status
    $(document).on("click", ".updateCmsPageStatus", function(){
        var status = $(this).text();
        var page_id = $(this).attr("page_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-cms-page-status',
                data:{status:status,page_id:page_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#page-"+page_id).html("<a class='updateCmsPageStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#page-"+page_id).html("<a class='updateCmsPageStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Update About Pages Status
    $(document).on("click", ".updateAboutPageStatus", function(){
        var status = $(this).text();
        var page_id = $(this).attr("page_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-about-page-status',
                data:{status:status,page_id:page_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#page-"+page_id).html("<a class='updateAboutPageStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#page-"+page_id).html("<a class='updateAboutPageStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Update Catalogue Pages Status
    $(document).on("click", ".updateCataloguePageStatus", function(){
        var status = $(this).text();
        var page_id = $(this).attr("page_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-catalogue-page-status',
                data:{status:status,page_id:page_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#page-"+page_id).html("<a class='updateCataloguePageStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#page-"+page_id).html("<a class='updateCataloguePageStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

    // Update Banner Status
    $(document).on("click", ".updateBannerStatus", function(){
        var status = $(this).text();
        var banner_id = $(this).attr("banner_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-banner-status',
                data:{status:status,banner_id:banner_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#banner-"+banner_id).html("<a class='updateBannerStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#banner-"+banner_id).html("<a class='updateBannerStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
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
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-category-status',
                data:{status:status,category_id:category_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#category-"+category_id).html("<a class='updateCategoryStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#category-"+category_id).html("<a class='updateCategoryStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
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
        confirmButtonColor: 'var(--Positive-Green)',
        cancelButtonColor: 'var(--Delete-Red)',
        confirmButtonText: 'Thay đổi!',
        cancelButtonText: 'Không thay đổi.'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-product-status',
                data:{status:status,product_id:product_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#product-"+product_id).html("<a class='updateProductStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#product-"+product_id).html("<a class='updateProductStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                    }
                    },error:function(){
                        alert("Error");
                    }
                })
            }
        });
    });

        
     // Update Catalogue Pages Status
     $(document).on("click", ".updateCouponStatus", function(){
        var status = $(this).text();
        var coupon_id = $(this).attr("coupon_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/admin/update-coupon-status',
                data:{status:status,coupon_id:coupon_id},
                success:function(resp){
                    if(resp['status']==0){
                        $("#coupon-"+coupon_id).html("<a class='updateCouponStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                    }else if(resp['status']==1){
                        $("#coupon-"+coupon_id).html("<a class='updateCouponStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
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

    // Confirm Deletion of Record with SweetAlert2
    $(document).on("click", ".confirmDelete", function(){
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: 'Xác nhận xóa?',
            text: "Bạn sẽ không thay đổi được sau khi xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Xóa!',
            cancelButtonText: 'Không xóa.'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href="/admin/delete-"+record+"/"+recordid;
            }
          });
    });
    
    // Update Maxpro Attributes Status 
    $(document).on("click", ".updateMaxproAttributesStatus", function(){
        var status = $(this).text();
        var MaxproAttributes_id = $(this).attr("MaxproAttributes_id");
        Swal.fire({
            title: 'Xác nhận thay đổi trạng thái?',
            text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: 'var(--Positive-Green)',
            cancelButtonColor: 'var(--Delete-Red)',
            confirmButtonText: 'Thay đổi!',
            cancelButtonText: 'Không thay đổi.'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:'post',
                    url:'/admin/update-maxproattributes-status',
                    data:{status:status,MaxproAttributes_id:MaxproAttributes_id},
                    success:function(resp){
                        if(resp['status']==0){
                            $("#MaxproAttributes-"+MaxproAttributes_id).html("<a class='updateMaxproAttributesStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                        }else if(resp['status']==1){
                            $("#MaxproAttributes-"+MaxproAttributes_id).html("<a class='updateMaxproAttributesStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                        }
                        },error:function(){
                            alert("Error");
                        }
                    })
                }
            });
        });

        // Update Hhose Attributes Status 
        $(document).on("click", ".updateHhoseAttributesStatus", function(){
            var status = $(this).text();
            var HhoseAttributes_id = $(this).attr("HhoseAttributes_id");
            Swal.fire({
                title: 'Xác nhận thay đổi trạng thái?',
                text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'var(--Positive-Green)',
                cancelButtonColor: 'var(--Delete-Red)',
                confirmButtonText: 'Thay đổi!',
                cancelButtonText: 'Không thay đổi.'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url:'/admin/update-hhoseattributes-status',
                        data:{status:status,HhoseAttributes_id:HhoseAttributes_id},
                        success:function(resp){
                            if(resp['status']==0){
                                $("#HhoseAttributes-"+HhoseAttributes_id).html("<a class='updateHhoseAttributesStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                            }else if(resp['status']==1){
                                $("#HhoseAttributes-"+HhoseAttributes_id).html("<a class='updateHhoseAttributesStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                            }
                            },error:function(){
                                alert("Error");
                            }
                        })
                    }
                });
            });

        // Update Shimge Attributes Status 
        $(document).on("click", ".updateShimgeAttributesStatus", function(){
            var status = $(this).text();
            var ShimgeAttributes_id = $(this).attr("ShimgeAttributes_id");
            Swal.fire({
                title: 'Xác nhận thay đổi trạng thái?',
                text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'var(--Positive-Green)',
                cancelButtonColor: 'var(--Delete-Red)',
                confirmButtonText: 'Thay đổi!',
                cancelButtonText: 'Không thay đổi.'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url:'/admin/update-shimgeattributes-status',
                        data:{status:status,ShimgeAttributes_id:ShimgeAttributes_id},
                        success:function(resp){
                            if(resp['status']==0){
                                $("#ShimgeAttributes-"+ShimgeAttributes_id).html("<a class='updateShimgeAttributesStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                            }else if(resp['status']==1){
                                $("#ShimgeAttributes-"+ShimgeAttributes_id).html("<a class='updateShimgeAttributesStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
                            }
                            },error:function(){
                                alert("Error");
                            }
                        })
                    }
                });
            });

            // Update Image Status 
        $(document).on("click", ".updateImageStatus", function(){
            var status = $(this).text();
            var Image_id = $(this).attr("Image_id");
            Swal.fire({
                title: 'Xác nhận thay đổi trạng thái?',
                text: "Thay đổi trạng thái dữ liệu sẽ ảnh hưởng tới website!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: 'var(--Positive-Green)',
                cancelButtonColor: 'var(--Delete-Red)',
                confirmButtonText: 'Thay đổi!',
                cancelButtonText: 'Không thay đổi.'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:'post',
                        url:'/admin/update-image-status',
                        data:{status:status,Image_id:Image_id},
                        success:function(resp){
                            if(resp['status']==0){
                                $("#Image-"+Image_id).html("<a class='updateImageStatus' style='color: var(--Delete-Red);' href='javascript:void(0)'><i id='active' style='color: var(--Delete-Red); font-size: 1.05rem;' class='fas fa-toggle-off' aria-hidden='true'> chưa hoạt động</i></a>");
                            }else if(resp['status']==1){
                                $("#Image-"+Image_id).html("<a class='updateImageStatus' style='color: var(--Positive-Green);' href='javascript:void(0)'><i id='inactive' style='color: var(--Positive-Green); font-size: 1.05rem;' class='fas fa-toggle-on' aria-hidden='true'> đang hoạt động</i></a>");
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
    var fieldHTML1 = '<div style="margin-top: 10px;"><input placeholder="nguồn điện [V]" style="width: 125px;" type="number" min="0" name="voltage[]"/>&nbsp;<input placeholder="công suất [W]" style="width: 125px;" type="number" min="0" name="power[]"/>&nbsp;<input required placeholder="mã SKU" style="width: 100px;" type="text" name="sku[]"/>&nbsp;<input required style="width: 100px;" type="number" min="0" placeholder="giá bán" name="price[]"/>&nbsp;<input placeholder="tồn kho" style="width: 100px;" type="number" min="0" required name="stock[]"/><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button1">&nbsp;&nbsp;<i class="fas fa-trash"></i></a></div>'; //New input field html 
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
     var fieldHTML2 = '<div style="margin-top: 10px;"><input id="diameter[]" name="diameter[]" type="text" name="diameter[]" value="" placeholder="đường kính [Inch]" style="width: 130px;"/>&nbsp;<input required id="sku" name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px;"/>&nbsp;<input required id="price"  name="price[]" type="number" min="0" name="price[]" value="" placeholder="giá bán" style="width: 100px;"/>&nbsp;<input required id="stock" name="stock[]" type="number" min="0" name="stock[]" value="" placeholder="tồn kho" style="width: 100px;"/><div style="width: 100%; margin-top: 10px;"><label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_embossed">Chữ Nổi: Có/Không</label><input id="hhose_spflex_embossed"  name="hhose_spflex_embossed[]" type="checkbox" name="hhose_spflex_embossed[]" value="Yes"/></div><div style="width: 100%;"><label style="font-weight: 500; color: #5c5c5c" for="hhose_spflex_smoothtexture">Da Trơn: Có/Không</label> <input id="hhose_spflex_smoothtexture"  name="hhose_spflex_smoothtexture[]" type="checkbox" name="hhose_spflex_smoothtexture[]" value="Yes"/></div><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button2"><i class="fas fa-trash"></i></a></div>'; //New input field html 
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
    var fieldHTML3 = '<div style="margin-top: 10px;"><input id="voltage"  name="voltage[]" type="number" min="0" name="voltage[]" value="" placeholder="nguồn điện [V]" style="width: 125px; margin-top: 5px;"/>&nbsp;<input id="power"  name="power[]" type="number" min="0" name="power[]" value="" placeholder="công suất [W]" style="width: 125px; margin-top: 5px;"/>&nbsp;<input id="maxflow"  name="maxflow[]" type="number" min="0" step="0.1" name="maxflow[]" value="" placeholder="lưu lượng [m³/h]" style="width: 135px; margin-top: 5px;"/>&nbsp;<input id="vertical"  name="vertical[]" type="number" min="0" step="0.1" name="vertical[]" value="" placeholder="đẩy cao [m]" style="width: 100px; margin-top: 5px;"/>&nbsp;<input id="indiameter"  name="indiameter[]" type="number" min="0" name="indiameter[]" value="" placeholder="họng hút [mm]" style="width: 125px; margin-top: 5px;"/>&nbsp;<input id="outdiameter"  name="outdiameter[]" type="number" min="0" name="outdiameter[]" value="" placeholder="họng xả [mm]" style="width: 125px; margin-top: 5px;"/>&nbsp;<input required id="sku"  name="sku[]" type="text" name="sku[]" value="" placeholder="mã SKU" style="width: 100px; margin-top: 5px;"/>&nbsp;<input required id="price"  name="price[]" type="number" min="0" name="price[]" value="" placeholder="giá bán" style="width: 100px; margin-top: 5px;"/>&nbsp;<input required id="stock"  name="stock[]" type="number" min="0" name="stock[]" value="" placeholder="tồn kho" style="width: 100px; margin-top: 5px;"/><a href="javascript:void(0);" title="xóa dòng dữ liệu" class="remove_button3">&nbsp;&nbsp;<i class="fas fa-trash"></i></a></div>'; //New input field html 
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

    // show/hide manual coupon
    $("#ManualCoupon").click(function(){
        $('#couponField').show();
    });

    $("#AutomaticCoupon").click(function(){
        $('#couponField').hide();
    });

     //Datemask dd/mm/yyyy
     $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
     //Datemask2 mm/dd/yyyy
     $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
     //Money Euro
     $('[data-mask]').inputmask()
});
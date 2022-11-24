function alert_success(types, txttype, txtmain, loaction) {
    if (types == "error") {
        Swal.fire({
            icon: types,
            title: txttype,
            text: txtmain
        }).then((result) => {
            if (result.value) {
                return false;
            }
        });



    } else if (loaction == "false") {

        Swal.fire({
            icon: types,
            title: txttype,
            text: txtmain
        }).then((result) => {
            if (result.value) {
                return false;
            }
        });
    } else {
        if (loaction == "reload") {
            Swal.fire({
                icon: types,
                title: txttype,
                text: txtmain
            }).then((result) => {
                if (result.value) {
                    location.reload();
                }
            });

        } else {
            Swal.fire({
                icon: types,
                title: txttype,
                text: txtmain
            }).then((result) => {
                if (result.value) {
                    window.location = loaction;
                }
            });

        }
    }


}




function how_del(t, id, p) {
    Swal.fire({
        title: "คุณต้องการลบข้อมูลใช่หรือไม่?",
        text: "ข้อมูลทั้งหมดที่เกี่ยวข้องกับรหัสนี้ จะถูกลบออกทั้งหมดทันที",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ใช่ ลบเลย!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "sql.php",
                type: "post",
                data: {
                    act: "del_data",
                    ids: id,
                    types: t,
                },
                success: function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "ทำรายการสำเร็จ",
                        text: "",
                    }).then((result) => {
                        if (result.value) {
                            if (p != "reload" && p != "") {
                                window.location = p;
                            } else {
                                location.reload();
                            }
                        }
                    });
                },
            });
        }
    });
}
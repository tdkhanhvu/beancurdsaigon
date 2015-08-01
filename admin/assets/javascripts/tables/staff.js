var serviceUrl = '../WebService.php';

$(function() {
    var db = {
        loadData: function(filter) {
            if (this.staffs == null){
                var d = $.Deferred(),
                    temp = this;
                $.ajax({
                    url: serviceUrl,
                    data: {'request':'GetAllStaffs'},
                    type: "post",
                    dataType: 'json'
                }).done(function(response) {
                    temp.staffs = [];

                    response.forEach(function(record) {
                        if (record['available'] == 1)
                            record['available'] = true;
                        else
                            record['available'] = false;
                        temp.staffs.push(record);
                    })
                    d.resolve(response);
                });

                return d.promise();
            }
            else {
                console.log('filter');
                return $.grep(this.staffs, function(staff) {
                return (!filter.id || staff.id.indexOf(filter.id) > -1)
                    && (!filter.name || staff.name === filter.name)
                    && (!filter.photo || staff.photo.indexOf(filter.photo) > -1)
                    && (!filter.phone || staff.phone === filter.phone)
                });
            }
        },
        insertItem: function(insertingClient) {
            this.staffs.push(insertingClient);
        },

        updateItem: function(updatingClient) {
            console.log(updatingClient);
            var avail = 0;

            if (updatingClient['available'])
                avail = 1;

            $.ajax({
                url: serviceUrl,
                data: {'request':'UpdateStaff','id': updatingClient['id'],
                        'name': updatingClient['name'],'image': updatingClient['image'],
                        'phone': updatingClient['phone'],'available': avail},
                type: "post",
                dataType: 'json'
            }).done(function(response) {
                alert('success');
            })
        },

        deleteItem: function(deletingClient) {
            var clientIndex = $.inArray(deletingClient, this.staffs);
            this.staffs.splice(clientIndex, 1);
        }

    };
    window.db = db;
    db.statuses = [];
    $.when(
        $.ajax({
            url: serviceUrl,
            data: {'request':'GetAllStatus'},
            type: "post",
            dataType: 'json'
        }).done(function(response) {
            response.forEach(function(status) {
                //console.log(status);
                db.statuses.push({'name': status['name'], 'id': status['id']});
            });
            console.log(db.statuses);
        })
        ).then(function() {
            $("#jsGrid").jsGrid({
                width: "800px",

                sorting: true,
                filtering: true,
                autoload: true,
                editing: true,
                paging: true,
                pageSize: 15,
                pageButtonCount: 5,

                deleteConfirm: "Do you really want to delete the client?",
                controller: db,
                rowClick: function(args) {
//                    var selectItem = args.item,
//                        product_tmpl = Handlebars.compile($("#product-template").html()),
//                        order_table = $('#order_table'),
//                        count = 1;
//                    $("#message").html(selectItem['message']);
//                    $("#date_create").html(selectItem['date_create']);
//                    $("#date_schedule").html(selectItem['date_schedule']);
//                    $("#date_deliver").html(selectItem['date_deliver']);
//
//                    $('#staff_name').html(selectItem['staff_name'] != null ? selectItem['staff_name']: '');
//                    $('#staff_phone').html(selectItem['staff_phone'] != null ? selectItem['staff_phone']: '');
//
//                    console.log(selectItem);
//
//                    //order
//                    order_table.html('');
//                    selectItem['products'].forEach(function(product) {
//                        $.extend(product, {
//                            'order': count,
//                            'total_cost' : parseInt(product['quantity']) * parseInt(product['price'])
//                        });
//                        order_table.append(product_tmpl(product));
//                        count += 1;
//                    });
//
//                    $("#beancurd_cost").html(selectItem['beancurd_cost']);
//                    $("#delivery_cost").html(selectItem['delivery_cost']);
//                    $("#discount_cost").html(selectItem['discount_cost']);
//                    $("#total_cost").html(selectItem['total_cost']);
//
//                    //contact
//                    $("#name").html(selectItem['contact_name']);
//                    $("#phone").html(selectItem['contact_phone']);
//                    $("#email").html(selectItem['contact_email']);
//                    $("#address").html(selectItem['contact_address']);
//
//
//                    $('#myModal').modal('show');
                },

                fields: [
                    { name: "id", title: "Id", type: "text", editing: false},
                    { name: "name", title: "Name", type: "text"},
                    { name: "image", title: "Photo", type: "text"},
                    { name: "phone", type: "text", title: "Phone"},
                    { name: "available", type: "checkbox", title: "Available", sorting: false },
                    {
                        type: "control",
                        modeSwitchButton: false,
                        editButton: false,
                        headerTemplate: function() {
                            return $("<button>").attr("type", "button").text("Add")
                                .on("click", function () {
                                    showDetailsDialog("Add", {});
                                });
                        }
                    }
                ]
            });

        });
});

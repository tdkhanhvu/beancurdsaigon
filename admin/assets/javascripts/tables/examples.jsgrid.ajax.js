var serviceUrl = '../WebService.php';

$(function() {
    var db = {
        loadData: function(filter) {
            if (this.orders == null){
                var d = $.Deferred(),
                    temp = this;
                $.ajax({
                    url: serviceUrl,
                    data: {'request':'GetOrders'},
                    dataType: 'json'
                }).done(function(response) {
                    temp.orders = response;
                    d.resolve(response);
                });

                return d.promise();
            }
            else {
                console.log('filter');
                return $.grep(this.orders, function(order) {
                    console.log('filter');
                    console.log(filter);
                    console.log('order');
                    console.log(order);
                    return (!filter.id || order.id.indexOf(filter.id) > -1)
                        && (!filter['contact_name'] || order['contact_name'].indexOf(filter['contact_name']) > -1)
                        && (!filter['contact_address'] || order['contact_address'].indexOf(filter['contact_address']) > -1)
                        && (!filter['date_schedule'] || order['date_schedule'] === filter['date_schedule'])
                        && (!filter['date_deliver'] || order['date_deliver'] === filter['date_deliver'])
                        && (filter.status == '0' || order.status === filter.status)
                        && (filter['staff_id'] == '0' || order['staff_id'] === filter['staff_id'])
                });
            }
        },
        insertItem: function(insertingOrder) {
            this.orders.push(insertingOrder);
        },

        updateItem: function(updatingOrder) {
            console.log(updatingOrder);
            $.ajax({
                url: serviceUrl,
                data: {'request':'UpdateOrder', 'order_id': updatingOrder['id'],
                        'staff_id': updatingOrder['staff_id'], 'status': updatingOrder['status']},
                type: "post",
                dataType: 'json'
            }).done(function(response) {
                alert('success');
                db.staffs.forEach(function(staff) {
                    if (staff['id'] == updatingOrder['staff_id']) {
                        updatingOrder['staff_phone'] = staff['phone'];
                        updatingOrder['staff_name'] = staff['name'];
                        updatingOrder['staff_image'] = staff['image'];
                    }
                });
            })
        },

        deleteItem: function(deletingOrder) {
            var orderIndex = $.inArray(deletingOrder, this.orders);
            this.orders.splice(orderIndex, 1);
        }

    };
    db.statuses = [];
    db.staffs = [];
    window.db = db;

    $.when(
        $.ajax({
            url: serviceUrl,
            data: {'request':'GetAllStatus'},
            type: "post",
            dataType: 'json'
        }).done(function(response) {
            response.forEach(function(status) {
                console.log(status);
                db.statuses.push({'name': status['name'], 'id': status['id']});
            });
            console.log(db.statuses);
        }),
        $.ajax({
            url: serviceUrl,
            data: {'request':'GetAllStaffs'},
            type: "post",
            dataType: 'json'
        }).done(function(response) {
            response.forEach(function(staff) {
                console.log(staff);
                db.staffs.push({'name': staff['name'], 'id': staff['id'], 'phone' : staff['phone']});
            });
            console.log(db.staffs);
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

                deleteConfirm: "Do you really want to delete the order?",
                controller: db,
                rowClick: function(args) {
                    var selectItem = args.item,
                        product_tmpl = Handlebars.compile($("#product-template").html()),
                        order_table = $('#order_table'),
                        count = 1;
                    $("#message").html(selectItem['message']);
                    $("#date_create").html(selectItem['date_create']);
                    $("#date_schedule").html(selectItem['date_schedule']);
                    $("#date_deliver").html(selectItem['date_deliver']);

                    $('#staff_name').html(selectItem['staff_name'] != null ? selectItem['staff_name']: '');
                    $('#staff_phone').html(selectItem['staff_phone'] != null ? selectItem['staff_phone']: '');

                    console.log(selectItem);

                    //order
                    order_table.html('');
                    selectItem['products'].forEach(function(product) {
                        $.extend(product, {
                            'order': count,
                            'total_cost' : parseInt(product['quantity']) * parseInt(product['price'])
                        });
                        order_table.append(product_tmpl(product));
                        count += 1;
                    });

                    $("#beancurd_cost").html(selectItem['beancurd_cost']);
                    $("#delivery_cost").html(selectItem['delivery_cost']);
                    $("#discount_cost").html(selectItem['discount_cost']);
                    $("#total_cost").html(selectItem['total_cost']);

                    //contact
                    $("#name").html(selectItem['contact_name']);
                    $("#phone").html(selectItem['contact_phone']);
                    $("#email").html(selectItem['contact_email']);
                    $("#address").html(selectItem['contact_address']);


                    $('#myModal').modal('show');
                },

                fields: [
                    { name: "id", title: "Id", type: "text", editing: false},
                    { name: "contact_name", title: "Contact Name", type: "text",editing: false},
                    { name: "contact_address", title: "Contact Address", type: "text",editing: false},
                    { name: "date_schedule", type: "text", title: "Date Schedule",editing: false},
                    { name: "date_deliver", type: "text", title: "Date Deliver"},
                    { name: "status", type: "select", title: "Status", items: db.statuses, valueField: "id", textField: "name",selectedIndex:0 },
                    { name: "staff_id", type: "select", title: "Staff", items: db.staffs, valueField: "id", textField: "name",selectedIndex:0 },
                    { type: "control" }
                ]
            });

        });
});

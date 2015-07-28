var serviceUrl = '../WebService.php';

$(function() {
    var db = {
        loadData: function() {
            var d = $.Deferred(),
                temp = this;
            $.ajax({
                url: 'http://localhost/oregano/WebService.php',
                data: {'request':'GetOrders'},
                dataType: 'json'
            }).done(function(response) {
                //console.log(response);
                temp.clients = response;
                d.resolve(response);
            });

            return d.promise();
        },
        insertItem: function(insertingClient) {
            this.clients.push(insertingClient);
        },

        updateItem: function(updatingClient) {
            console.log(updatingClient);
        },

        deleteItem: function(deletingClient) {
            var clientIndex = $.inArray(deletingClient, this.clients);
            this.clients.splice(clientIndex, 1);
        }

    };

    db.countries = [
        { Name: "Hello", Id: "0" },
        { Name: "United States", Id: "1" },
        { Name: "Canada", Id: "2" },
        { Name: "United Kingdom", Id: "3" },
        { Name: "France", Id: "4" },
        { Name: "Brazil", Id: "5" },
        { Name: "China", Id: "6" },
        { Name: "Russia", Id: "7" }
    ];

    window.db = db;

    $("#jsGrid").jsGrid({
        width: "800px",

        sorting: true,

        autoload: true,
        editing: true,
        paging: true,
        pageSize: 15,
        pageButtonCount: 5,

        deleteConfirm: "Do you really want to delete the client?",
        controller: db,
        rowClick: function(args) {
            var selectItem = args.item;
            $("#message").html(selectItem['message']);
            $("#date_create").html(selectItem['date_create']);
            //console.log(selectItem);
            $('#myModal').modal('show');
        },

        fields: [
            { name: "id", title: "Id", type: "text", editing: false},
            { name: "contact_name", title: "Contact Name", type: "text",editing: false},
            { name: "contact_phone", title: "Contact Phone", type: "text",editing: false},
            { name: "contact_address", title: "Contact Address", type: "text",editing: false},
            { name: "date_schedule", type: "text", title: "Date Schedule"},
            { name: "status", type: "select", title: "Status", items: db.countries, valueField: "Id", textField: "Name",selectedIndex:0 },
            //{ name: "Married", type: "checkbox", title: "Is Married", sorting: false },
            { type: "control" }
        ]
    });
});

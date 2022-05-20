<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col col-md-hide"></div>
            <div class="col">
                <form action="logic.php" method="POST">
                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="text" placeholder="Enter your text here"
                                name="todoTask" />
                        </div>
                        <div class="col">
                            <button class="btn btn-sm btn-info" type="submit" name="addTodo"
                                value="Add Task">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h4 class="text-center">Task List</h4>
                <div class="list">

                </div>
            </div>
            <div class="col">

            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="logic.php" method="POST">
                        <div class="row">
                            <div class="col">
                                <input class="form-control" style="display:none;" type="text"
                                    placeholder="Enter your text here" name="todoTaskUpdateId" />
                                <input class="form-control" type="text" placeholder="Enter your text here"
                                    name="todoTaskUpdate" />
                            </div>
                            <div class="col">
                                <button class="btn btn-sm btn-info" type="submit" name="updateTodo"
                                    value="Update Task">Update
                                    Task</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script type="text/javascript">
(function() {
    var taskList;
    getTodos();
}());

function getTodos() {
    $("div.list").html("");
    $.ajax({
        method: "POST",
        type: "json",
        data: {
            "getTodos": "getTodos"
        },
        url: "./logic.php",
        success: function(data) {
            console.log(data);
            taskList = JSON.parse(data);
            var i = 0;
            $.map(JSON.parse(data), function(todo) {
                console.log(todo.id);
                i += 1;
                $("div.list").append("<p>" +
                    i + ". " + todo.task + "</p>" +
                    "<button class='btn btn-xs btn-warning' onClick='updateTodo(" + todo.id +
                    ")' type='button' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button>&emsp;" +
                    "<button class='btn btn-xs btn-danger' onClick='deleteTodo(" + todo.id +
                    ")' type='button'>Delete</button>");
            });
        },
        error: function() {

        }
    });
}

function updateTodo(id) {
    $.map(taskList,
        function(todo) {
            if (id == todo.id) {
                $("input[name='todoTaskUpdateId']").val(todo.id);
                $("input[name='todoTaskUpdate']").val(todo.task);
            }
        });
}

function deleteTodo(id) {
    $.ajax({
        method: "POST",
        type: "json",
        data: {
            "id": id,
            "deleteTodo": "deleteTodo"
        },
        url: "./logic.php",
        success: function(data) {
            console.log(data);
            if (data == true) {
                alert("Deleted")
            } else {
                alert("Error deleting. Check log");
            }
            getTodos();
        },
        error: function() {

        }
    });
}
</script>

</html>
// Here's my data model

$(function() {

    function Task() {
        var self = this;
        this.id = ko.observable();
        this.title = ko.observable("");
        this.isDone = ko.observable(false);

        self.putTask = function() {
            $.ajax("/tasks/"+self.id(), {
                data: ko.toJSON(self),
                type: "put", contentType: "application/json"
            });
        };

        this.title.subscribe(function() {
            self.putTask();
        });

        this.isDone.subscribe(function() {
            self.putTask();
        });
    }

    function TaskListViewModel() {
        // Data
        var self = this;
        self.tasks = ko.observableArray();
        self.all = ko.observable(false);

        self.getTasks = function() {
            $.getJSON("/tasks", function(data) {
                ko.mapping.fromJS(data.tasks, mapping, self.tasks);
            });
        };

        var mapping = {
            create: function(options) {
                var task = new Task();
                task.id(options.data.id);
                task.title(options.data.title);
                task.isDone(options.data.is_done);
                return  task;
            }
        };

        self.getTasks();

        self.incompleteTasks = ko.computed(function() {
            return ko.utils.arrayFilter(self.tasks(), function(task) {
                return !task.isDone()
            });
        });

        self.addTask = function() {
            var task = new Task({ title: " "});
            self.tasks.push(task);
            $.ajax("/tasks", {
                data: ko.toJSON(task),
                type: "post", contentType: "application/json",
                success: function() {
                    self.getTasks();
                }
            });
        };

        self.removeTask = function(task) {
            $.ajax("/tasks/"+task.id(), {
                type: "delete",
                success: function() {
                    self.tasks.remove(task)
                }
            });
        };

        self.newitem = function() {
            $.ajax("/tasks", {
                data: ko.toJSON(new Task({ title: "new task"})),
                type: "post", contentType: "application/json"
            });
        };

        self.checkAll = function() {
            for (var i = 0; i < self.tasks().length; i++)
                self.tasks()[i].isDone(true);
        }

    }

    ko.applyBindings(new TaskListViewModel());

});
// Here's my data model

$(function() {

    function Task() {
        this.id = ko.observable();
        this.title = ko.observable();
        this.isDone = ko.observable();
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

        // Operations
        self.addTask = function() {
            self.tasks.push(new Task({ title: ""}));
        };

        self.deleteAll = function() {
            self.tasks.removeAll();
        };


        self.removeTask = function(task) {
            $.ajax("/tasks/"+task.id(), {
                type: "delete",
                success: function() {
                    self.getTasks();
                }
            });
        };

        self.saveCurrent = function(task) {
            console.log(task);
        };

        self.save = function(task) {
            $.ajax("/tasks/"+task.id(), {
                data: ko.toJSON(task),
                type: "post", contentType: "application/json",
                success: function() {
                    self.getTasks();
                }
            });
        };

        self.checkAll = function() {
            for (var i = 0; i < self.tasks().length; i++)
                self.tasks()[i].isDone(true);
        }


    }

    ko.applyBindings(new TaskListViewModel());

});